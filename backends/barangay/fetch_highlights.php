<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
  exit;
}

$barangayId = $_SESSION['user_id'];

try {
  $stmt = $pdo->prepare('SELECT HighlightID, HighlightName, IsActive FROM highlights WHERE BarangayID = :barangayId');
  $stmt->execute(['barangayId' => $barangayId]);
  $highlights = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['status' => 'success', 'highlights' => $highlights]);
} catch (PDOException $e) {
  echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
