<?php
include '../includes/db.php'; // Correct the path to the db.php file

// Start the session
session_start();

// Get the businessInfoID from the session
$businessInfoID = isset($_SESSION['business_info_id']) ? (int) $_SESSION['business_info_id'] : 1;

function fetchRoomDetails($pdo, $roomID, $businessInfoID)
{
    $details = [];

    try {
        // Query to fetch active features based on roomID and BusinessInfoID
        $stmtFeatures = $pdo->prepare("
            SELECT rf.FeatureID, rf.FeatureName, rfm.IsActive
            FROM room_features rf
            JOIN room_features_mapping rfm ON rf.FeatureID = rfm.FeatureID
            WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID
        ");
        $stmtFeatures->execute(['roomID' => $roomID, 'businessInfoID' => $businessInfoID]);
        $details['features'] = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

        // Query to fetch active facilities based on roomID and BusinessInfoID
        $stmtFacilities = $pdo->prepare("
            SELECT rf.FacilityID, rf.FacilityName, rfm.IsActive
            FROM room_facilities rf
            JOIN room_facilities_mapping rfm ON rf.FacilityID = rfm.FacilityID
            WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID
        ");
        $stmtFacilities->execute(['roomID' => $roomID, 'businessInfoID' => $businessInfoID]);
        $details['facilities'] = $stmtFacilities->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    return $details;
}

function fetchRooms($pdo, $businessInfoID)
{
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
            $details = fetchRoomDetails($pdo, $room['roomID'], $businessInfoID);
            $room['features'] = $details['features'];
            $room['facilities'] = $details['facilities'];
        }

        return $rooms;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

// Fetch rooms with features and facilities
$rooms = fetchRooms($pdo, $businessInfoID);

// Store the facilities and features in the session
$_SESSION['rooms'] = $rooms;
?>