<?php
// update_userdemogreserve.php
include '../../includes/db.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['business_info_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'BusinessInfoID not set in session.']);
  exit;
}

$businessInfoID = $_SESSION['business_info_id'];
$data = json_decode(file_get_contents('php://input'), true);

file_put_contents('php://stderr', print_r($data, true));

if (!isset($data['revID']) || !isset($data['attendeeData'])) {
  echo json_encode(['status' => 'error', 'message' => 'Invalid attendee data.']);
  exit;
}

$revID = $data['revID'];
$attendeeData = $data['attendeeData'];

if (!isset($attendeeData['name']) || !isset($attendeeData['sex']) || !isset($attendeeData['location'])) {
  echo json_encode(['status' => 'error', 'message' => 'Invalid attendee data.']);
  exit;
}

try {
  $pdo->beginTransaction();

  // Get userID and roomID from reservations table
  $stmt = $pdo->prepare("SELECT userID, roomID FROM reservations WHERE revID = :revID");
  $stmt->execute(['revID' => $revID]);
  $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$reservation) {
    echo json_encode(['status' => 'error', 'message' => 'Reservation not found.']);
    exit;
  }

  $userID = $reservation['userID'];
  $roomID = $reservation['roomID'];

  // Update existing attendee data
  $stmt = $pdo->prepare("
        UPDATE userdemographics
        SET name = :name, sex = :sex, location = :location, totalnumAttendees = :totalnumAttendees, totalmale = :totalmale, totalfemale = :totalfemale, thisCity = :thisCity, otherCity = :otherCity, otherProvince = :otherProvince, foreignCountry = :foreignCountry, isAccepted = 'Accepted'
        WHERE userID = :userID AND roomID = :roomID AND BusinessInfoID = :businessInfoID
    ");

  $stmt->execute([
    'userID' => $userID,
    'roomID' => $roomID,
    'businessInfoID' => $businessInfoID,
    'name' => implode(', ', $attendeeData['name']),
    'sex' => implode(', ', $attendeeData['sex']),
    'location' => implode(', ', $attendeeData['location']),
    'totalnumAttendees' => count($attendeeData['name']),
    'totalmale' => count(array_filter($attendeeData['sex'], fn($sex) => $sex === 'Male')),
    'totalfemale' => count(array_filter($attendeeData['sex'], fn($sex) => $sex === 'Female')),
    'thisCity' => count(array_filter($attendeeData['location'], fn($location) => $location === 'This City/Municipality')),
    'otherCity' => count(array_filter($attendeeData['location'], fn($location) => $location === 'Other City/Municipality')),
    'otherProvince' => count(array_filter($attendeeData['location'], fn($location) => $location === 'Other Province')),
    'foreignCountry' => count(array_filter($attendeeData['location'], fn($location) => $location === 'Foreign Country'))
  ]);

  // Update the reservations table
  $stmt = $pdo->prepare("UPDATE reservations SET status = 'Ongoing' WHERE revID = :revID");
  $stmt->execute(['revID' => $revID]);

  $pdo->commit();
  echo json_encode(['status' => 'success']);
} catch (Exception $e) {
  $pdo->rollBack();
  error_log($e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating attendee information.']);
}
