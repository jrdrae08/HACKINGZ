<?php
include '../../includes/db.php';
session_start();

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('PHPMAILER_PATH', 'E:/HACKINGZ/phpmailer/src/');
require PHPMAILER_PATH . 'Exception.php';
require PHPMAILER_PATH . 'PHPMailer.php';
require PHPMAILER_PATH . 'SMTP.php';

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $revID = $data['revID'];
  $status = $data['status'];
  $reasons = isset($data['reasons']) ? $data['reasons'] : [];

  try {
    $pdo->beginTransaction();

    // Update the reservation status
    $stmt = $pdo->prepare("UPDATE reservations SET status = :status WHERE revID = :revID");
    $stmt->execute(['status' => $status, 'revID' => $revID]);

    // Fetch the reservation details along with the business name, address, check-in/check-out times, total number of attendees, and payment details
    $stmt = $pdo->prepare("
    SELECT r.roomName, res.checkin, res.departure, res.fullname, res.regemail, 
           res.referenceNum, b.BusinessName, b.BusinessAddress, r.timeStart, 
           r.timeEnd, u.totalnumAttendees, p.IsPaid, p.gcashReference,
           rp.totalPrice
    FROM reservations AS res
    JOIN roominfotable AS r ON res.roomID = r.roomID
    JOIN businessinformationform AS b ON r.BusinessInfoID = b.BusinessInfoID
    JOIN userdemographics AS u ON res.userID = u.userID AND res.roomID = u.roomID
    LEFT JOIN userpayment AS p ON res.userID = p.userID AND res.roomID = p.roomID
    LEFT JOIN reservation_payments rp ON res.revID = rp.revID
    WHERE res.revID = :revID
");
    $stmt->execute(['revID' => $revID]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
      // Format the check-in and check-out dates
      $checkinDate = new DateTime($reservation['checkin']);
      $formattedCheckin = $checkinDate->format('F j, Y');

      $departureDate = new DateTime($reservation['departure']);
      $formattedDeparture = $departureDate->format('F j, Y');

      // Format the check-in and check-out times
      $timeStart = new DateTime($reservation['timeStart']);
      $formattedTimeStart = $timeStart->format('g:i A');

      $timeEnd = new DateTime($reservation['timeEnd']);
      $formattedTimeEnd = $timeEnd->format('g:i A');

      if ($status === 'Rejected') {
        sendRejectionEmail($reservation, $reasons);
      } else {
        sendEmailNotification($reservation, $status, $formattedCheckin, $formattedDeparture, $formattedTimeStart, $formattedTimeEnd);
      }

      $pdo->commit();
      echo json_encode(['status' => 'success', 'message' => 'Reservation status updated and email sent successfully.']);
    } else {
      $pdo->rollBack();
      echo json_encode(['status' => 'error', 'message' => 'Reservation not found.']);
    }
  } catch (Exception $e) {
    $pdo->rollBack();
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating reservation status.', 'error' => $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

function initializeMailer()
{
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'majayjaytourist4005@gmail.com';
  $mail->Password = 'ilnppweayuuzknzi'; // Use environment variables in production
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;
  $mail->setFrom('majayjaytourist4005@gmail.com', 'Majayjay Tourist');
  return $mail;
}

function sendEmailNotification($reservation, $status, $formattedCheckin, $formattedDeparture, $formattedTimeStart, $formattedTimeEnd)
{
  $mail = initializeMailer();
  $mail->addAddress($reservation['regemail']);
  $mail->isHTML(true);
  $mail->Subject = 'Reservation Status Updated';

  $referenceNumber = '';
  if ($reservation['IsPaid']) {
    $referenceNumber = "<li><strong>Gcash Reference Number:</strong> {$reservation['gcashReference']}</li>";
  }
  $formattedPrice = number_format($reservation['totalPrice'], 2);

  $mail->Body = "
    <html>
    <head>
        <title>Reservation Status Updated</title>
    </head>
    <body>
        <p>Dear {$reservation['fullname']},</p>
        <p>Welcome to {$reservation['BusinessName']}!</p>
        <p>We are pleased to inform you that your reservation for the room <strong>{$reservation['roomName']}</strong> has been <strong>Approved</strong>.</p>
        <p>Total Number of Attendees: {$reservation['totalnumAttendees']}</p>
        <p>Here are the details of your reservation:</p>
        <ul>
            {$referenceNumber}
            <li><strong>Check-in Date:</strong> {$formattedCheckin}</li>
            <li><strong>Time-in:</strong> {$formattedTimeStart}</li>
            <li><strong>Check-out Date:</strong> {$formattedDeparture}</li>
            <li><strong>Time-out:</strong> {$formattedTimeEnd}</li>
            <li><strong>Total Price:</strong> ₱{$formattedPrice}</li>
        </ul>
        <p><strong>Location:</strong> {$reservation['BusinessAddress']}</p>
        <p>If you want more information regarding your reservation, you can check it on 'my booking' on our website.</p>
        <p>Please ensure that you check in on time. If you have any questions or need further assistance, feel free to contact us.</p>
        <p>Thank you for choosing our service.</p>
        <p>Best regards,</p>
        <p>Majayjay Tourist</p>
    </body>
    </html>
  ";
  $mail->send();
}

function sendRejectionEmail($reservation, $reasons)
{
  $mail = initializeMailer();
  $mail->addAddress($reservation['regemail']);
  $mail->isHTML(true);
  $mail->Subject = 'Reservation Rejected';

  $reasonsList = '';
  foreach ($reasons as $reason) {
    $reasonsList .= "<li>{$reason}</li>";
  }

  $mail->Body = "
    <html>
    <head>
        <title>Reservation Rejected</title>
    </head>
    <body>
        <p>Dear {$reservation['fullname']},</p>
        <p>Sorry, your reservation at <strong>{$reservation['BusinessName']}</strong> was disapproved due to the following reasons:</p>
        <ul>
            {$reasonsList}
        </ul>
        <p>If you want to reserve again, please make sure your information is correct.</p>
        <p>Best regards,</p>
        <p>Majayjay Tourist</p>
    </body>
    </html>
  ";
  $mail->send();
}
