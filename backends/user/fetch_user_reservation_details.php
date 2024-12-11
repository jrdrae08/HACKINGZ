<?php
require_once '../../includes/db.php';

header('Content-Type: application/json');

if (!isset($_GET['revID'])) {
  http_response_code(400);
  echo json_encode(['error' => 'revID is required']);
  exit();
}

$revID = $_GET['revID'];

try {
  $stmt = $pdo->prepare("
    SELECT ri.roomName, ri.roomPrice, ri.timeStart, ri.timeEnd, r.checkin, r.departure, r.status, b.BusinessName, b.BusinessAddress, ud.totalnumAttendees, up.proofOfPayment, up.gcashReference
    FROM reservations r
    JOIN roominfotable ri ON r.roomID = ri.roomID
    JOIN businessinformationform b ON ri.BusinessInfoID = b.BusinessInfoID
    JOIN userdemographics ud ON r.userID = ud.userID AND r.roomID = ud.roomID
    LEFT JOIN userpayment up ON r.userID = up.userID AND r.roomID = up.roomID
    WHERE r.revID = :revID
  ");
  $stmt->execute(['revID' => $revID]);
  $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($reservation) {
    echo json_encode($reservation);
  } else {
    http_response_code(404);
    echo json_encode(['error' => 'Reservation not found']);
  }
} catch (Exception $e) {
  error_log($e->getMessage());
  http_response_code(500);
  echo json_encode(['error' => 'An error occurred while fetching reservation details']);
}
