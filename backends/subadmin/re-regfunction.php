<?php
// re-regfunction.php
include '../../includes/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

function respond($status, $message)
{
  echo json_encode(['status' => $status, 'message' => $message]);
  exit;
}

function compressAndConvertToWebP($permit, $target_dir)
{
  $imageFileType = strtolower(pathinfo($permit["name"], PATHINFO_EXTENSION));
  $webp_image_name = uniqid() . '-' . date('Ymd') . '.webp';
  $webp_target_file = $target_dir . $webp_image_name;

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $image = imagecreatefromjpeg($permit["tmp_name"]);
      break;
    case 'png':
      $image = imagecreatefrompng($permit["tmp_name"]);
      // Convert palette-based image to true color
      if (imageistruecolor($image) === false) {
        $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $image = $trueColorImage;
      }
      break;
    case 'gif':
      $image = imagecreatefromgif($permit["tmp_name"]);
      // Convert palette-based image to true color
      if (imageistruecolor($image) === false) {
        $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $image = $trueColorImage;
      }
      break;
    case 'webp':
      $image = imagecreatefromwebp($permit["tmp_name"]);
      break;
    default:
      $image = null;
      break;
  }

  if ($image && imagewebp($image, $webp_target_file, 80)) {
    imagedestroy($image);
    return $webp_image_name;
  } else {
    return null;
  }
}

try {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $applicationID = $_POST['applicationID'] ?? null;
    $refNum = $_POST['refNum'] ?? null;
    $updatedData = json_decode($_POST['updatedData'] ?? '', true);

    if ($applicationID && $updatedData) {
      // Validate expiration date
      $currentDate = new DateTime();
      $expirationDate = DateTime::createFromFormat('Y-m-d', $updatedData['bexdate']);

      if ($expirationDate < $currentDate) {
        respond('error', 'Business Permit Expiration Date cannot be in the past.');
      }

      // Handle JSON data update
      $stmt = $pdo->prepare("UPDATE businessapplicationform SET PermitExpDate = STR_TO_DATE(:permitExpDate, '%Y-%m-%d'), Status = 'Pending', IsReject = 0, IsRead = 0, isReapply = 1 WHERE ApplicationID = :applicationID");
      $stmt->execute([
        ':permitExpDate' => $updatedData['bexdate'],
        ':applicationID' => $applicationID
      ]);

      // Handle file upload
      if (isset($_FILES['businessPermitImage']) && $_FILES['businessPermitImage']['error'] == 0) {
        $target_dir = "../../businessowner/uploadsapp/";
        $image_name = compressAndConvertToWebP($_FILES["businessPermitImage"], $target_dir);
        if ($image_name !== null) {
          // Delete the old image
          $stmt = $pdo->prepare("SELECT BusinessPermitImage FROM businessapplicationform WHERE ApplicationID = :applicationID");
          $stmt->execute([':applicationID' => $applicationID]);
          $oldImage = $stmt->fetchColumn();
          if ($oldImage) {
            $oldImagePath = $target_dir . $oldImage;
            if (file_exists($oldImagePath)) {
              unlink($oldImagePath);
            }
          }

          // Update the database with the new image
          $stmt = $pdo->prepare("UPDATE businessapplicationform SET BusinessPermitImage = :businessPermitImage, IsRead = 0 WHERE ApplicationID = :applicationID");
          $stmt->execute([
            ':businessPermitImage' => $image_name,
            ':applicationID' => $applicationID
          ]);
        } else {
          respond('error', 'Failed to convert and move uploaded file.');
        }
      } else {
        respond('error', 'Invalid file. Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.');
      }

      respond('success', 'Data updated successfully');
    } elseif ($refNum) {
      // Handle the fetch request
      $stmt = $pdo->prepare("SELECT * FROM businessapplicationform WHERE RefNum = :refNum");
      $stmt->bindParam(':refNum', $refNum, PDO::PARAM_STR);
      $stmt->execute();
      $applicationData = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($stmt->errorCode() != '00000') {
        respond('error', 'Query error: ' . implode(", ", $stmt->errorInfo()));
      }

      if ($applicationData) {
        if ($applicationData['IsReject'] == 0) {
          respond('error', 'Your account is not rejected.');
        }

        $stmt = $pdo->prepare("SELECT bi.*, bt.TypeName AS BusinessType FROM businessinformationform bi JOIN businesstype bt ON bi.BusinessTypeID = bt.BusinessTypeID WHERE bi.ApplicationID = :applicationID");
        $stmt->bindParam(':applicationID', $applicationData['ApplicationID'], PDO::PARAM_INT);
        $stmt->execute();
        $businessData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->errorCode() != '00000') {
          respond('error', 'Query error: ' . implode(", ", $stmt->errorInfo()));
        }

        $data = array_merge($applicationData, $businessData);

        echo json_encode([
          'status' => 'success',
          'message' => 'Record has been found. Please wait...',
          'data' => $data,
          'applicationID' => $applicationData['ApplicationID'],
          'redirect' => '../../businessowner/business-re-registration.php'
        ]);
      } else {
        respond('error', 'No record found for the given business permit number.');
      }
    } else {
      respond('error', 'Invalid input data.');
    }
  } else {
    respond('error', 'Invalid request method.');
  }
} catch (PDOException $e) {
  error_log('PDOException: ' . $e->getMessage());
  respond('error', 'Query failed: ' . $e->getMessage());
} catch (Exception $e) {
  error_log('Exception: ' . $e->getMessage());
  respond('error', 'An unexpected error occurred: ' . $e->getMessage());
}
