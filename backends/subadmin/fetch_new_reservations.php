<?php
// fetch_new_reservations.php
include '../../includes/db.php';
session_start();

if (!isset($_SESSION['business_info_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'BusinessInfoID not set in session.']);
  exit;
}

$businessInfoID = $_SESSION['business_info_id'];

try {
  $stmt = $pdo->prepare("
    SELECT r.datetime AS timeBooked, ri.roomName, r.fullname AS customerName, r.regadd AS address, r.regnum AS contactNumber, u.id_type, u.front_id, u.back_id
    FROM reservations r
    JOIN roominfotable ri ON r.roomID = ri.roomID
    JOIN users u ON r.userID = u.userId
    WHERE ri.BusinessInfoID = :businessInfoID
  ");
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($reservations) {
    echo json_encode(['status' => 'success', 'data' => $reservations]);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'No reservations found.']);
  }
} catch (Exception $e) {
  error_log($e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while fetching reservations.']);
}
