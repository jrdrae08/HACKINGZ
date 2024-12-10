<?php
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $roomID = isset($_GET['roomID']) ? (int)$_GET['roomID'] : null;

  if ($roomID === null) {
    $response = [
      'status' => 'error',
      'message' => 'roomID is required.'
    ];
    echo json_encode($response);
    exit();
  }

  try {
    $stmt = $pdo->prepare("
            SELECT checkin, departure
            FROM reservations
            WHERE roomID = :roomID AND status = 'Accepted'
        ");
    $stmt->execute(['roomID' => $roomID]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservedDates = [];
    foreach ($reservations as $reservation) {
      $checkin = new DateTime($reservation['checkin']);
      $departure = new DateTime($reservation['departure']);
      for ($date = clone $checkin; $date <= $departure; $date->modify('+1 day')) {
        $reservedDates[] = $date->format('Y-m-d');
      }
    }

    $response = [
      'status' => 'success',
      'reservedDates' => $reservedDates
    ];
    echo json_encode($response);
  } catch (Exception $e) {
    error_log($e->getMessage());
    $response = [
      'status' => 'error',
      'message' => 'An error occurred. Please try again later.'
    ];
    echo json_encode($response);
  }
}
