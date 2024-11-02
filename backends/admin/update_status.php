<?php
// Include Composer autoload
require '../../vendor/autoload.php'; // Adjust the path as necessary

// Include database connection
include '../../includes/db.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include QR Code library
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

// Enable error logging for debugging
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$applicationID = $data['ApplicationID'] ?? null;
$status = $data['Status'] ?? null;
$isReject = $data['IsReject'] ?? 0;
$rejectReasons = $data['RejectReasons'] ?? [];

// Default response
$response = ['success' => false];

try {
  if ($applicationID && $status) {
    $pdo->beginTransaction();

    // Update the status and IsReject fields
    $stmt = $pdo->prepare('UPDATE businessapplicationform SET Status = :status, IsReject = :isReject WHERE ApplicationID = :applicationID');
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':isReject', $isReject, PDO::PARAM_INT);
    $stmt->bindParam(':applicationID', $applicationID, PDO::PARAM_INT);
    $stmt->execute();

    // Get the email and reference number from the businessapplicationform
    $stmt = $pdo->prepare('SELECT Email, RefNum FROM businessapplicationform WHERE ApplicationID = :applicationID');
    $stmt->bindParam(':applicationID', $applicationID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $email = $result['Email'];
    $refNum = $result['RefNum'];

    if ($email) {
      if ($status === 'Approved') {
        // Generate a random password
        $password = bin2hex(random_bytes(4)); // 8-character random password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new account into the account table
        $stmt = $pdo->prepare('INSERT INTO account (ApplicationID, Email, PasswordHash, BusinessStatus) VALUES (:applicationID, :email, :passwordHash, "Active")');
        $stmt->bindParam(':applicationID', $applicationID, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();

        // Get the last inserted AccountID
        $accountID = $pdo->lastInsertId();

        // Generate QR code
        $qrData = "https://bb54-136-158-66-65.ngrok-free.app/../businessowner/estab-demog.php?id={$applicationID}";
        $qrCode = new QrCode($qrData);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getString();

        // Save the QR code image to the server
        $qrCodeFileName = uniqid() . '.png';
        $qrCodeFilePath = '../../businessowner/qrCode/' . $qrCodeFileName;
        if (file_put_contents($qrCodeFilePath, $qrCodeImage) === false) {
          throw new Exception('Failed to save QR code image.');
        }

        // Update the account table with the QR code path
        $stmt = $pdo->prepare('UPDATE account SET qr_code = :qr_code WHERE AccountID = :accountID');
        $stmt->bindParam(':qr_code', $qrCodeFilePath, PDO::PARAM_STR);
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        // Send an email with the account details
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
        $mail->Subject = 'Business Application Approved';
        $mail->Body = '
<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Business Application Approved</title>
  </head>
  <body>
    <p>Dear Business Owner,</p>
    <p>Congratulations! Your business application has been approved. You can now log in with the following details:</p>
    <p>Email: ' . $email . '</p>
    <p>Password: ' . $password . '</p>
    <p>We encourage you to log in and start posting your amenities to attract more visitors. If you have any questions, feel free to contact our support team.</p>
    <p>Best regards,<br>Majayjay Tourist Admin</p>
  </body>
</html>';

        $mail->send();

        $response['success'] = true;
      } elseif ($status === 'Rejected') {
        // Commit the transaction
        $pdo->commit();

        // Send an email with the rejection reasons and reference number
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
        $mail->Subject = 'Business Application Rejected';
        $mail->Body = '
<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Business Application Rejected</title>
  </head>
  <body>
    <p>Dear Business Owner,</p>
    <p>We regret to inform you that your business application has been rejected for the following reasons:</p>
    <ul>';
        foreach ($rejectReasons as $reason) {
          $mail->Body .= '<li>' . htmlspecialchars($reason) . '</li>';
        }
        $mail->Body .= '</ul>
    <p>You can use the following reference number to re-apply your application:</p>
    <p>Reference Number: ' . htmlspecialchars($refNum) . '</p>
    <p>If you have any questions, feel free to contact our support team.</p>
    <p>Best regards,<br>Majayjay Tourist Admin</p>
  </body>
</html>';

        $mail->send();

        $response['success'] = true;
      }
    } else {
      // Email was not found
      $pdo->rollBack();
      $response['error'] = 'Failed to retrieve email for ApplicationID ' . $applicationID;
    }
  } else {
    $response['error'] = 'Invalid ApplicationID or Status';
  }
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  $response['error'] = 'Failed to update status: ' . $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
