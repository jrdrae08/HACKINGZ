<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  die(json_encode(['error' => 'Not authorized']));
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
                GROUP_CONCAT(sex ORDER BY created_at SEPARATOR ', ') as sex,
                GROUP_CONCAT(location ORDER BY created_at SEPARATOR ', ') as location
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

    $groupedData = [];

    foreach ($result as $row) {
      $sexes = explode(', ', $row['sex']);
      $locations = explode(', ', $row['location']);

      foreach ($sexes as $index => $sex) {
        $location = $locations[$index];

        if (!isset($groupedData[$row['date']])) {
          $groupedData[$row['date']] = [
            'date' => $row['date'],
            'thisCityMale' => 0,
            'thisCityFemale' => 0,
            'otherCityMale' => 0,
            'otherCityFemale' => 0,
            'otherProvinceMale' => 0,
            'otherProvinceFemale' => 0,
            'foreignCountryMale' => 0,
            'foreignCountryFemale' => 0,
            'totalnumAttendees' => $row['totalnumAttendees'],
            'totalmale' => $row['totalmale'],
            'totalfemale' => $row['totalfemale'],
            'thisCity' => 0,
            'otherCity' => 0,
            'otherProvince' => 0,
            'foreignCountry' => 0
          ];
        }

        switch ($location) {
          case 'This City/Municipality':
            if ($sex === 'Male') {
              $groupedData[$row['date']]['thisCityMale']++;
            } else {
              $groupedData[$row['date']]['thisCityFemale']++;
            }
            $groupedData[$row['date']]['thisCity']++;
            break;
          case 'Other City/Municipality':
            if ($sex === 'Male') {
              $groupedData[$row['date']]['otherCityMale']++;
            } else {
              $groupedData[$row['date']]['otherCityFemale']++;
            }
            $groupedData[$row['date']]['otherCity']++;
            break;
          case 'Other Province':
            if ($sex === 'Male') {
              $groupedData[$row['date']]['otherProvinceMale']++;
            } else {
              $groupedData[$row['date']]['otherProvinceFemale']++;
            }
            $groupedData[$row['date']]['otherProvince']++;
            break;
          case 'Foreign Country':
            if ($sex === 'Male') {
              $groupedData[$row['date']]['foreignCountryMale']++;
            } else {
              $groupedData[$row['date']]['foreignCountryFemale']++;
            }
            $groupedData[$row['date']]['foreignCountry']++;
            break;
        }
      }
    }

    return array_values($groupedData);
  } catch (PDOException $e) {
    return ['error' => 'Database error occurred: ' . $e->getMessage()];
  } catch (Exception $e) {
    return ['error' => $e->getMessage()];
  }
}

$startDate = filter_input(INPUT_GET, 'startDate') ?? date('Y-m-d', strtotime('-30 days'));
$endDate = filter_input(INPUT_GET, 'endDate') ?? date('Y-m-d');
$data = fetchAnalytics($pdo, $startDate, $endDate, $barangayId);

header('Content-Type: application/json');
echo json_encode($data);
