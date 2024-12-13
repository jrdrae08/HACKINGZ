<?php
// delete_attendee.php
include '../../includes/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['business_info_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'BusinessInfoID not set in session.']);
  exit;
}

$businessInfoID = $_SESSION['business_info_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['revID']) || !isset($data['attendeeIndex'])) {
  echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
  exit;
}

$revID = $data['revID'];
$attendeeIndex = $data['attendeeIndex'];

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

  // Fetch existing attendee data
  $stmt = $pdo->prepare("SELECT name, sex, location FROM userdemographics WHERE userID = :userID AND roomID = :roomID AND BusinessInfoID = :businessInfoID");
  $stmt->execute(['userID' => $userID, 'roomID' => $roomID, 'businessInfoID' => $businessInfoID]);
  $userdemographics = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$userdemographics) {
    echo json_encode(['status' => 'error', 'message' => 'User demographics not found.']);
    exit;
  }

  // Split the data into arrays
  $names = explode(', ', $userdemographics['name']);
  $sexes = explode(', ', $userdemographics['sex']);
  $locations = explode(', ', $userdemographics['location']);

  // Remove the attendee at the specified index
  array_splice($names, $attendeeIndex - 1, 1);
  array_splice($sexes, $attendeeIndex - 1, 1);
  array_splice($locations, $attendeeIndex - 1, 1);

  // Update the userdemographics table
  $stmt = $pdo->prepare("
        UPDATE userdemographics
        SET name = :name, sex = :sex, location = :location, totalnumAttendees = :totalnumAttendees, totalmale = :totalmale, totalfemale = :totalfemale, thisCity = :thisCity, otherCity = :otherCity, otherProvince = :otherProvince, foreignCountry = :foreignCountry
        WHERE userID = :userID AND roomID = :roomID AND BusinessInfoID = :businessInfoID
    ");

  $stmt->execute([
    'userID' => $userID,
    'roomID' => $roomID,
    'businessInfoID' => $businessInfoID,
    'name' => implode(', ', $names),
    'sex' => implode(', ', $sexes),
    'location' => implode(', ', $locations),
    'totalnumAttendees' => count($names),
    'totalmale' => count(array_filter($sexes, fn($sex) => $sex === 'Male')),
    'totalfemale' => count(array_filter($sexes, fn($sex) => $sex === 'Female')),
    'thisCity' => count(array_filter($locations, fn($location) => $location === 'This City/Municipality')),
    'otherCity' => count(array_filter($locations, fn($location) => $location === 'Other City/Municipality')),
    'otherProvince' => count(array_filter($locations, fn($location) => $location === 'Other Province')),
    'foreignCountry' => count(array_filter($locations, fn($location) => $location === 'Foreign Country'))
  ]);

  $pdo->commit();
  echo json_encode(['status' => 'success']);
} catch (Exception $e) {
  $pdo->rollBack();
  error_log($e->getMessage());
  echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the attendee.']);
}
