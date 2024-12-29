<?php
session_start();
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['business_info_id'])) {
  try {
    $businessInfoID = $_SESSION['business_info_id'];

    // Fetch all features associated with the BusinessInfoID
    $stmt = $pdo->prepare('
            SELECT f.FeatureID, f.FeatureName, bf.IsActive
            FROM features f
            JOIN business_features bf ON f.FeatureID = bf.FeatureID
            WHERE bf.BusinessInfoID = :businessInfoID
        ');
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $features = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($features);
  } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch features: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method or missing session data.']);
}
