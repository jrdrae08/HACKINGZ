<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  $_SESSION['error'] = 'Unauthorized';
  header('Location: ../../barangay/front-card.php');
  exit;
}

$barangayId = $_SESSION['user_id'];

function generateUniqueFilename($originalName)
{
  $extension = pathinfo($originalName, PATHINFO_EXTENSION);
  return uniqid() . '.' . $extension;
}

function uploadFile($inputName, $existingFile = null)
{
  // Check if the file input exists and a file was uploaded
  if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] == UPLOAD_ERR_NO_FILE) {
    return $existingFile; // Return existing file if no new file was uploaded
  }

  $targetDir = "../../barangay/fallsCategory/";
  $originalName = basename($_FILES[$inputName]["name"]);
  $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
  $uniqueName = uniqid() . '.' . $fileExtension;
  $targetFile = $targetDir . $uniqueName;

  // Check if image file is an actual image
  $check = getimagesize($_FILES[$inputName]["tmp_name"]);
  if ($check === false) {
    $_SESSION['error'] = "File is not an image.";
    header("Location: ../../barangay/front-card.php");
    exit;
  }

  if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
    // Delete the old file if it exists
    if ($existingFile && file_exists($targetDir . $existingFile)) {
      unlink($targetDir . $existingFile);
    }
    return $uniqueName;
  } else {
    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
    header("Location: ../../barangay/front-card.php");
    exit;
  }
}

try {
  // Check if the barangay already has media
  $stmt = $pdo->prepare("SELECT * FROM business_media WHERE barangayId = ?");
  $stmt->execute([$barangayId]);
  $existingMedia = $stmt->fetch(PDO::FETCH_ASSOC);

  // Handle file uploads with unique names
  $defaultImage = 'default-image.png'; // Set a path to a default image or keep it as null
  $thumbnail = uploadFile('thumbnail-image-1', $existingMedia['Thumbnail'] ?? null) ?? $defaultImage;
  $image1 = uploadFile('business-image-1', $existingMedia['Image1'] ?? null) ?? $defaultImage;
  $image2 = uploadFile('business-image-2', $existingMedia['Image2'] ?? null) ?? $defaultImage;
  $image3 = uploadFile('business-image-3', $existingMedia['Image3'] ?? null) ?? $defaultImage;
  $image4 = uploadFile('business-image-4', $existingMedia['Image4'] ?? null) ?? $defaultImage;
  $image5 = uploadFile('business-image-5', $existingMedia['Image5'] ?? null) ?? $defaultImage;
  $image6 = uploadFile('business-image-6', $existingMedia['Image6'] ?? null) ?? $defaultImage;

  $quotation = $_POST['quotation'];

  if ($existingMedia) {
    // Update existing media
    $stmt = $pdo->prepare("UPDATE business_media SET 
            Thumbnail = ?, 
            Quotation = ?, 
            Image1 = ?, 
            Image2 = ?, 
            Image3 = ?, 
            Image4 = ?, 
            Image5 = ?, 
            Image6 = ? 
            WHERE barangayId = ?");
    $success = $stmt->execute([$thumbnail, $quotation, $image1, $image2, $image3, $image4, $image5, $image6, $barangayId]);
  } else {
    // Insert new media
    $stmt = $pdo->prepare("INSERT INTO business_media 
            (barangayId, Thumbnail, Quotation, Image1, Image2, Image3, Image4, Image5, Image6) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$barangayId, $thumbnail, $quotation, $image1, $image2, $image3, $image4, $image5, $image6]);
  }

  if ($success) {
    $_SESSION['success'] = 'Media updated successfully';
  } else {
    $_SESSION['error'] = 'An error occurred while updating media';
  }
} catch (PDOException $e) {
  $_SESSION['error'] = 'Database error: ' . $e->getMessage();
}

header('Location: ../../barangay/front-card.php');
exit;
