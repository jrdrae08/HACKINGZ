<?php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

if (isset($_SESSION['business_info_id'])) {
  $businessInfoID = $_SESSION['business_info_id'];

  // Fetch the facilities from the database
  $stmt = $pdo->prepare('SELECT FacilityID, FacilityName FROM room_facilities WHERE BusinessInfoID = :businessInfoID');
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $facilities = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['status' => 'success', 'facilities' => $facilities]);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
