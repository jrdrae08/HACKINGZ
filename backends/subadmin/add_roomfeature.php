<?php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json'); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['business_info_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $featureName = trim($data['featureName']);
  $businessInfoID = $_SESSION['business_info_id'];

  // Convert the feature name to Sentence Case
  $featureName = ucfirst(strtolower($featureName));

  // Validate Feature Name
  if (empty($featureName)) {
    echo json_encode(['status' => 'error', 'message' => 'Feature name cannot be empty']);
    exit;
  }

  if (strlen($featureName) > 255) {
    echo json_encode(['status' => 'error', 'message' => 'Feature name cannot exceed 255 characters']);
    exit;
  }

  // Validate BusinessInfoID
  $stmt = $pdo->prepare('SELECT BusinessInfoID FROM businessinformationform WHERE BusinessInfoID = :businessInfoID');
  $stmt->execute(['businessInfoID' => $businessInfoID]);

  if ($stmt->rowCount() === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid BusinessInfoID']);
    exit;
  }

  // Check if the feature already exists
  $stmt = $pdo->prepare('SELECT FeatureID FROM room_features WHERE FeatureName = :name AND BusinessInfoID = :businessInfoID');
  $stmt->execute(['name' => $featureName, 'businessInfoID' => $businessInfoID]);

  if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Feature already exists']);
    exit;
  }

  // Insert the feature into the database
  try {
    $stmt = $pdo->prepare('INSERT INTO room_features (BusinessInfoID, FeatureName) VALUES (:businessInfoID, :featureName)');
    $stmt->execute(['businessInfoID' => $businessInfoID, 'featureName' => $featureName]);
    $featureID = $pdo->lastInsertId();

    echo json_encode([
      'status' => 'success',
      'message' => 'Feature added successfully',
      'featureID' => $featureID
    ]);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while adding the feature']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
