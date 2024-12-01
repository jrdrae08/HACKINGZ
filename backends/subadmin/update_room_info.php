<?php
include '../../includes/db.php';

function updateRoomInfo($roomID, $roomData, $pdo)
{
  // Update room information
  $stmt = $pdo->prepare("
        UPDATE roominfotable
        SET roomName = ?, roomPrice = ?, adultMax = ?, ChildrenMax = ?, RoomDescriptions = ?, timeStart = ?, timeEnd = ?
        WHERE roomID = ?
    ");
  $stmt->execute([
    $roomData['roomName'],
    $roomData['roomPrice'],
    $roomData['adultMax'],
    $roomData['ChildrenMax'],
    $roomData['RoomDescriptions'],
    $roomData['timeStart'],
    $roomData['timeEnd'],
    $roomID
  ]);

  // Check if a payment method already exists for the room
  $paymentCheckStmt = $pdo->prepare("SELECT COUNT(*) FROM payment_methods WHERE roomID = ?");
  $paymentCheckStmt->execute([$roomID]);
  $paymentExists = $paymentCheckStmt->fetchColumn() > 0;

  // Update or add payment amount if provided and valid
  if (isset($roomData['paymentAmount']) && $roomData['paymentAmount'] > 0) {
    if ($paymentExists) {
      // Update existing payment method
      $paymentStmt = $pdo->prepare("
                UPDATE payment_methods
                SET amount = ?
                WHERE roomID = ?
            ");
      $paymentStmt->execute([$roomData['paymentAmount'], $roomID]);
    } else {
      // Insert new payment method
      $paymentStmt = $pdo->prepare("
                INSERT INTO payment_methods (roomID, amount)
                VALUES (?, ?)
            ");
      $paymentStmt->execute([$roomID, $roomData['paymentAmount']]);
    }
  } else {
    // If paymentAmount is not set or invalid, delete the payment method if it exists
    if ($paymentExists) {
      $paymentStmt = $pdo->prepare("DELETE FROM payment_methods WHERE roomID = ?");
      $paymentStmt->execute([$roomID]);
    }
  }

  // Update facilities
  if (isset($roomData['facilities'])) {
    foreach ($roomData['facilities'] as $facilityID => $isActive) {
      $facilityStmt = $pdo->prepare("
                INSERT INTO room_facilities_mapping (roomID, FacilityID, BusinessInfoID, IsActive)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE IsActive = VALUES(IsActive)
            ");
      $facilityStmt->execute([$roomID, $facilityID, $_SESSION['business_info_id'], $isActive]);
    }
  }

  // Update features
  if (isset($roomData['features'])) {
    foreach ($roomData['features'] as $featureID => $isActive) {
      $featureStmt = $pdo->prepare("
                INSERT INTO room_features_mapping (roomID, FeatureID, BusinessInfoID, IsActive)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE IsActive = VALUES(IsActive)
            ");
      $featureStmt->execute([$roomID, $featureID, $_SESSION['business_info_id'], $isActive]);
    }
  }

  // Get the business name from the database using the session's businessInfoID
  $businessInfoID = $_SESSION['business_info_id'];
  $businessNameQuery = "SELECT BusinessName FROM businessinformationform WHERE BusinessInfoID = :businessInfoID";
  $stmt = $pdo->prepare($businessNameQuery);
  $stmt->execute([':businessInfoID' => $businessInfoID]);
  $businessNameResult = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($businessNameResult) {
    $businessName = htmlspecialchars(trim($businessNameResult['BusinessName']));

    // Define target directory based on business name and room name
    $targetDir = "../../businessowner/roomImages/$businessName/{$roomData['roomName']}/";

    // Ensure the directory exists; if not, create it
    if (!file_exists($targetDir)) {
      if (!mkdir($targetDir, 0777, true)) {
        return ['status' => 'error', 'message' => 'Failed to create directories.'];
      }
    }

    // Handle image uploads
    for ($i = 1; $i <= 6; $i++) {
      $imageKey = 'image' . $i;
      if (isset($_FILES[$imageKey]) && $_FILES[$imageKey]['error'] == UPLOAD_ERR_OK) {
        $imageFileType = strtolower(pathinfo($_FILES[$imageKey]['name'], PATHINFO_EXTENSION));
        $uniqueNumber = uniqid();
        $imageName = pathinfo($_FILES[$imageKey]['name'], PATHINFO_FILENAME) . "_" . $uniqueNumber . "." . $imageFileType;
        $imagePath = $targetDir . $imageName;

        if (move_uploaded_file($_FILES[$imageKey]['tmp_name'], $imagePath)) {
          $imageStmt = $pdo->prepare("
                        UPDATE roominfotable
                        SET $imageKey = ?
                        WHERE roomID = ?
                    ");
          $imageStmt->execute([$imagePath, $roomID]);
        } else {
          return ['status' => 'error', 'message' => 'Failed to move uploaded file.'];
        }
      }

      // Handle image deletion
      if (isset($roomData['deleteImages']) && in_array($imageKey, $roomData['deleteImages'])) {
        $imageStmt = $pdo->prepare("
                    UPDATE roominfotable
                    SET $imageKey = NULL
                    WHERE roomID = ?
                ");
        $imageStmt->execute([$roomID]);

        // Delete the image file from the server
        $imagePathQuery = $pdo->prepare("SELECT $imageKey FROM roominfotable WHERE roomID = ?");
        $imagePathQuery->execute([$roomID]);
        $imagePathResult = $imagePathQuery->fetch(PDO::FETCH_ASSOC);
        if ($imagePathResult && file_exists($imagePathResult[$imageKey])) {
          unlink($imagePathResult[$imageKey]);
        }
      }
    }

    return ['status' => 'success', 'message' => 'Room information updated successfully.'];
  } else {
    return ['status' => 'error', 'message' => 'Failed to retrieve business name.'];
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $roomID = isset($_POST['roomID']) ? intval($_POST['roomID']) : null;
  if ($roomID === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid room ID.']);
    exit;
  }

  $roomData = [
    'roomName' => $_POST['roomname'],
    'roomPrice' => $_POST['roomprice'],
    'adultMax' => $_POST['adultmax'],
    'ChildrenMax' => $_POST['childrenmax'],
    'RoomDescriptions' => $_POST['roomdesc'],
    'timeStart' => $_POST['timestart'],
    'timeEnd' => $_POST['timeend'],
    'paymentAmount' => isset($_POST['paymentAmount']) ? $_POST['paymentAmount'] : null,
    'facilities' => isset($_POST['facilities']) ? $_POST['facilities'] : [],
    'features' => isset($_POST['features']) ? $_POST['features'] : [],
    'deleteImages' => isset($_POST['deleteImages']) ? $_POST['deleteImages'] : []
  ];

  // Convert facilities and features to associative arrays with IsActive values
  $roomData['facilities'] = array_map(function ($facilityID) {
    return 1; // Active
  }, $roomData['facilities']);

  $roomData['features'] = array_map(function ($featureID) {
    return 1; // Active
  }, $roomData['features']);

  $result = updateRoomInfo($roomID, $roomData, $pdo);
  echo json_encode($result);
}
