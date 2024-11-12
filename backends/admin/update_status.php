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
        $qrData = "https://majayjaytourism.ngrok.io/../businessowner/estab-demog.php?id={$applicationID}";
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

        // Retrieve the QR code path
        $stmt = $pdo->prepare('SELECT qr_code FROM account WHERE AccountID = :accountID');
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
        $stmt->execute();
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
        $qrCodeFilePath = $account['qr_code'];

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

        // Attach the QR code image
        $mail->addAttachment($qrCodeFilePath);

        $mail->isHTML(true);
        $mail->Subject = 'Business Application Approved';
        $mail->Body = '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Application Approval</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 16px; line-height: 1.4; background-color: #f4f5f6; padding: 0; margin: 0;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #f4f5f6; margin: 0; padding: 20px;">

    <tr>
      <td align="center">
        <div style="max-width: 600px; background: #ffffff; border: 1px solid #eaebed; border-radius: 16px; overflow: hidden;">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; padding: 24px;">
            <tr>
              <td style="padding: 24px;">
                <img src="https://majayjaytourism.ngrok.io/login.php/img/general-img/majayjay-logo.webp" alt="Majayjay Logo" style="display: block; margin: auto;" height="80" width="80">
                <p style="margin: 0 0 16px; font-size: 18px; color: #333;">Dear Business Owner,</p>
                <p style="margin: 0 0 16px; font-size: 16px; color: #333;">Congratulations! Your business application has been approved. You can now log in with the following details:</p>
                <p style="margin: 0 0 16px; font-size: 16px; color: #333;"><strong>Email:</strong> <span style="color: #333;">' . $email . '</span></p>
                <p style="margin: 0 0 16px; font-size: 16px; color: #333;"><strong>Password:</strong> <span style="color: #333;">' . $password . '</span></p>
                <a href="your-login-page-link" style="display: inline-block; padding: 12px 24px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px; border: 2px solid #007bff; text-align: center;">Log In</a>

                <p style="margin: 0 0 16px; font-size: 16px; color: #333;">We encourage you to log in and start posting your amenities to attract more visitors. If you have any questions, feel free to contact our support team.</p>
                <p style="margin: 0 0 16px; font-size: 16px; color: #333;">Here is the generated QR code of your establishment. The visitors will scan this and fill up the form in order to add their demographics to the database.</p>
                <p style="margin: 0 0 16px; font-size: 16px; color: #333;">Best regards,<br><strong>Majayjay Tourist Admin</strong></p>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 16px; text-align: center;">
                  <tr>
                    <td align="center">
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <div style="text-align: center; font-size: 14px; color: #9a9ea6; margin-top: 20px;">
    <p style="font-size: 14px; color: #9a9ea6;">Majayjay, Laguna, Philippines</p>
    <p>Powered By: HaKingz</p>
  </div>
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Application Rejected</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f5f6; margin: 0; padding: 0;">
  <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #f4f5f6; padding: 20px;">
    <tr>
      <td>
        <div style="max-width: 600px; background-color: #ffffff; border: 1px solid #eaebed; border-radius: 16px; margin: 20px auto; padding: 24px;">
          <img src="https://majayjaytourism.ngrok.io/../../img/general-img/majayjay-logo.webp" alt="Majayjay Logo" style="display: block; margin: auto;" height="80" width="80">
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Dear Business Owner,</p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">We regret to inform you that your business application has been rejected for the following reasons:</p>
          <ul style="font-size: 16px; color: #333; margin: 0 0 16px; padding-left: 20px;">';
        foreach ($rejectReasons as $reason) {
          $mail->Body .= '<li style="margin: 0 0 8px;">' . htmlspecialchars($reason) . '</li>';
        }
        $mail->Body .= '</ul>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">You can use the following reference number to re-apply your application:</p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;"><strong>Reference Number:</strong> ' . htmlspecialchars($refNum) . '</p>
          <a href="your-support-page-link" style="display: inline-block; padding: 12px 24px; margin-bottom: 20px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px; border: 2px solid #007bff; text-align: center;">Re-apply Now</a>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">If you have any questions, feel free to contact our support team.</p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Best regards,<br><strong>Majayjay Tourist Admin</strong></p>

        </div>
      </td>
    </tr>
  </table>
  <div style="text-align: center; font-size: 14px; color: #9a9ea6; margin-top: 20px;">
    <p style="font-size: 14px; color: #9a9ea6;">Majayjay, Laguna, Philippines</p>
    <p>Powered By: HaKingz</p>
  </div>
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
