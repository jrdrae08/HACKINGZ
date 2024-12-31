<?php
session_start();
include '../../includes/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
  $data = json_decode(file_get_contents('php://input'), true);
  $highlightName = trim($data['highlights']);
  $barangayId = $_SESSION['user_id'];

  // Convert the highlight name to Sentence Case on the server side
  $highlightName = ucfirst(strtolower($highlightName));

  // Validate Highlight Name: not empty and within allowed length
  if (empty($highlightName)) {
    echo json_encode(['status' => 'error', 'message' => 'Highlight name cannot be empty']);
    exit;
  }

  if (strlen($highlightName) > 100) {
    echo json_encode(['status' => 'error', 'message' => 'Highlight name cannot exceed 100 characters']);
    exit;
  }

  // Check if the highlight already exists for this BarangayID
  $stmt = $pdo->prepare('SELECT HighlightID FROM highlights WHERE BarangayID = :barangayId AND HighlightName = :name');
  $stmt->execute(['barangayId' => $barangayId, 'name' => $highlightName]);
  if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Highlight already exists']);
    exit;
  }

  // Insert the highlight
  $stmt = $pdo->prepare('INSERT INTO highlights (HighlightName, BarangayID) VALUES (:name, :barangayId)');
  $stmt->execute(['name' => $highlightName, 'barangayId' => $barangayId]);

  echo json_encode(['status' => 'success', 'message' => 'Highlight added successfully']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
