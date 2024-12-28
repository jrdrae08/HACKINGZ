<?php
include __DIR__ . '/../../includes/db.php';
require '../../vendor/autoload.php'; // Adjust the path as necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicationId']) && isset($_POST['reasons'])) {
  $applicationId = $_POST['applicationId'];
  $reasons = $_POST['reasons'];

  error_log('Received applicationId: ' . $applicationId); // Log the applicationId

  try {
    // Fetch the email and business name from the database
    $stmt = $pdo->prepare("
            SELECT ba.Email, bi.BusinessName, ba.BusinessPermitImage 
            FROM businessapplicationform ba
            JOIN businessinformationform bi ON ba.ApplicationID = bi.ApplicationID
            WHERE ba.ApplicationID = ?
        ");
    $stmt->execute([$applicationId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    error_log('Query result: ' . print_r($result, true)); // Log the query result

    if ($result) {
      $email = $result['Email'];
      $businessName = $result['BusinessName'];
      $oldImage = $result['BusinessPermitImage'];

      // Extract the unique ID and base name from the existing image name
      $parts = explode('-', $oldImage);
      $uniqueID = $parts[0];
      $baseName = implode('-', array_slice($parts, 1)); // Get the base name with extension

      // Define the path for the new permit image
      $newImagePath = __DIR__ . '/../../businessowner/uploadsapp/newPermit/' . $uniqueID . '-' . $baseName;

      // Delete the new permit image if it exists
      if (file_exists($newImagePath)) {
        unlink($newImagePath);
      }
      // Update the database
      $stmt = $pdo->prepare("UPDATE businessapplicationform 
                       SET newPermitDate = NULL, 
                           reuploadDate = NULL, 
                           renewalReject = 1 
                       WHERE ApplicationID = ?");
      $stmt->execute([$applicationId]);
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
      $mail->Subject = 'Business Permit Renewal Rejected';
      $mail->Body = "
                <p>Dear {$businessName},</p>
                <p>We regret to inform you that your business permit renewal has been rejected for the following reasons:</p>
                <ul>
                    " . implode('', array_map(fn($reason) => "<li>{$reason}</li>", $reasons)) . "
                </ul>
                <p>Please address the issues and re-upload the correct business permit.</p>
                <p>Sincerely,<br>Tourism Office<br>Majayjay, Laguna</p>
            ";

      $mail->send();

      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['error' => 'Business permit not found.']);
    }
  } catch (PDOException $e) {
    error_log('Query failed: ' . $e->getMessage()); // Log the error
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
  } catch (Exception $e) {
    error_log('Mail error: ' . $e->getMessage()); // Log the error
    echo json_encode(['error' => 'Mail error: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}
