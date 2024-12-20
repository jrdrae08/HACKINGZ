<?php
session_start();
require_once '../../includes/db.php';

$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userID === null) {
  echo json_encode(['status' => 'error', 'message' => 'User ID is not set.']);
  exit();
}

if (isset($_GET['userId'])) {
  $userId = intval($_GET['userId']);

  try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE userId = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'User ID not provided.']);
}
