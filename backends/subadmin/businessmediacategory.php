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
  $thumbnail = handleFileUpload('thumbnail-image-1', $existingMedia['Thumbnail'] ?? null) ?? $existingMedia['Thumbnail'] ?? $defaultImage;
  $image1 = handleFileUpload('business-image-1', $existingMedia['Image1'] ?? null) ?? $existingMedia['Image1'] ?? $defaultImage;
  $image2 = handleFileUpload('business-image-2', $existingMedia['Image2'] ?? null) ?? $existingMedia['Image2'] ?? $defaultImage;
  $image3 = handleFileUpload('business-image-3', $existingMedia['Image3'] ?? null) ?? $existingMedia['Image3'] ?? $defaultImage;
  $image4 = handleFileUpload('business-image-4', $existingMedia['Image4'] ?? null) ?? $existingMedia['Image4'] ?? $defaultImage;
  $image5 = handleFileUpload('business-image-5', $existingMedia['Image5'] ?? null) ?? $existingMedia['Image5'] ?? $defaultImage;
  $image6 = handleFileUpload('business-image-6', $existingMedia['Image6'] ?? null) ?? $existingMedia['Image6'] ?? $defaultImage;

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

function handleFileUpload($inputName, $existingFile = null)
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

  // Delete the existing file if it exists
  if ($existingFile && file_exists($targetDir . $existingFile)) {
    unlink($targetDir . $existingFile);
  }

  if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
    $webpFile = convertToWebP($targetFile, $fileExtension);  // Convert the image to WebP after moving
    return $webpFile;
  } else {
    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
    header("Location: ../../businessowner/front-card.php");
    exit;
  }

  return $uniqueName;
}

function convertToWebP($source, $imageFileType)
{
  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $image_p = imagecreatefromjpeg($source);
      break;
    case 'png':
      $image_p = imagecreatefrompng($source);
      break;
    case 'gif':
      $image_p = imagecreatefromgif($source);
      break;
    case 'webp':
      // If the source is already a WebP file, no need to convert
      return basename($source);
    default:
      $_SESSION['error'] = "Unsupported image format.";
      header("Location: ../../businessowner/front-card.php");
      exit;
  }

  $webpDestination = preg_replace('/\.[^.]+$/', '.webp', $source);

  // Convert to true color image if necessary
  if (imageistruecolor($image_p) === false) {
    $trueColorImage = imagecreatetruecolor(imagesx($image_p), imagesy($image_p));
    imagecopy($trueColorImage, $image_p, 0, 0, 0, 0, imagesx($image_p), imagesy($image_p));
    imagedestroy($image_p);
    $image_p = $trueColorImage;
  }

  // Convert to WebP and save the image
  imagewebp($image_p, $webpDestination, 80);

  imagedestroy($image_p);

  // Remove the original file if it exists
  if (file_exists($source)) {
    unlink($source);
  }

  return basename($webpDestination);
}
