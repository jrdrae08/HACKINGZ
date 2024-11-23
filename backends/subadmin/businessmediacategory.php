<?php
include __DIR__ . '/../../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $businessInfoID = $_SESSION['business_info_id'];

  // Get the quotation and validate word count
  $quotation = filter_var($_POST['quotation'], FILTER_SANITIZE_STRING);
  $wordCount = str_word_count($quotation);
  if ($wordCount > 30) {
    $_SESSION['error'] = "Quotation should be 30 words or less.";
    header("Location: ../../businessowner/front-card.php");
    exit;
  }

  // Check if the business already has media
  $stmt = $pdo->prepare("SELECT * FROM business_media WHERE BusinessInfoID = ?");
  $stmt->execute([$businessInfoID]);
  $existingMedia = $stmt->fetch(PDO::FETCH_ASSOC);

  // Handle file uploads with unique names
  $defaultImage = 'default-image.png'; // Set a path to a default image or keep it as null
  $thumbnail = uploadFile('thumbnail-image-1', true, [600, 600]) ?? $existingMedia['Thumbnail'] ?? $defaultImage;
  $image1 = uploadFile('business-image-1', false) ?? $existingMedia['Image1'] ?? $defaultImage;
  $image2 = uploadFile('business-image-2', false) ?? $existingMedia['Image2'] ?? $defaultImage;
  $image3 = uploadFile('business-image-3', false) ?? $existingMedia['Image3'] ?? $defaultImage;
  $image4 = uploadFile('business-image-4', false) ?? $existingMedia['Image4'] ?? $defaultImage;
  $image5 = uploadFile('business-image-5', false) ?? $existingMedia['Image5'] ?? $defaultImage;
  $image6 = uploadFile('business-image-6', false) ?? $existingMedia['Image6'] ?? $defaultImage;

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
            WHERE BusinessInfoID = ?");
    $success = $stmt->execute([$thumbnail, $quotation, $image1, $image2, $image3, $image4, $image5, $image6, $businessInfoID]);
  } else {
    // Insert new media
    $stmt = $pdo->prepare("INSERT INTO business_media 
            (BusinessInfoID, Thumbnail, Quotation, Image1, Image2, Image3, Image4, Image5, Image6) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$businessInfoID, $thumbnail, $quotation, $image1, $image2, $image3, $image4, $image5, $image6]);
  }

  if ($success) {
    $_SESSION['success'] = 'Business media updated successfully!';
  } else {
    $_SESSION['error'] = 'An error occurred while updating business media.';
  }

  header("Location: ../../businessowner/front-card.php");
  exit;
}

function uploadFile($inputName, $isThumbnail = false, $resizeDimensions = null)
{
  // Check if the file input exists and a file was uploaded
  if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] == UPLOAD_ERR_NO_FILE) {
    return null; // Return null if no file was uploaded
  }

  $targetDir = "../../businessowner/businessmediacategory/";
  $originalName = basename($_FILES[$inputName]["name"]);
  $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
  $uniqueName = uniqid() . '.' . $fileExtension;
  $targetFile = $targetDir . $uniqueName;

  // Check if image file is an actual image
  $check = getimagesize($_FILES[$inputName]["tmp_name"]);
  if ($check === false) {
    $_SESSION['error'] = "File is not an image.";
    header("Location: ../../businessowner/front-card.php");
    exit;
  }


  // Resize and save the image
  if ($isThumbnail && $resizeDimensions) {
    resizeImage($_FILES[$inputName]["tmp_name"], $resizeDimensions[0], $resizeDimensions[1], $targetFile);
  } else {
    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
      compressImage($targetFile, $targetFile, $fileExtension);  // Compress the image after moving
      return $uniqueName;
    } else {
      $_SESSION['error'] = "Sorry, there was an error uploading your file.";
      header("Location: ../../businessowner/front-card.php");
      exit;
    }
  }

  return $uniqueName;
}

function resizeImage($file, $width, $height, $targetFile)
{
  list($originalWidth, $originalHeight) = getimagesize($file);
  $image_p = imagecreatetruecolor($width, $height);

  // Determine file type and create an image resource
  $image = null;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $image = imagecreatefromjpeg($file);
      break;
    case 'png':
      $image = imagecreatefrompng($file);
      break;
    case 'gif':
      $image = imagecreatefromgif($file);
      break;
    case 'webp':
      $image = imagecreatefromwebp($file);
      break;
    default:
      $_SESSION['error'] = "Unsupported image format.";
      header("Location: ../../businessowner/front-card.php");
      exit;
  }

  // Check if the image resource is valid
  if ($image === false) {
    $_SESSION['error'] = "Failed to create image from file.";
    header("Location: ../../businessowner/front-card.php");
    exit;
  }

  // Resample the image
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

  // Output the resized image
  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      imagejpeg($image_p, $targetFile, 75); // Reduced quality for compression
      break;
    case 'png':
      imagepng($image_p, $targetFile, 8); // Increased compression
      break;
    case 'gif':
      imagegif($image_p, $targetFile);
      break;
  }

  imagedestroy($image);
  imagedestroy($image_p);
}

function compressImage($source, $destination, $imageFileType)
{
  $image_p = imagecreatefromstring(file_get_contents($source));

  // Compress and save the image with more aggressive settings
  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      imagejpeg($image_p, $destination, 60); // Lower the quality to 60 (out of 100)
      break;
    case 'png':
      imagepng($image_p, $destination, 8); // Increase the compression level to 8 (out of 9)
      break;
    case 'gif':
      imagegif($image_p, $destination); // GIFs are generally small already
      break;
    case 'webp':
      imagewebp($image_p, $destination, 80); // Convert to WebP with 80% quality
      break;
  }

  imagedestroy($image_p);
}
