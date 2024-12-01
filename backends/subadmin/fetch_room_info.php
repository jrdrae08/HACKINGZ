<?php
include '../../includes/db.php';

function fetchRoomInfo($roomID, $pdo)
{
  $stmt = $pdo->prepare("
        SELECT r.*, p.amount AS paymentAmount
        FROM roominfotable r
        LEFT JOIN payment_methods p ON r.roomID = p.roomID
        WHERE r.roomID = ?
    ");
  $stmt->execute([$roomID]);
  $room = $stmt->fetch(PDO::FETCH_ASSOC);

  // Fetch facilities
  $facilitiesStmt = $pdo->prepare("
        SELECT f.FacilityID, f.FacilityName, m.IsActive
        FROM room_facilities f
        LEFT JOIN room_facilities_mapping m ON f.FacilityID = m.FacilityID AND m.roomID = ?
        WHERE f.BusinessInfoID = ?
    ");
  $facilitiesStmt->execute([$roomID, $room['BusinessInfoID']]);
  $facilities = $facilitiesStmt->fetchAll(PDO::FETCH_ASSOC);

  $room['facilities'] = $facilities;

  // Fetch features
  $featuresStmt = $pdo->prepare("
        SELECT f.FeatureID, f.FeatureName, m.IsActive
        FROM room_features f
        LEFT JOIN room_features_mapping m ON f.FeatureID = m.FeatureID AND m.roomID = ?
        WHERE f.BusinessInfoID = ?
    ");
  $featuresStmt->execute([$roomID, $room['BusinessInfoID']]);
  $features = $featuresStmt->fetchAll(PDO::FETCH_ASSOC);

  $room['features'] = $features;

  return $room;
}

if (isset($_GET['roomID'])) {
  $roomID = $_GET['roomID'];
  $room = fetchRoomInfo($roomID, $pdo);
  echo json_encode($room);
}
