<?php
include __DIR__ . '/../../includes/db.php';

function validate_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

function validate_image($file)
{
  if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
    return false; // No file uploaded, skip validation
  }

  $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
  $maxFileSize = 2 * 1024 * 1024; // 2MB

  $fileMimeType = mime_content_type($file['tmp_name']);
  $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $fileSize = $file['size'];

  if (!in_array($fileMimeType, $allowedMimeTypes)) {
    throw new Exception('Invalid image type.');
  }

  if (!in_array($fileExtension, $allowedExtensions)) {
    throw new Exception('Invalid image extension.');
  }

  if ($fileSize > $maxFileSize) {
    throw new Exception('File size exceeds the limit of 2MB.');
  }

  return true;
}

function compressAndConvertToWebP($file, $target_dir)
{
  $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  $webp_image_name = uniqid() . '-' . date('Ymd') . '.webp';
  $webp_target_file = $target_dir . $webp_image_name;

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $image = imagecreatefromjpeg($file["tmp_name"]);
      break;
    case 'png':
      $image = imagecreatefrompng($file["tmp_name"]);
      break;
    case 'gif':
      $image = imagecreatefromgif($file["tmp_name"]);
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

function validate_content_length($content, $minWords, $maxWords, $context)
{
  $wordCount = str_word_count($content);
  if ($wordCount < $minWords) {
    throw new Exception("$context must be at least $minWords words.");
  }
  if ($wordCount > $maxWords) {
    throw new Exception("$context must not exceed $maxWords words.");
  }
}

function deleteOldImage($pdo, $frontpageid, $columnName, $target_dir)
{
  $stmt = $pdo->prepare("SELECT $columnName FROM frontpagecontent WHERE frontpageid = :frontpageid");
  $stmt->execute([':frontpageid' => $frontpageid]);
  $oldImage = $stmt->fetchColumn();
  if ($oldImage) {
    $oldImagePath = $target_dir . $oldImage;
    if (file_exists($oldImagePath)) {
      unlink($oldImagePath);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $frontpageid = validate_input($_POST['frontpageid']);
    $description = validate_input($_POST['description']);
    $sliderTitle1 = validate_input($_POST['slider_title_1']);
    $sliderContent1 = validate_input($_POST['slider_content_1']);
    $sliderTitle2 = validate_input($_POST['slider_title_2']);
    $sliderContent2 = validate_input($_POST['slider_content_2']);
    $sliderTitle3 = validate_input($_POST['slider_title_3']);
    $sliderContent3 = validate_input($_POST['slider_content_3']);

    validate_content_length($description, 0, 50, "Description");
    validate_content_length($sliderContent1, 0, 25, "Content in Slider 1");
    validate_content_length($sliderContent2, 0, 25, "Content in Slider 2");
    validate_content_length($sliderContent3, 0, 25, "Content in Slider 3");

    $sliderImage1 = $_FILES['sliderimage1']['name'] ?? null;
    $sliderImage2 = $_FILES['sliderimage2']['name'] ?? null;
    $sliderImage3 = $_FILES['sliderimage3']['name'] ?? null;

    $target_dir = "../../admin/uploadannounce/";

    if ($sliderImage1) {
      validate_image($_FILES['sliderimage1']);
      deleteOldImage($pdo, $frontpageid, 'slider_image_1', $target_dir);
      $sliderImage1 = compressAndConvertToWebP($_FILES['sliderimage1'], $target_dir);
      if ($sliderImage1 === null) {
        throw new Exception("Sorry, there was an error converting slider image 1 to WebP.");
      }
    }
    if ($sliderImage2) {
      validate_image($_FILES['sliderimage2']);
      deleteOldImage($pdo, $frontpageid, 'slider_image_2', $target_dir);
      $sliderImage2 = compressAndConvertToWebP($_FILES['sliderimage2'], $target_dir);
      if ($sliderImage2 === null) {
        throw new Exception("Sorry, there was an error converting slider image 2 to WebP.");
      }
    }
    if ($sliderImage3) {
      validate_image($_FILES['sliderimage3']);
      deleteOldImage($pdo, $frontpageid, 'slider_image_3', $target_dir);
      $sliderImage3 = compressAndConvertToWebP($_FILES['sliderimage3'], $target_dir);
      if ($sliderImage3 === null) {
        throw new Exception("Sorry, there was an error converting slider image 3 to WebP.");
      }
    }

    $sql = "UPDATE frontpagecontent SET description = :description, slider_title_1 = :slider_title_1, slider_content_1 = :slider_content_1, 
            slider_title_2 = :slider_title_2, slider_content_2 = :slider_content_2, slider_title_3 = :slider_title_3, slider_content_3 = :slider_content_3";

    if ($sliderImage1) $sql .= ", slider_image_1 = :slider_image_1";
    if ($sliderImage2) $sql .= ", slider_image_2 = :slider_image_2";
    if ($sliderImage3) $sql .= ", slider_image_3 = :slider_image_3";

    $sql .= " WHERE frontpageid = :frontpageid";

    $stmt = $pdo->prepare($sql);
    $params = [
      ':description' => $description,
      ':slider_title_1' => $sliderTitle1,
      ':slider_content_1' => $sliderContent1,
      ':slider_title_2' => $sliderTitle2,
      ':slider_content_2' => $sliderContent2,
      ':slider_title_3' => $sliderTitle3,
      ':slider_content_3' => $sliderContent3,
      ':frontpageid' => $frontpageid
    ];
    if ($sliderImage1) $params[':slider_image_1'] = $sliderImage1;
    if ($sliderImage2) $params[':slider_image_2'] = $sliderImage2;
    if ($sliderImage3) $params[':slider_image_3'] = $sliderImage3;

    $stmt->execute($params);

    $response = [
      'success' => 'Content updated successfully!',
      'frontpageid' => $frontpageid,
      'description' => $description,
      'slider_title_1' => $sliderTitle1,
      'slider_content_1' => $sliderContent1,
      'slider_title_2' => $sliderTitle2,
      'slider_content_2' => $sliderContent2,
      'slider_title_3' => $sliderTitle3,
      'slider_content_3' => $sliderContent3,
      'slider_image_1' => $sliderImage1,
      'slider_image_2' => $sliderImage2,
      'slider_image_3' => $sliderImage3
    ];

    echo json_encode($response);
  } catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
  }
} else {
  echo json_encode(['error' => 'Invalid request method.']);
}
