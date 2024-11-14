<?php
//add-gcashinfo.php
session_start();
include "../../includes/db.php";

$businessInfoID = $_SESSION['business_info_id'];

$response = [
  'businessInfoID' => $businessInfoID,
  'message' => '',
  'message_type' => '',
  'data' => null
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $gcashNum = filter_var($_POST['gcashnum'], FILTER_SANITIZE_STRING);
  $gcashName = filter_var($_POST['gcashname'], FILTER_SANITIZE_STRING);

  if (!empty($gcashNum) && !empty($gcashName) && isset($_FILES['qrimage1'])) {
    $qrImage = $_FILES['qrimage1'];
    $targetDir = "../../businessowner/paymentQr/";
    $uniqueName = uniqid() . '.' . strtolower(pathinfo($qrImage["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $uniqueName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($qrImage["tmp_name"]);
    if ($check !== false) {
      // Check file size (5MB max)
      if ($qrImage["size"] <= 5000000) {
        // Allow certain file formats
        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
          if (move_uploaded_file($qrImage["tmp_name"], $targetFile)) {
            // Check if record exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM qcashPayment WHERE BusinessInfoID = ?");
            $stmt->execute([$businessInfoID]);
            $recordExists = $stmt->fetchColumn() > 0;

            if ($recordExists) {
              // Update existing record
              $stmt = $pdo->prepare("UPDATE qcashPayment SET bgcashnum = ?, bgcashname = ?, bgcashQrImage = ? WHERE BusinessInfoID = ?");
              $stmt->execute([$gcashNum, $gcashName, $targetFile, $businessInfoID]);
              $response['message'] = 'G-Cash payment method updated successfully.';
            } else {
              // Insert new record
              $stmt = $pdo->prepare("INSERT INTO qcashPayment (BusinessInfoID, bgcashnum, bgcashname, bgcashQrImage) VALUES (?, ?, ?, ?)");
              $stmt->execute([$businessInfoID, $gcashNum, $gcashName, $targetFile]);
              $response['message'] = 'G-Cash payment method set up successfully.';
            }

            $response['message_type'] = 'success';
          } else {
            $response['message'] = 'Sorry, there was an error uploading your file.';
            $response['message_type'] = 'danger';
          }
        } else {
          $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed.';
          $response['message_type'] = 'danger';
        }
      } else {
        $response['message'] = 'Sorry, your file is too large.';
        $response['message_type'] = 'danger';
      }
    } else {
      $response['message'] = 'File is not an image.';
      $response['message_type'] = 'danger';
    }
  } else {
    $response['message'] = 'Please fill in all fields and upload an image.';
    $response['message_type'] = 'warning';
  }

  echo json_encode($response);
  exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Fetch existing data
  $stmt = $pdo->prepare("SELECT bgcashnum, bgcashname, bgcashQrImage FROM qcashPayment WHERE BusinessInfoID = ?");
  $stmt->execute([$businessInfoID]);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($record) {
    $response['data'] = $record;
  }

  echo json_encode($response);
  exit;
}
