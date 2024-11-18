<?php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['business_info_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $facilityID = $data['facilityID'];
  $isEnable = $data['isEnable'];
  $businessInfoID = $_SESSION['business_info_id'];

  // Validate FacilityID
  $stmt = $pdo->prepare('SELECT FacilityID FROM room_facilities WHERE FacilityID = :facilityID AND BusinessInfoID = :businessInfoID');
  $stmt->execute(['facilityID' => $facilityID, 'businessInfoID' => $businessInfoID]);

  if ($stmt->rowCount() === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid FacilityID']);
    exit;
  }

  // Update the facility status in the database
  try {
    $stmt = $pdo->prepare('UPDATE room_facilities SET IsEnable = :isEnable WHERE FacilityID = :facilityID AND BusinessInfoID = :businessInfoID');
    $stmt->execute(['isEnable' => $isEnable, 'facilityID' => $facilityID, 'businessInfoID' => $businessInfoID]);

    echo json_encode(['status' => 'success', 'message' => 'Facility status updated successfully']);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the facility status']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
