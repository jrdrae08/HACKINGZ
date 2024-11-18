<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../../includes/db.php";

$businessInfoID = $_SESSION['business_info_id'];

$response = [
  'businessInfoID' => $businessInfoID,
  'message' => '',
  'message_type' => '',
  'data' => null
];

try {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gcashNum = filter_var($_POST['gcashnum'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $gcashName = filter_var($_POST['gcashname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $isUpdate = filter_var($_POST['isUpdate'], FILTER_VALIDATE_BOOLEAN);

    if ($isUpdate) {
      // Update logic
      if (!empty($gcashNum) && !empty($gcashName)) {
        if (isset($_FILES['qrimage1']) && $_FILES['qrimage1']['error'] == UPLOAD_ERR_OK) {
          // Retrieve the current image path
          $stmt = $pdo->prepare("SELECT bgcashQrImage FROM qcashPayment WHERE BusinessInfoID = ?");
          $stmt->execute([$businessInfoID]);
          $currentImage = $stmt->fetchColumn();

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
                  // Delete the old image file
                  if ($currentImage && file_exists($currentImage)) {
                    unlink($currentImage);
                  }

                  // Update existing record with new image
                  $stmt = $pdo->prepare("UPDATE qcashPayment SET bgcashnum = ?, bgcashname = ?, bgcashQrImage = ? WHERE BusinessInfoID = ?");
                  $stmt->execute([$gcashNum, $gcashName, $targetFile, $businessInfoID]);
                  $response['message'] = 'G-Cash payment method updated successfully.';
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
          // Update existing record without changing the image
          $stmt = $pdo->prepare("UPDATE qcashPayment SET bgcashnum = ?, bgcashname = ? WHERE BusinessInfoID = ?");
          $stmt->execute([$gcashNum, $gcashName, $businessInfoID]);
          $response['message'] = 'G-Cash payment method updated successfully.';
          $response['message_type'] = 'success';
        }
      } else {
        $response['message'] = 'Please fill in all fields.';
        $response['message_type'] = 'warning';
      }
    } else {
      // Registration logic
      if (!empty($gcashNum) && !empty($gcashName) && isset($_FILES['qrimage1']) && $_FILES['qrimage1']['error'] == UPLOAD_ERR_OK) {
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
                // Insert new record
                $stmt = $pdo->prepare("INSERT INTO qcashPayment (BusinessInfoID, bgcashnum, bgcashname, bgcashQrImage) VALUES (?, ?, ?, ?)");
                $stmt->execute([$businessInfoID, $gcashNum, $gcashName, $targetFile]);
                $response['message'] = 'G-Cash payment method set up successfully.';
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
    }
  }
} catch (Exception $e) {
  $response['message'] = 'An error occurred: ' . $e->getMessage();
  $response['message_type'] = 'danger';
}

echo json_encode($response);
exit;
