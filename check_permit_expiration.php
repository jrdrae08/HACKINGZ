<?php

require './vendor/autoload.php'; // Adjust the path as necessary

// Include database connection
include './includes/db.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

try {
  // Set the timezone to Asia/Hong_Kong
  $timezone = new DateTimeZone('Asia/Hong_Kong');
  $currentDate = new DateTime('now', $timezone);
  $endOfYear = new DateTime('last day of December', $timezone);

  // Calculate the renewal end date (January 20th of the next year)
  $nextYear = (int)$currentDate->format('Y') + 1;
  $renewalEndDate = new DateTime("{$nextYear}-01-20", $timezone);

  // Query the database for permits expiring on December 31st, with status 'Approved', and ReminderSent = 0
  $stmt = $pdo->prepare('SELECT ApplicationID, Email, PermitExpDate, RefNum, RegistrantFirstName, RegistrantMiddleName, RegistrantLastName FROM businessapplicationform WHERE PermitExpDate = :endOfYear AND Status = "Approved" AND ReminderSent = 0');
  $stmt->bindParam(':endOfYear', $endOfYear->format('Y-m-d'), PDO::PARAM_STR);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($results as $row) {
    $applicationID = $row['ApplicationID'];
    $email = $row['Email'];
    $permitExpDate = new DateTime($row['PermitExpDate']);
    $refNum = $row['RefNum'];

    // Fetch the business owner's name
    $ownerName = $row['RegistrantFirstName'];
    if (!empty($row['RegistrantMiddleName'])) {
      $ownerName .= ' ' . $row['RegistrantMiddleName'];
    }
    $ownerName .= ' ' . $row['RegistrantLastName'];

    // Calculate the number of days left until the renewal period ends
    $daysLeft = $currentDate->diff($renewalEndDate)->days;

    // Send reminder email
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

    // Attach the logo image and set the Content-ID
    $mail->addEmbeddedImage('./img/general-img/majayjay-logo.webp', 'logo_cid'); // Adjust the path as necessary

    $mail->isHTML(true);
    $mail->Subject = 'Business Permit Expiration Reminder';
    $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Permit Expiration Reminder</title>
  <style>
    .countdown {
      font-size: 24px;
      color: #333;
      text-align: center;
      margin: 20px 0;
    }
  </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f5f6; margin: 0; padding: 0;">
  <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #f4f5f6; padding: 20px;">
    <tr>
      <td>
        <div style="max-width: 600px; background-color: #ffffff; border: 1px solid #eaebed; border-radius: 16px; margin: 20px auto; padding: 24px;">
          <img src="cid:logo_cid" alt="Majayjay Logo" style="display: block; margin: auto;" height="80" width="80">
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Dear ' . $ownerName . ',</p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">This is a reminder that your business permit is set to expire on ' . $permitExpDate->format('Y-m-d') . '.</p>
          <div class="countdown">Days left to renew: ' . $daysLeft . '</div>
            <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Please take the necessary steps to renew your permit. The renewal period starts on January 1 and ends on January 20, ' . $nextYear . '.</p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Your reference number is: <strong>' . $refNum . '</strong>. You can use this reference number to renew your business permit by visiting the following link:</p>
          <p><a href="https://majayjaytourism.ngrok.io/businessowner/enter_renew_code.php">Renew Your Business Permit</a></p>
          <p style="font-size: 16px; color: #333; line-height: 1.4; margin: 0 0 16px;">Best regards,<br><strong>Majayjay Tourist Admin</strong></p>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>';

    $mail->send();

    // Update the ReminderSent column to 1
    // Update ReminderSent and reset isRenew if conditions met
    $updateStmt = $pdo->prepare('
        UPDATE businessapplicationform 
        SET 
            ReminderSent = 1,
            isRenew = CASE 
                WHEN ReminderSent = 1 AND isRenew = 1 THEN 0
                ELSE isRenew 
            END
        WHERE ApplicationID = :applicationID
    ');
    $updateStmt->bindParam(':applicationID', $applicationID, PDO::PARAM_INT);
    $updateStmt->execute();
  }
  // Update isActive in business_media if PermitExpDate is in the past and ReminderSent is 1
  $updateMediaStmt = $pdo->prepare('
  UPDATE business_media bm
  JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
  JOIN businessapplicationform baf ON bif.ApplicationID = baf.ApplicationID
  SET bm.isActive = 0
  WHERE baf.PermitExpDate < CURDATE() AND baf.ReminderSent = 1
');
  $updateMediaStmt->execute();
  echo 'Reminder emails sent successfully.';
} catch (Exception $e) {
  error_log('Failed to send reminder emails: ' . $e->getMessage());
  echo 'Failed to send reminder emails.';
}
