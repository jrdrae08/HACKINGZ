<?php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['business_info_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $featureID = $data['featureID'];
  $businessInfoID = $_SESSION['business_info_id'];

  // Validate FeatureID
  $stmt = $pdo->prepare('SELECT FeatureID FROM room_features WHERE FeatureID = :featureID AND BusinessInfoID = :businessInfoID');
  $stmt->execute(['featureID' => $featureID, 'businessInfoID' => $businessInfoID]);

  if ($stmt->rowCount() === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid FeatureID']);
    exit;
  }

  // Delete the feature from the database
  try {
    $stmt = $pdo->prepare('DELETE FROM room_features WHERE FeatureID = :featureID AND BusinessInfoID = :businessInfoID');
    $stmt->execute(['featureID' => $featureID, 'businessInfoID' => $businessInfoID]);

    echo json_encode(['status' => 'success', 'message' => 'Feature deleted successfully']);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the feature']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
