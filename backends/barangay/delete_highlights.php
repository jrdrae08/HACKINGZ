<?php
session_start();
include '../../includes/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $highlightID = $data['highlightID'];
  $barangayId = $_SESSION['user_id'];

  try {
    // Delete the highlight
    $stmt = $pdo->prepare('DELETE FROM highlights WHERE HighlightID = :highlightID AND BarangayID = :barangayId');
    $stmt->execute(['highlightID' => $highlightID, 'barangayId' => $barangayId]);

    echo json_encode(['status' => 'success', 'message' => 'Highlight deleted successfully']);
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
