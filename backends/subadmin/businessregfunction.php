<?php
// Start the session
session_start();

// Include the database connection file
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = array();

  // Sanitize and validate form inputs
  $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $mname = filter_input(INPUT_POST, 'mname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $pexpidate = filter_input(INPUT_POST, 'bexdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $btype = filter_input(INPUT_POST, 'btype', FILTER_SANITIZE_NUMBER_INT);
  $bname = filter_input(INPUT_POST, 'bname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $barangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $city = 'Majayjay';
  $province = 'Laguna';
  $bemail = filter_input(INPUT_POST, 'bemail', FILTER_VALIDATE_EMAIL);
  $bcontact = filter_input(INPUT_POST, 'bcontact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $bdesc = filter_input(INPUT_POST, 'bdesc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $permit = $_FILES['permit'];

  // Store form data in session
  $_SESSION['form_data'] = $_POST;

  // Validate email
  if ($email === false) {
    array_push($errors, "Invalid email format for registrant.");
  }

  // Validate business email if provided
  if (!empty($bemail) && $bemail === false) {
    array_push($errors, "Invalid email format for business.");
  }

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
  // Check if permit is uploaded
  if ($permit['error'] == 0) {
    $target_dir = "../../businessowner/uploadsapp/";
    date_default_timezone_set('Asia/Hong_Kong'); // Set the timezone to Asia/Hong_Kong
    $image_name = uniqid() . '-' . date('Ymd') . '-' . basename($permit["name"]); // Create a unique name for the file with date
    $target_file = $target_dir . $image_name;
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
    array_push($errors, "Business permit is required.");
  }

  // Check if business type is selected
  if (empty($btype)) {
    array_push($errors, "Type of business is required.");
  }

  // Check if barangay is selected
  if (empty($barangay)) {
    array_push($errors, "Barangay is required.");
  }

  // Check for duplicate email if IsReject is 0
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM businessapplicationform WHERE Email = :email");
  $stmt->execute([':email' => $email]);
  $emailCount = $stmt->fetchColumn();
  if ($emailCount > 0) {
    array_push($errors, "Email already exists.");
  }

  // Check for duplicate business name if IsReject is 0
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM businessinformationform bif
                           JOIN businessapplicationform baf ON bif.ApplicationID = baf.ApplicationID
                           WHERE bif.BusinessName = :bname AND baf.IsReject = 0");
  $stmt->execute([':bname' => $bname]);
  $bnameCount = $stmt->fetchColumn();
  if ($bnameCount > 0) {
    array_push($errors, "Business Name already exists.");
  }

  if (empty($errors)) {
    try {
      // Start transaction
      $pdo->beginTransaction();

      // Generate reference number
      $refNum = 'REF-' . strtoupper(uniqid());

      // Insert into businessapplicationform
      $stmt1 = $pdo->prepare("INSERT INTO businessapplicationform (RegistrantFirstName, RegistrantMiddleName, RegistrantLastName, ContactNumber, Email, BusinessPermitImage, PermitExpDate, RefNum, IsRead)
                                    VALUES (:fname, :mname, :lname, :contact, :email, :permit, :pexdate, :refnum, FALSE)");
      $stmt1->execute([
        ':fname' => $fname,
        ':mname' => $mname,
        ':lname' => $lname,
        ':contact' => $contact,
        ':email' => $email,
        ':permit' => $image_name,
        ':pexdate' => $pexpidate,
        ':refnum' => $refNum
      ]);

      $application_id = $pdo->lastInsertId();

      // Concatenate full address
      $full_address = $street . ', ' . $barangay . ', ' . $city . ', ' . $province;

      // Insert into businessinformationform with concatenated full address
      $stmt2 = $pdo->prepare("INSERT INTO businessinformationform (ApplicationID, BusinessName, BusinessAddress, BusinessTypeID, BusinessEmail, BusinessContactNumber, BusinessDescription)
                                    VALUES (:application_id, :bname, :full_address, :btype, :bemail, :bcontact, :bdesc)");
      $stmt2->execute([
        ':application_id' => $application_id,
        ':bname' => $bname,
        ':full_address' => $full_address,
        ':btype' => $btype,
        ':bemail' => $bemail,
        ':bcontact' => $bcontact,
        ':bdesc' => $bdesc
      ]);

      // Commit transaction
      $pdo->commit();

      // Clear form data from session
      unset($_SESSION['form_data']);

      $_SESSION['type'] = "success";
      header('Location: ../../businessowner/success.php');
      exit();
    } catch (PDOException $e) {
      // Rollback transaction
      $pdo->rollBack();
      $_SESSION['message'] = "Error: " . $e->getMessage();
      $_SESSION['type'] = "danger";
      header('Location: ../../businessowner/business-registration.php');
      exit();
    }
  } else {
    $_SESSION['message'] = implode('<br>', $errors);
    $_SESSION['type'] = "danger";
    header('Location: ../../businessowner/business-registration.php');
    exit();
  }
}
