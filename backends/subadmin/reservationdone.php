<?php
include '../../includes/db.php';
session_start();

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $revID = $data['revID'];

  try {
    $pdo->beginTransaction();

    // Update the reservation status to Complete
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'Complete' WHERE revID = :revID");
    $stmt->execute(['revID' => $revID]);

    $pdo->commit();
    echo json_encode(['status' => 'success', 'message' => 'Reservation status updated to Complete.']);
  } catch (Exception $e) {
    $pdo->rollBack();
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating reservation status.', 'error' => $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
