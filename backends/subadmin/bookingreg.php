<?php
// bookingreg.php
session_start();
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Fetch roomID, businessInfoID, and userID from the URL
  $roomID = isset($_GET['roomID']) ? (int) $_GET['roomID'] : 1;
  $businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;
  $userID = isset($_GET['userID']) ? (int) $_GET['userID'] : 1;

  // Fetch form data
  $fullname = $_POST['fullname'];
  $regadd = $_POST['regadd'];
  $u_email = $_POST['u_email'];
  $u_contact = $_POST['u_contact'];
  $daterange = $_POST['daterange'];
  list($checkin, $departure) = explode(' - ', $daterange);
  $gcash_reference = isset($_POST['gcash_reference']) ? $_POST['gcash_reference'] : null;
  $proofofpayment = isset($_FILES['proofofpayment']) ? $_FILES['proofofpayment'] : null;

  // Handle file upload for proof of payment
  $proofOfPaymentPath = null;
  if ($proofofpayment && $proofofpayment['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../../businessowner/userPaymentProof/';
    $proofOfPaymentPath = $uploadDir . basename($proofofpayment['name']);
    if (!move_uploaded_file($proofofpayment['tmp_name'], $proofOfPaymentPath)) {
      // Handle file upload error
      $proofOfPaymentPath = null;
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

  // Insert into userPayment table only if payment details are provided
  if ($gcash_reference && $proofOfPaymentPath) {
    $query = "INSERT INTO userPayment (roomID, businessinfoID, userID, IsPaid, proofOfPayment, gcashReference) VALUES (:roomID, :businessinfoID, :userID, 0, :proofOfPayment, :gcashReference)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':roomID' => $roomID,
      ':businessinfoID' => $businessInfoID,
      ':userID' => $userID,
      ':proofOfPayment' => $proofOfPaymentPath,
      ':gcashReference' => $gcash_reference
    ]);
  }

  // Insert into bownerdemographics table
  $names = $_POST['name'];
  $sexes = $_POST['sex'];
  $locations = $_POST['location'];
  $totalnumAttendees = count($names);
  $totalmale = count(array_filter($sexes, fn($sex) => $sex === 'Male'));
  $totalfemale = count(array_filter($sexes, fn($sex) => $sex === 'Female'));
  $thisCity = count(array_filter($locations, fn($location) => $location === 'This City/Municipality'));
  $otherCity = count(array_filter($locations, fn($location) => $location === 'Other City/Municipality'));
  $otherProvince = count(array_filter($locations, fn($location) => $location === 'Other Province'));
  $foreignCountry = count(array_filter($locations, fn($location) => $location === 'Foreign Country'));

  // Concatenate the arrays into strings
  $allNames = implode(', ', $names);
  $allSexes = implode(', ', $sexes);
  $allLocations = implode(', ', $locations);

  $query = "INSERT INTO bownerdemographics (ApplicationID, name, sex, location, created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry, isAccepted) VALUES (:applicationID, :name, :sex, :location, NOW(), :totalnumAttendees, :totalmale, :totalfemale, :thisCity, :otherCity, :otherProvince, :foreignCountry, 'Pending')";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    ':applicationID' => $businessInfoID,
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

  // Redirect to a success page
  header('Location: success.php');
  exit;
} else {
  // Handle invalid request method
  header('Location: booking-info.php');
  exit;
}
