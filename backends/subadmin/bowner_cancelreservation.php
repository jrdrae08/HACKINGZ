<?php
session_start();
require_once '../../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $revID = isset($data['revID']) ? $data['revID'] : null;
  $reasonCancel = isset($data['reasonCancel']) ? $data['reasonCancel'] : null;

  if ($revID === null) {
    echo json_encode(['status' => 'error', 'message' => 'Reservation ID is not set.']);
    exit();
  }

  if ($reasonCancel === null) {
    echo json_encode(['status' => 'error', 'message' => 'Reason for cancellation is not set.']);
    exit();
  }

  try {
    $stmt = $pdo->prepare("
            UPDATE reservations
            SET status = 'Canceled', reasonCancel = :reasonCancel
            WHERE revID = :revID
        ");
    $stmt->execute([
      'revID' => $revID,
      'reasonCancel' => $reasonCancel
    ]);

    if ($stmt->rowCount() > 0) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Reservation not found or not updated.']);
    }
  } catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the reservation.']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
