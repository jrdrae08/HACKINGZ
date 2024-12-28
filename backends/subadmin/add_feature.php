<?php
session_start();
include '../../includes/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['business_info_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $featureName = trim($data['featureName']);
  $businessInfoID = $_SESSION['business_info_id'];

  // Convert the feature name to Sentence Case on the server side
  $featureName = ucfirst(strtolower($featureName));

  // Validate Feature Name: not empty and within allowed length
  if (empty($featureName)) {
    echo json_encode(['status' => 'error', 'message' => 'Feature name cannot be empty']);
    exit;
  }

  if (strlen($featureName) > 100) {
    echo json_encode(['status' => 'error', 'message' => 'Feature name cannot exceed 100 characters']);
    exit;
  }

  // Validate BusinessInfoID: check if it exists
  $stmt = $pdo->prepare('SELECT BusinessInfoID FROM businessinformationform WHERE BusinessInfoID = :businessInfoID');
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  if ($stmt->rowCount() === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid BusinessInfoID']);
    exit;
  }

  // Check if the feature already exists for this BusinessInfoID
  $stmt = $pdo->prepare('
        SELECT bf.BusinessFeatureID 
        FROM business_features bf
        JOIN features f ON bf.FeatureID = f.FeatureID
        WHERE bf.BusinessInfoID = :businessInfoID AND f.FeatureName = :name
    ');
  $stmt->execute(['businessInfoID' => $businessInfoID, 'name' => $featureName]);
  if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Feature already exists']);
    exit;
  }

  // Check if the feature already exists in the features table
  $stmt = $pdo->prepare('SELECT FeatureID FROM features WHERE FeatureName = :name');
  $stmt->execute(['name' => $featureName]);
  if ($stmt->rowCount() > 0) {
    $featureID = $stmt->fetchColumn();
  } else {
    // Insert the feature if it doesn't exist
    $stmt = $pdo->prepare('INSERT INTO features (FeatureName) VALUES (:name)');
    $stmt->execute(['name' => $featureName]);
    $featureID = $pdo->lastInsertId();
  }

  // Associate the feature with the BusinessInfoID
  $stmt = $pdo->prepare('INSERT INTO business_features (BusinessInfoID, FeatureID) VALUES (:businessInfoID, :featureID)');
  $stmt->execute(['businessInfoID' => $businessInfoID, 'featureID' => $featureID]);

  echo json_encode(['status' => 'success', 'message' => 'Feature added successfully']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
