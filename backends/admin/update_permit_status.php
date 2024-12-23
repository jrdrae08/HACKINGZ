<?php
include __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicationId'])) {
  $applicationId = $_POST['applicationId'];

  try {
    $stmt = $pdo->prepare("UPDATE businessapplicationform 
                               SET ReminderSent = 0, 
                                   isRenew = 1, 
                                   reuploadDate = NULL, 
                                   PermitExpDate = newPermitDate, 
                                   newPermitDate = NULL 
                               WHERE ApplicationID = ?");
    $stmt->execute([$applicationId]);

    echo json_encode(['success' => true]);
  } catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}
