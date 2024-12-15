<?php
// fetch_ongoing_reservations.php
include '../../includes/db.php';
session_start();

if (!isset($_SESSION['business_info_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'BusinessInfoID not set in session.']);
  exit;
}

$businessInfoID = $_SESSION['business_info_id'];

try {
  // Fetch upcoming reservations
  $stmt = $pdo->prepare("
    SELECT DISTINCT r.revID, r.datetime AS timeBooked, ri.roomName, r.fullname AS customerName, r.regadd AS address, r.regnum AS contactNumber, u.id_type, u.front_id, u.back_id,
           ud.totalnumAttendees, ud.totalmale, ud.totalfemale, ud.thisCity, ud.otherCity, ud.otherProvince, ud.foreignCountry, ud.name AS attendeeNames, ud.sex AS attendeeSexes, ud.location AS attendeeLocations,
           up.proofOfPayment, up.gcashReference
    FROM reservations r
    JOIN roominfotable ri ON r.roomID = ri.roomID
    JOIN users u ON r.userID = u.userId
    LEFT JOIN userdemographics ud ON r.userID = ud.userID AND r.roomID = ud.roomID AND ri.BusinessInfoID = ud.BusinessInfoID AND r.datetime = ud.created_at
    LEFT JOIN userpayment up ON r.roomID = up.roomID AND r.userID = up.userID AND ri.BusinessInfoID = up.businessinfoID
    WHERE ri.BusinessInfoID = :businessInfoID AND r.status = 'Accepted'
    ORDER BY r.datetime DESC
  ");
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $upcomingReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch ongoing reservations
  $stmt = $pdo->prepare("
    SELECT DISTINCT r.revID, ri.roomName, r.checkin, r.departure, r.fullname AS customerName, ri.timeStart, ri.timeEnd,
           r.regadd AS address, r.regnum AS contactNumber, u.id_type, u.front_id, u.back_id,
           ud.totalnumAttendees, ud.totalmale, ud.totalfemale, ud.thisCity, ud.otherCity, ud.otherProvince, ud.foreignCountry, ud.name AS attendeeNames, ud.sex AS attendeeSexes, ud.location AS attendeeLocations,
           up.proofOfPayment, up.gcashReference
    FROM reservations r
    JOIN roominfotable ri ON r.roomID = ri.roomID
    JOIN users u ON r.userID = u.userId
    LEFT JOIN userdemographics ud ON r.userID = ud.userID AND r.roomID = ud.roomID AND ri.BusinessInfoID = ud.BusinessInfoID AND r.datetime = ud.created_at
    LEFT JOIN userpayment up ON r.roomID = up.roomID AND r.userID = up.userID AND ri.BusinessInfoID = up.businessinfoID
    WHERE ri.BusinessInfoID = :businessInfoID AND r.status = 'Ongoing'
    ORDER BY r.checkin DESC
  ");
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $ongoingReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['status' => 'success', 'upcoming' => $upcomingReservations, 'ongoing' => $ongoingReservations]);
} catch (Exception $e) {
  error_log($e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while fetching reservations.']);
}
