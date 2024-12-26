<?php
include '../../includes/db.php';

function fetchData($pdo, $startDate, $endDate)
{
  try {
    $query = "
            SELECT 
                DATE(t.created_at) as date,
                SUM(t.totalnumAttendees) as totalnumAttendees,
                SUM(t.totalmale) as totalmale,
                SUM(t.totalfemale) as totalfemale,
                SUM(t.thisCity) as thisCity,
                SUM(t.otherCity) as otherCity,
                SUM(t.otherProvince) as otherProvince,
                SUM(t.foreignCountry) as foreignCountry
            FROM (
                SELECT created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry 
                FROM demographics 
                UNION ALL
                SELECT created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry 
                FROM bownerdemographics
                UNION ALL
                SELECT created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry 
                FROM userdemographics 
                WHERE isAccepted = 'Accepted'
            ) t
            WHERE DATE(t.created_at) BETWEEN :startDate AND :endDate
            GROUP BY DATE(t.created_at)
            ORDER BY DATE(t.created_at)";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    return ['error' => $e->getMessage()];
  }
}

// Get date parameters with fallback values
$startDate = $_GET['startDate'] ?? date('Y-m-d', strtotime('-30 days'));
$endDate = $_GET['endDate'] ?? date('Y-m-d');

// Set JSON response headers
header('Content-Type: application/json');

// Fetch and return data
$data = fetchData($pdo, $startDate, $endDate);
echo json_encode($data);
