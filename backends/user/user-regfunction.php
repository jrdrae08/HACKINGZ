<?php
session_start();
require_once '../../includes/db.php';
require '../../vendor/autoload.php'; // Adjust the path as necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

function compressAndConvertToWebP($file, $targetDir, $newFileName)
{
  $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  $webp_image_name = $newFileName . '.webp';
  $webp_target_file = $targetDir . $webp_image_name;

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $image = imagecreatefromjpeg($file["tmp_name"]);
      break;
    case 'png':
      $image = imagecreatefrompng($file["tmp_name"]);
      // Convert palette-based image to true color
      if (imageistruecolor($image) === false) {
        $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $image = $trueColorImage;
      }
      break;
    case 'gif':
      $image = imagecreatefromgif($file["tmp_name"]);
      // Convert palette-based image to true color
      if (imageistruecolor($image) === false) {
        $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $image = $trueColorImage;
      }
      break;
    case 'webp':
      $image = imagecreatefromwebp($file["tmp_name"]);
      break;
    default:
      $image = null;
      break;
  }

  if ($image && imagewebp($image, $webp_target_file, 80)) {
    imagedestroy($image);
    return $webp_image_name;
  } else {
    return null;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize input data
  $fname = filter_var(trim($_POST['fname']), FILTER_SANITIZE_STRING);
  $lname = filter_var(trim($_POST['lname']), FILTER_SANITIZE_STRING);
  $full_name = $fname . ' ' . $lname;

  $u_email = filter_var(trim($_POST['u_email']), FILTER_SANITIZE_EMAIL);
  $u_contact = filter_var(trim($_POST['u_contact']), FILTER_SANITIZE_STRING);
  $u_address = filter_var(trim($_POST['u_address']), FILTER_SANITIZE_STRING);
  $locationType = filter_var(trim($_POST['locationType']), FILTER_SANITIZE_STRING);
  $sex = filter_var(trim($_POST['sex']), FILTER_SANITIZE_STRING);

  // Sanitize and handle ID type safely
  $id_type = $_POST['id_type'] === 'other'
    ? filter_var(trim($_POST['other_id_type']), FILTER_SANITIZE_STRING)
    : filter_var(trim($_POST['id_type']), FILTER_SANITIZE_STRING);

  try {
    // Check if the email is valid after sanitization
    if (!filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
      exit();
    }

    // Check if email already exists securely
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE u_email = ?");
    $stmt->execute([$u_email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
      echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
      exit();
    }

    // Insert sanitized user data into the database
    $stmt = $pdo->prepare("INSERT INTO users (full_name, u_email, u_contact, u_address, locationType, sex, id_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $u_email, $u_contact, $u_address, $locationType, $sex, $id_type]);

    // Get the last inserted user ID
    $userId = $pdo->lastInsertId();

    // Create a directory for the user
    $userDir = "../../user/userID/" . $lname . "/";
    if (!is_dir($userDir)) {
      mkdir($userDir, 0755, true);
    }

    // Generate unique filenames for the uploaded files
    $front_id_filename = $lname . "_" . $userId . "_front";
    $back_id_filename = $lname . "_" . $userId . "_back";

    // Upload and compress files
    $front_id = compressAndConvertToWebP($_FILES['front_id'], $userDir, $front_id_filename);
    $back_id = isset($_FILES['back_id']) && $_FILES['back_id']['error'] == 0 ? compressAndConvertToWebP($_FILES['back_id'], $userDir, $back_id_filename) : null;

    if ($front_id === null || ($back_id === null && isset($_FILES['back_id']) && $_FILES['back_id']['error'] == 0)) {
      echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
      exit();
    }

    // Update the user record with the file paths
    $stmt = $pdo->prepare("UPDATE users SET front_id = ?, back_id = ? WHERE userId = ?");
    $stmt->execute([$front_id, $back_id, $userId]);

    // Insert into useraccount table
    $stmt = $pdo->prepare("INSERT INTO useraccount (userID, email, passcode, created_at, IsConfirm) VALUES (?, ?, ?, NOW(), 0)");
    $stmt->execute([$userId, $u_email, '']);

    // Send confirmation email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'majayjaytourist4005@gmail.com'; // Replace with your email
    $mail->Password = 'ilnppweayuuzknzi'; // Replace with your email password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('majayjaytourist4005@gmail.com', 'Majayjay Admin'); // Replace with your email and name
    $mail->addAddress($u_email);

    $mail->isHTML(true);
    $mail->Subject = 'Registration Successful';
    $mail->Body = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Simple Transactional Email</title>
      </head>
      <body style="font-family: Helvetica, sans-serif; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.3; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f4f5f6; margin: 0; padding: 0;">
        <table role="presentation" style="width: 100%; background-color: #f4f5f6; padding: 0; margin: 0;">
          <tr>
            <td>&nbsp;</td>
            <td style="max-width: 600px; padding: 0; padding-top: 24px; width: 600px; margin: 0 auto;">
              <div style="display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                <table role="presentation" style="background: #ffffff; border: 1px solid #eaebed; border-radius: 16px; width: 100%;">
                  <tr>
                    <td style="box-sizing: border-box; padding: 24px 50px;">
                      <img src="https://majayjaytourism.ngrok.io/../../img/general-img/majayjay-logo.webp" alt="" style="display: block; margin: auto;" height="80" width="80">
                      <p style="font-size: 16px; color: #333; line-height: 1.4;">Mabuhay! ' . $full_name . ',</p>
                      <p style="font-size: 16px; color: #333; line-height: 1.4;">Click the Button below to verify your registration.</p>
                      <table role="presentation" style="width: 100%; max-width: 100%; margin-top: 16px;">
                        <tbody>
                          <tr>
                            <td align="left">
                              <table role="presentation" style="width: 100%; max-width: 100%; border-spacing: 0; border-collapse: collapse;">
                                <tbody>
                                  <tr>
                                    <td align="center" style="background-color: #198754; border: solid 2px #198754; border-radius: 4px;">
                                      <a href="https://majayjaytourism.ngrok.io/backends/user/verify.php?userID=' . $userId . '" target="_blank" style="display: inline-block; padding: 12px 24px; font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; text-transform: capitalize; background-color: #198754; border-color: #198754;">Verify Now</a>
                                    </td>
                                  </tr> 
                                </tbody> 
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <p style="font-size: 16px; color: #333; line-height: 1.4; text-align: justify; margin-top: 16px;">After you complete verification, you’ll gain full access to start booking your favorite destinations in Majayjay, Laguna! Explore the area\'s beautiful spots and unique accommodations, and easily reserve the places you’ve been dreaming of visiting. Don’t miss the chance to experience the charm of Majayjay – start booking today!</p>
                      <p style="font-size: 16px; color: #333; line-height: 1.4; margin-top: 16px;">Thank You!</p>
                      <p style="font-size: 16px; color: #333; line-height: 1.4; margin-top: 16px;">Best regards, Majayjay Admin</p>
                    </td>
                  </tr>
                </table>
                <div style="text-align: center; font-size: 14px; color: #9a9ea6; margin-top: 20px;">
                  <p style="font-size: 14px; color: #9a9ea6;">Majayjay, Laguna, Philippines</p>
                  <p style="font-size: 14px; color: #9a9ea6;">Powered By: HaKingz</p>
                </div>
              </div>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </body>
      </html>
    ';

    $mail->send();

    echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Email sending failed: ' . $e->getMessage()]);
  }

  exit();
}
