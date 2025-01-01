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
  $uniqueName = uniqid() . '.webp';
  $targetFile = $targetDir . $uniqueName;

  // Check if image file is an actual image
  $check = getimagesize($_FILES[$inputName]["tmp_name"]);
  if ($check === false) {
    $_SESSION['error'] = "File is not an image.";
    header("Location: ../../barangay/front-card.php");
    exit;
  }

  // Compress and convert image to WebP
  $image = null;
  switch ($fileExtension) {
    case 'jpg':
    case 'jpeg':
      $image = imagecreatefromjpeg($_FILES[$inputName]["tmp_name"]);
      break;
    case 'png':
      $image = imagecreatefrompng($_FILES[$inputName]["tmp_name"]);
      break;
    case 'gif':
      $image = imagecreatefromgif($_FILES[$inputName]["tmp_name"]);
      break;
    default:
      $_SESSION['error'] = "Unsupported file type.";
      header("Location: ../../barangay/front-card.php");
      exit;
  }

  if ($image === null) {
    $_SESSION['error'] = "Failed to create image resource.";
    header("Location: ../../barangay/front-card.php");
    exit;
  }

  if (imagewebp($image, $targetFile, 80)) { // 80 is the quality for WebP
    imagedestroy($image);
    // Delete the old file if it exists
    if ($existingFile && file_exists($targetDir . $existingFile)) {
      unlink($targetDir . $existingFile);
    }
    return $uniqueName;
  } else {
    imagedestroy($image);
    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
    header("Location: ../../barangay/front-card.php");
    exit;
  }
}

try {
  // Validate quotation
  if (empty($_POST['quotation'])) {
    $_SESSION['error'] = 'Quotation is required.';
    header('Location: ../../barangay/front-card.php');
    exit;
  }

  // Check if the barangay already has media
  $stmt = $pdo->prepare("SELECT * FROM business_media WHERE barangayId = ?");
  $stmt->execute([$barangayId]);
  $existingMedia = $stmt->fetch(PDO::FETCH_ASSOC);

  // Handle file uploads with unique names
  $thumbnail = uploadFile('thumbnail-image-1', $existingMedia['Thumbnail'] ?? null);
  $image1 = uploadFile('business-image-1', $existingMedia['Image1'] ?? null);
  $image2 = uploadFile('business-image-2', $existingMedia['Image2'] ?? null);
  $image3 = uploadFile('business-image-3', $existingMedia['Image3'] ?? null);
  $image4 = uploadFile('business-image-4', $existingMedia['Image4'] ?? null);
  $image5 = uploadFile('business-image-5', $existingMedia['Image5'] ?? null);
  $image6 = uploadFile('business-image-6', $existingMedia['Image6'] ?? null);

  // Validate that at least the thumbnail and two images are uploaded
  $uploadedImages = array_filter([$image1, $image2, $image3, $image4, $image5, $image6]);

  if (empty($thumbnail) || count($uploadedImages) < 2) {
    $_SESSION['error'] = 'Please upload at least the thumbnail and two images.';
    header('Location: ../../barangay/front-card.php');
    exit;
  }

  // Set non-uploaded images to null
  $image1 = $image1 ?: null;
  $image2 = $image2 ?: null;
  $image3 = $image3 ?: null;
  $image4 = $image4 ?: null;
  $image5 = $image5 ?: null;
  $image6 = $image6 ?: null;

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
