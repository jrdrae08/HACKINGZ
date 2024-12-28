<?php
// Start the session
session_start();
// Get the application ID from the URL or POST data
if (isset($_GET['application_id'])) {
  $applicationID = filter_input(INPUT_GET, 'application_id', FILTER_SANITIZE_NUMBER_INT);
}
// Include the database connection file
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = array();

  // Sanitize and validate form inputs
  $pexpidate = filter_input(INPUT_POST, 'bexdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $permit = $_FILES['businessPermitImage'];
  $applicationID = filter_input(INPUT_POST, 'application_id', FILTER_SANITIZE_NUMBER_INT);

  // Validate expiration date
  date_default_timezone_set('Asia/Hong_Kong'); // Set the timezone to Asia/Hong_Kong
  $currentDate = new DateTime();
  $expirationDate = DateTime::createFromFormat('Y-m-d', $pexpidate);

  if ($expirationDate < $currentDate) {
    array_push($errors, "Business Permit Expiration Date cannot be in the past.");
  }

  // Validate that the month is December and the day is 31
  if ($expirationDate->format('m') != '12' || $expirationDate->format('d') != '31') {
    array_push($errors, "Business Permit Expiration Date must be December 31.");
  }

  // Fetch the existing PermitExpDate and renewalReject from the database
  $stmt = $pdo->prepare("SELECT PermitExpDate, renewalReject FROM businessapplicationform WHERE ApplicationID = ?");
  $stmt->execute([$applicationID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $existingPermitExpDate = $result['PermitExpDate'];
  $renewalReject = $result['renewalReject'];

  if ($existingPermitExpDate) {
    $existingPermitExpDate = new DateTime($existingPermitExpDate);
    if ($expirationDate->format('Y') <= $existingPermitExpDate->format('Y')) {
      array_push($errors, "New Business Permit Expiration Date must be in a future year relative to the existing Permit Expiration Date.");
    }
  }

  // Check if permit is uploaded
  if ($permit['error'] == 0) {
    // Fetch the existing BusinessPermitImage name from the database
    $stmt = $pdo->prepare("SELECT BusinessPermitImage FROM businessapplicationform WHERE ApplicationID = ?");
    $stmt->execute([$applicationID]);
    $existingImage = $stmt->fetchColumn();

    if ($existingImage) {
      // Extract the unique ID and base name from the existing image name
      $parts = explode('-', $existingImage);
      $uniqueID = $parts[0];
      $baseName = end($parts);

      // Create the new image name with the updated date
      $newDate = date('Ymd');
      $newImageName = $uniqueID . '-' . $newDate . '-' . $baseName;

      $target_dir = "../../businessowner/uploadsapp/newPermit/";
      $target_file = $target_dir . $newImageName;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // Check if image file is an actual image
      $check = getimagesize($permit["tmp_name"]);
      if ($check === false) {
        array_push($errors, "File is not an image.");
      }

      // Check file size (limit to 5MB)
      if ($permit["size"] > 5000000) {
        array_push($errors, "Sorry, your file is too large.");
      }

      // Allow certain file formats
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
      }

      // Check if $errors is empty
      if (empty($errors)) {
        if (!move_uploaded_file($permit["tmp_name"], $target_file)) {
          array_push($errors, "Sorry, there was an error uploading your file.");
        }
      }
    } else {
      array_push($errors, "Existing Business Permit Image not found.");
    }
  } else {
    array_push($errors, "Business permit is required.");
  }

  if (empty($errors)) {
    try {
      // Insert the new BusinessPermitImage, newPermitDate, reuploadDate, and reset renewalReject to 0 if it was 1
      $reuploadDate = $currentDate->format('Y-m-d');
      if ($renewalReject == 1) {
        $stmt = $pdo->prepare("UPDATE businessapplicationform SET BusinessPermitImage = ?, newPermitDate = ?, reuploadDate = ?, renewalReject = 0 WHERE ApplicationID = ?");
        $stmt->execute([$newImageName, $pexpidate, $reuploadDate, $applicationID]);
      } else {
        $stmt = $pdo->prepare("UPDATE businessapplicationform SET BusinessPermitImage = ?, newPermitDate = ?, reuploadDate = ? WHERE ApplicationID = ?");
        $stmt->execute([$newImageName, $pexpidate, $reuploadDate, $applicationID]);
      }

      $_SESSION['type'] = "success";
      $_SESSION['message'] = "Business Permit updated successfully.";
      header('Location: ../../businessowner/success.php');
      exit();
    } catch (PDOException $e) {
      $_SESSION['message'] = "Error: " . $e->getMessage();
      $_SESSION['type'] = "danger";
      header('Location: ../../businessowner/business_renew.php');
      exit();
    }
  } else {
    $_SESSION['message'] = implode('<br>', $errors);
    $_SESSION['type'] = "danger";
    header('Location: ../../businessowner/business_renew.php?application_id=' . $applicationID);
    exit();
  }
}
