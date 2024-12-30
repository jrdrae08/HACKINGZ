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

  foreach ($rooms as &$room) {
    // Query to fetch active features based on roomID and BusinessInfoID
    $stmtFeatures = $pdo->prepare("
        SELECT rf.FeatureName
        FROM room_features rf
        JOIN room_features_mapping rfm ON rf.FeatureID = rfm.FeatureID
        WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID AND rfm.IsActive = 1
    ");
    $stmtFeatures->execute(['roomID' => $room['roomID'], 'businessInfoID' => $businessInfoID]);
    $room['features'] = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch active facilities based on roomID and BusinessInfoID
    $stmtFacilities = $pdo->prepare("
        SELECT rf.FacilityName
        FROM room_facilities rf
        JOIN room_facilities_mapping rfm ON rf.FacilityID = rfm.FacilityID
        WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID AND rfm.IsActive = 1
    ");
    $stmtFacilities->execute(['roomID' => $room['roomID'], 'businessInfoID' => $businessInfoID]);
    $room['facilities'] = $stmtFacilities->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
