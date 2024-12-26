<?php
include __DIR__ . '/../../includes/db.php';
require '../../vendor/autoload.php'; // Adjust the path as necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicationId'])) {
  $applicationId = $_POST['applicationId'];

  try {
    // Fetch the existing BusinessPermitImage, email, and business name from the database
    $stmt = $pdo->prepare("
            SELECT ba.BusinessPermitImage, ba.Email, bi.BusinessName 
            FROM businessapplicationform ba
            JOIN businessinformationform bi ON ba.ApplicationID = bi.ApplicationID
            WHERE ba.ApplicationID = ?
        ");
    $stmt->execute([$applicationId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      $oldImage = $result['BusinessPermitImage'];
      $email = $result['Email'];
      $businessName = $result['BusinessName'];

      // Extract the unique ID and base name from the existing image name
      $parts = explode('-', $oldImage);
      $uniqueID = $parts[0];
      $baseName = implode('-', array_slice($parts, 1)); // Get the base name with extension

      // Define the paths
      $oldImagePath = __DIR__ . '/../../businessowner/uploadsapp/' . $oldImage;
      $newImagePath = __DIR__ . '/../../businessowner/uploadsapp/newPermit/' . $uniqueID . '-' . $baseName;
      $newImageDestination = __DIR__ . '/../../businessowner/uploadsapp/' . $uniqueID . '-' . $baseName;

      // Move the new permit image to the old permit image location
      if (file_exists($newImagePath)) {
        if (file_exists($oldImagePath)) {
          unlink($oldImagePath); // Delete the old permit image
        }
        rename($newImagePath, $newImageDestination); // Move the new permit image
      }

      // Update the database
      $stmt = $pdo->prepare("UPDATE businessapplicationform 
                                   SET ReminderSent = 0, 
                                       isRenew = 1, 
                                       reuploadDate = NULL, 
                                       PermitExpDate = newPermitDate, 
                                       newPermitDate = NULL, 
                                       BusinessPermitImage = ? 
                                   WHERE ApplicationID = ?");
      $stmt->execute([$uniqueID . '-' . $baseName, $applicationId]);

      // Update business_media isActive if it is 0
      $updateMediaStmt = $pdo->prepare("UPDATE business_media bm
JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
SET bm.isActive = 1
WHERE bif.ApplicationID = ? AND bm.isActive = 0");
      $updateMediaStmt->execute([$applicationId]);

      // Send an email notification
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'majayjaytourist4005@gmail.com';
      $mail->Password = 'ilnppweayuuzknzi';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('majayjaytourist4005@gmail.com', 'Majayjay Tourist Admin');
      $mail->addAddress($email);

      $mail->isHTML(true);
      $mail->Subject = 'Business Permit Renewal Approved';
      $mail->Body = "
                <p>Dear {$businessName},</p>
                <p>We are pleased to inform you that your business permit renewal has been approved! Congratulations on uploading a new business permit for this process.</p>
                <p>You can now continue to manage and advertise your business on our website.</p>
                <p>Thank you for your compliance and effort. We look forward to supporting your business endeavors.</p>
                <p>Sincerely,<br>Tourism Office<br>Majayjay, Laguna</p>
            ";

      $mail->send();

      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['error' => 'Business permit not found.']);
    }
  } catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
  } catch (Exception $e) {
    echo json_encode(['error' => 'Mail error: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}
