<?php
// bookingreg.php
session_start();
include '../../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Fetch roomID, businessInfoID, and userID from the URL
  $roomID = isset($_GET['roomID']) ? (int) $_GET['roomID'] : 1;
  $businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;
  $userID = isset($_GET['userID']) ? (int) $_GET['userID'] : 1;

  // Fetch form data and sanitize inputs
  $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
  $regadd = filter_var($_POST['regadd'], FILTER_SANITIZE_STRING);
  $u_email = filter_var($_POST['u_email'], FILTER_SANITIZE_EMAIL);
  $u_contact = filter_var($_POST['u_contact'], FILTER_SANITIZE_STRING);
  $daterange = filter_var($_POST['daterange'], FILTER_SANITIZE_STRING);
  list($checkin, $departure) = explode(' - ', $daterange);
  $gcash_reference = isset($_POST['gcash_reference']) ? filter_var($_POST['gcash_reference'], FILTER_SANITIZE_STRING) : null;
  $proofofpayment = isset($_FILES['proofofpayment']) ? $_FILES['proofofpayment'] : null;

  // Check if the user has already booked the room
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE roomID = :roomID AND userID = :userID AND status IN ('Pending', 'Accepted', 'Ongoing')");
  $stmt->execute([':roomID' => $roomID, ':userID' => $userID]);
  $existingBookingCount = $stmt->fetchColumn();

  if ($existingBookingCount > 0) {
    echo json_encode(['message' => 'You have already booked this room. Please check your reservation status', 'type' => 'danger']);
    exit;
  }

  // Handle file upload for proof of payment
  $proofOfPaymentPath = null;
  if ($proofofpayment && $proofofpayment['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../../businessowner/userPaymentProof/';
    $proofOfPaymentPath = $uploadDir . basename($proofofpayment['name']);
    $fileType = pathinfo($proofOfPaymentPath, PATHINFO_EXTENSION);

    // Check if file is an image
    $check = getimagesize($proofofpayment['tmp_name']);
    if ($check !== false && in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
      if (!move_uploaded_file($proofofpayment['tmp_name'], $proofOfPaymentPath)) {
        // Handle file upload error
        echo json_encode(['message' => 'File upload failed.', 'type' => 'danger']);
        exit;
      }
    } else {
      echo json_encode(['message' => 'Invalid file type.', 'type' => 'danger']);
      exit;
    }
  }

  // Generate a unique reference number
  function generateReferenceNum()
  {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $referenceNum = 'REF-';
    for ($i = 0; $i < 6; $i++) {
      $referenceNum .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $referenceNum;
  }

  $referenceNum = generateReferenceNum();

  try {
    // Insert into reservations table
    $query = "INSERT INTO reservations (roomID, userID, fullname, regadd, regemail, regnum, checkin, departure, referenceNum, datetime, status) VALUES (:roomID, :userID, :fullname, :regadd, :regemail, :regnum, :checkin, :departure, :referenceNum, NOW(), 'Pending')";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':roomID' => $roomID,
      ':userID' => $userID,
      ':fullname' => $fullname,
      ':regadd' => $regadd,
      ':regemail' => $u_email,
      ':regnum' => $u_contact,
      ':checkin' => $checkin,
      ':departure' => $departure,
      ':referenceNum' => $referenceNum
    ]);

    // Get the last inserted reservation ID
    $reservationID = $pdo->lastInsertId();

    // Insert into reservation_payments
    $totalPrice = filter_var($_POST['totalPrice'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $query = "INSERT INTO reservation_payments (revID, totalPrice) VALUES (:revID, :totalPrice)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':revID' => $reservationID,
      ':totalPrice' => $totalPrice
    ]);

    // Insert into userPayment table only if payment details are provided
    if ($gcash_reference && $proofOfPaymentPath) {
      $query = "INSERT INTO userpayment (revID, roomID, businessinfoID, userID, IsPaid, proofOfPayment, gcashReference) VALUES (:revID, :roomID, :businessinfoID, :userID, 0, :proofOfPayment, :gcashReference)";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
        ':revID' => $reservationID,
        ':roomID' => $roomID,
        ':businessinfoID' => $businessInfoID,
        ':userID' => $userID,
        ':proofOfPayment' => $proofOfPaymentPath,
        ':gcashReference' => $gcash_reference
      ]);
    }

    // Insert into userdemographics table
    $names = isset($_POST['name']) ? filter_var_array($_POST['name'], FILTER_SANITIZE_STRING) : [$fullname];
    $sexes = isset($_POST['sex']) ? filter_var_array((array)$_POST['sex'], FILTER_SANITIZE_STRING) : [$_POST['sex']];
    $locations = isset($_POST['location']) ? filter_var_array((array)$_POST['location'], FILTER_SANITIZE_STRING) : [$_POST['locationType']];
    $totalnumAttendees = count($names);
    $totalmale = count(array_filter($sexes, fn($sex) => $sex === 'Male'));
    $totalfemale = count(array_filter($sexes, fn($sex) => $sex === 'Female'));
    $thisCity = count(array_filter($locations, fn($location) => $location === 'This City/Municipality'));
    $otherCity = count(array_filter($locations, fn($location) => $location === 'Other City/Municipality'));
    $otherProvince = count(array_filter($locations, fn($location) => $location === 'Other Province'));
    $foreignCountry = count(array_filter($locations, fn($location) => $location === 'Foreign Country'));

    // Concatenate the arrays into strings
    $allNames = implode(', ', array_map('filter_var', $names, array_fill(0, count($names), FILTER_SANITIZE_STRING)));
    $allSexes = implode(', ', array_map('filter_var', $sexes, array_fill(0, count($sexes), FILTER_SANITIZE_STRING)));
    $allLocations = implode(', ', array_map('filter_var', $locations, array_fill(0, count($locations), FILTER_SANITIZE_STRING)));

    $query = "INSERT INTO userdemographics (userID, roomID, BusinessInfoID, name, sex, location, created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry, isAccepted) VALUES (:userID, :roomID, :businessInfoID, :name, :sex, :location, NOW(), :totalnumAttendees, :totalmale, :totalfemale, :thisCity, :otherCity, :otherProvince, :foreignCountry, 'Pending')";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':userID' => $userID,
      ':roomID' => $roomID,
      ':businessInfoID' => $businessInfoID,
      ':name' => $allNames,
      ':sex' => $allSexes,
      ':location' => $allLocations,
      ':totalnumAttendees' => $totalnumAttendees,
      ':totalmale' => $totalmale,
      ':totalfemale' => $totalfemale,
      ':thisCity' => $thisCity,
      ':otherCity' => $otherCity,
      ':otherProvince' => $otherProvince,
      ':foreignCountry' => $foreignCountry
    ]);

    // Send a success response
    echo json_encode(['message' => 'Booking successful! please wait', 'type' => 'success']);
    exit;
  } catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['message' => 'Database error: ' . $e->getMessage(), 'type' => 'danger']);
    exit;
  }
} else {
  // Handle invalid request method
  echo json_encode(['message' => 'Invalid request method.', 'type' => 'danger']);
  exit;
}
