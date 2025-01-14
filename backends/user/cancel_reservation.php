<?php
session_start();
require_once '../../includes/db.php';

header('Content-Type: application/json');

// Check if the userID is set in the session
$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userID === null) {
  echo json_encode(['status' => 'error', 'message' => 'User ID is not set.']);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $revID = $_POST['revID'];
  $reasonCancel = $_POST['reasonCancel'];

  try {
    $stmt = $pdo->prepare("
            UPDATE reservations
            SET status = 'Canceled', reasonCancel = :reasonCancel
            WHERE revID = :revID AND userID = :userID
        ");
    $stmt->execute([
      'reasonCancel' => $reasonCancel,
      'revID' => $revID,
      'userID' => $userID
    ]);

    echo json_encode(['status' => 'success']);
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the reservation.']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
