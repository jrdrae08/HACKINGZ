<?php
//fetch_manage_rooms.php
include '../includes/db.php';

// Get the businessInfoID from the session
$businessInfoID = isset($_SESSION['business_info_id']) ? (int) $_SESSION['business_info_id'] : 1;

try {
  // Query to fetch room information based on businessInfoID
  $stmt = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, adultMax, ChildrenMax, RoomDescriptions, image1, timeStart, timeEnd  
        FROM roominfotable
        WHERE BusinessInfoID = :businessInfoID
    ");
  $stmt->execute(['businessInfoID' => $businessInfoID]);
  $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
