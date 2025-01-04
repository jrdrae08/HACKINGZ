<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  die(json_encode(['error' => 'Not authorized'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

$barangayId = $_SESSION['user_id'];

function fetchAnalytics($pdo, $startDate, $endDate, $barangayId)
{
  try {
    if (!$startDate || !$endDate || !$barangayId) {
      throw new Exception('Missing required parameters');
    }

    $query = "
            SELECT 
                DATE(created_at) as date,
                COALESCE(SUM(totalnumAttendees), 0) as totalnumAttendees,
                COALESCE(SUM(totalmale), 0) as totalmale,
                COALESCE(SUM(totalfemale), 0) as totalfemale,
                COALESCE(SUM(thisCity), 0) as thisCity,
                COALESCE(SUM(otherCity), 0) as otherCity,
                COALESCE(SUM(otherProvince), 0) as otherProvince,
                COALESCE(SUM(foreignCountry), 0) as foreignCountry
            FROM demographics
            WHERE barangayId = :barangayId AND DATE(created_at) BETWEEN :startDate AND :endDate
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at)";

    $stmt = $pdo->prepare($query);
    $params = [
      'barangayId' => filter_var($barangayId, FILTER_SANITIZE_NUMBER_INT),
      'startDate' => filter_var($startDate, FILTER_SANITIZE_STRING),
      'endDate' => filter_var($endDate, FILTER_SANITIZE_STRING)
    ];

    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the total number of attendees overall
    $totalAttendees = 0;
    $totals = [
      'thisCity' => 0,
      'otherCity' => 0,
      'otherProvince' => 0,
      'foreignCountry' => 0,
      'totalmale' => 0,
      'totalfemale' => 0
    ];
    foreach ($result as $row) {
      $totalAttendees += $row['totalnumAttendees'];
      $totals['thisCity'] += $row['thisCity'];
      $totals['otherCity'] += $row['otherCity'];
      $totals['otherProvince'] += $row['otherProvince'];
      $totals['foreignCountry'] += $row['foreignCountry'];
      $totals['totalmale'] += $row['totalmale'];
      $totals['totalfemale'] += $row['totalfemale'];
    }

    // Log the total number of attendees
    error_log("Total number of attendees overall: " . $totalAttendees);

    return [
      'data' => $result,
      'totals' => $totals
    ];
  } catch (PDOException $e) {
    return ['error' => 'Database error occurred'];
  } catch (Exception $e) {
    return ['error' => $e->getMessage()];
  }
}

$startDate = filter_input(INPUT_GET, 'startDate') ?? date('Y-m-d', strtotime('-30 days'));
$endDate = filter_input(INPUT_GET, 'endDate') ?? date('Y-m-d');
$data = fetchAnalytics($pdo, $startDate, $endDate, $barangayId);

header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
