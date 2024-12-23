<?php
include __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicationId'])) {
  $applicationId = $_POST['applicationId'];

  try {
    // Fetch the existing BusinessPermitImage from the database
    $stmt = $pdo->prepare("SELECT BusinessPermitImage FROM businessapplicationform WHERE ApplicationID = ?");
    $stmt->execute([$applicationId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      $oldImage = $result['BusinessPermitImage'];

      // Extract the unique ID and base name from the existing image name
      $parts = explode('-', $oldImage);
      $uniqueID = $parts[0];
      $baseName = implode('-', array_slice($parts, 1)); // Get the base name with extension

      // Define the paths
      $oldImagePath = __DIR__ . '/../../businessowner/uploadsapp/' . $oldImage;
      $newImagePath = __DIR__ . '/../../businessowner/uploadsapp/newPermit/' . $uniqueID . '-' . $baseName;
      $newImageDestination = __DIR__ . '/../../businessowner/uploadsapp/' . $uniqueID . '-' . $baseName;

      // Move the new permit image to the old permit image location
      if (file_exists($newImagePath)) {
        if (file_exists($oldImagePath)) {
          unlink($oldImagePath); // Delete the old permit image
        }
        rename($newImagePath, $newImageDestination); // Move the new permit image
      }

      // Update the database
      $stmt = $pdo->prepare("UPDATE businessapplicationform 
                                   SET ReminderSent = 0, 
                                       isRenew = 1, 
                                       reuploadDate = NULL, 
                                       PermitExpDate = newPermitDate, 
                                       newPermitDate = NULL, 
                                       BusinessPermitImage = ? 
                                   WHERE ApplicationID = ?");
      $stmt->execute([$uniqueID . '-' . $baseName, $applicationId]);

      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['error' => 'Business permit not found.']);
    }
  } catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}
