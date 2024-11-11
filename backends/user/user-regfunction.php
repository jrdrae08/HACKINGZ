<?php
session_start();
require_once '../../includes/db.php';

function uploadFile($file, $targetDir, $newFileName)
{
  $targetFile = $targetDir . $newFileName;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

  // Check if file is an actual image
  $check = getimagesize($file["tmp_name"]);
  if ($check === false) {
    return false;
  }

  // Check file size (limit to 5MB)
  if ($file["size"] > 5000000) {
    return false;
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    return false;
  }

  // Try to upload file
  if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    return $targetFile;
  } else {
    return false;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $full_name = $fname . ' ' . $lname;
  $u_email = $_POST['u_email'];
  $u_contact = $_POST['u_contact'];
  $u_address = $_POST['u_address'];
  $locationType = $_POST['locationType'];
  $sex = $_POST['sex'];
  $id_type = $_POST['id_type'] === 'other' ? $_POST['other_id_type'] : $_POST['id_type'];

  try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE u_email = ?");
    $stmt->execute([$u_email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
      echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
      exit();
    }

    // Insert user data into the database
    $stmt = $pdo->prepare("INSERT INTO users (full_name, u_email, u_contact, u_address, locationType, sex, id_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $u_email, $u_contact, $u_address, $locationType, $sex, $id_type]);

    // Get the last inserted user ID
    $userId = $pdo->lastInsertId();

    // Create a directory for the user
    $userDir = "../../user/userID/" . $lname . "/";
    if (!is_dir($userDir)) {
      mkdir($userDir, 0755, true);
    }

    // Generate unique filenames for the uploaded files
    $front_id_filename = $lname . "_" . $userId . "_front." . strtolower(pathinfo($_FILES['front_id']['name'], PATHINFO_EXTENSION));
    $back_id_filename = $lname . "_" . $userId . "_back." . strtolower(pathinfo($_FILES['back_id']['name'], PATHINFO_EXTENSION));

    // Upload files
    $front_id = uploadFile($_FILES['front_id'], $userDir, $front_id_filename);
    $back_id = isset($_FILES['back_id']) && $_FILES['back_id']['error'] == 0 ? uploadFile($_FILES['back_id'], $userDir, $back_id_filename) : null;

    if ($front_id === false || ($back_id === false && isset($_FILES['back_id']) && $_FILES['back_id']['error'] == 0)) {
      echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
      exit();
    }

    // Update the user record with the file paths
    $stmt = $pdo->prepare("UPDATE users SET front_id = ?, back_id = ? WHERE userId = ?");
    $stmt->execute([$front_id, $back_id, $userId]);

    echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
  }

  exit();
}
