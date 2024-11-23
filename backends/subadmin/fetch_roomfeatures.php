<?php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
  echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT FeatureID, FeatureName FROM room_features WHERE BusinessInfoID = :businessInfoID');
  $stmt->execute(['businessInfoID' => $_SESSION['business_info_id']]);
  $features = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['status' => 'success', 'features' => $features]);
} catch (Exception $e) {
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while fetching features']);
}
