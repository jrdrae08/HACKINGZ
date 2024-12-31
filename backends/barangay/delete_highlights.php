<?php
session_start();
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $highlightID = $data['featureID'];
  $barangayId = $_SESSION['user_id'];

  // Delete the highlight
  $stmt = $pdo->prepare('DELETE FROM highlights WHERE HighlightID = :highlightID AND BarangayID = :barangayId');
  $stmt->execute(['highlightID' => $highlightID, 'barangayId' => $barangayId]);

  echo json_encode(['status' => 'success', 'message' => 'Highlight deleted successfully']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
