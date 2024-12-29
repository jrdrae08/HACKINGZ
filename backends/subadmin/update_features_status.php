<?php
session_start();
include "../../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['business_info_id'])) {
  $input = json_decode(file_get_contents('php://input'), true);
  $featureID = $input['featureID'];
  $isActive = $input['isActive']; // Should be 1 for checked, 0 for unchecked
  $businessInfoID = $_SESSION['business_info_id'];

  try {
    // Validate BusinessInfoID and FeatureID association
    $stmt = $pdo->prepare('SELECT BusinessFeatureID FROM business_features WHERE BusinessInfoID = :businessInfoID AND FeatureID = :featureID');
    $stmt->execute(['businessInfoID' => $businessInfoID, 'featureID' => $featureID]);

    if ($stmt->rowCount() === 0) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid BusinessInfoID or FeatureID association.']);
      exit;
    }

    // Update feature status for the specific business
    $stmt = $pdo->prepare('UPDATE business_features SET IsActive = :isActive WHERE BusinessInfoID = :businessInfoID AND FeatureID = :featureID');
    $stmt->execute(['isActive' => $isActive, 'businessInfoID' => $businessInfoID, 'featureID' => $featureID]);

    echo json_encode(['status' => 'success', 'message' => 'Feature status updated successfully.']);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update feature status: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method or missing session data.']);
}
