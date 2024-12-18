<?php
// fetch_canceled_reservations.php
include '../../includes/db.php';
session_start();

if (!isset($_SESSION['business_info_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'BusinessInfoID not set in session.']);
  exit;
}

$businessInfoID = $_SESSION['business_info_id'];

try {
  $stmt = $pdo->prepare("
    SELECT DISTINCT r.revID, r.datetime AS timeBooked, ri.roomName, r.fullname AS customerName, r.regadd AS address, r.regnum AS contactNumber, u.id_type, u.front_id, u.back_id,
           ud.totalnumAttendees, ud.totalmale, ud.totalfemale, ud.thisCity, ud.otherCity, ud.otherProvince, ud.foreignCountry, ud.name AS attendeeNames, ud.sex AS attendeeSexes, ud.location AS attendeeLocations,
           up.proofOfPayment, up.gcashReference, r.reasonCancel, r.status
    FROM reservations r
    JOIN roominfotable ri ON r.roomID = ri.roomID
    JOIN users u ON r.userID = u.userId
    LEFT JOIN userdemographics ud ON r.userID = ud.userID AND r.roomID = ud.roomID AND ri.BusinessInfoID = ud.BusinessInfoID AND r.datetime = ud.created_at
    LEFT JOIN userpayment up ON r.roomID = up.roomID AND r.userID = up.userID AND ri.BusinessInfoID = up.businessinfoID
    WHERE ri.BusinessInfoID = :businessInfoID AND r.status = 'Cancel'
    ORDER BY r.datetime DESC
  ");
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($reservations) {
    echo json_encode(['status' => 'success', 'data' => $reservations]);
  }else {
    echo json_encode(['status' => 'error', 'message' => 'No reservations found.']);
  }
} catch (Exception $e) {
  error_log($e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while fetching canceled reservations.']);
}
