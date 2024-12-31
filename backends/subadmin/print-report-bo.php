<?php
session_start();
include '../../includes/db.php';

error_log("Session data: " . print_r($_SESSION, true));
error_log("GET data: " . print_r($_GET, true));

if (!isset($_SESSION['bowner_id'])) {
  error_log("Authorization failed: bowner_id not set");
  die(json_encode(['error' => 'Not authorized']));
}

function fetchAnalytics($pdo, $startDate, $endDate, $applicationID)
{
  try {
    if (!$startDate || !$endDate || !$applicationID) {
      error_log("Missing required parameters");
      throw new Exception('Missing required parameters');
    }

    error_log("Fetching analytics for applicationID: $applicationID, date range: $startDate to $endDate");

    $query = "
            SELECT 
                DATE(t.created_at) as date,
                COALESCE(SUM(t.totalnumAttendees), 0) as totalnumAttendees,
                COALESCE(SUM(t.totalmale), 0) as totalmale,
                COALESCE(SUM(t.totalfemale), 0) as totalfemale,
                GROUP_CONCAT(t.sex ORDER BY t.created_at SEPARATOR ', ') as sex,
                GROUP_CONCAT(t.location ORDER BY t.created_at SEPARATOR ', ') as location
            FROM (
                SELECT created_at, totalnumAttendees, totalmale, totalfemale, 
                       sex, location 
                FROM bownerdemographics 
                WHERE ApplicationID = :applicationID
                UNION ALL
                SELECT created_at, totalnumAttendees, totalmale, totalfemale, 
                       sex, location 
                FROM userdemographics ud
                INNER JOIN businessinformationform bi ON ud.BusinessInfoID = bi.BusinessInfoID
                WHERE bi.ApplicationID = :applicationID 
                AND ud.isAccepted = 'Accepted'
            ) t
            WHERE DATE(t.created_at) BETWEEN :startDate AND :endDate
            GROUP BY DATE(t.created_at)
            ORDER BY DATE(t.created_at)";

    $stmt = $pdo->prepare($query);
    $params = [
      'applicationID' => filter_var($applicationID, FILTER_SANITIZE_NUMBER_INT),
      'startDate' => filter_var($startDate, FILTER_SANITIZE_STRING),
      'endDate' => filter_var($endDate, FILTER_SANITIZE_STRING)
    ];

    error_log("Executing query with params: " . print_r($params, true));
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Query result count: " . count($result));

    $groupedData = [];

    foreach ($result as $row) {
      $sexes = explode(', ', $row['sex']);
      $locations = explode(', ', $row['location']);

      foreach ($sexes as $index => $sex) {
        $location = $locations[$index];

        if (!isset($groupedData[$row['date']])) {
          $groupedData[$row['date']] = [
            'date' => $row['date'], // Ensure date is included
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
    error_log("Database error: " . $e->getMessage());
    return ['error' => 'Database error occurred: ' . $e->getMessage()];
  } catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    return ['error' => $e->getMessage()];
  }
}

$startDate = filter_input(INPUT_GET, 'startDate') ?? date('Y-m-d', strtotime('-30 days'));
$endDate = filter_input(INPUT_GET, 'endDate') ?? date('Y-m-d');
$applicationID = $_SESSION['bowner_id'];

header('Content-Type: application/json');
$data = fetchAnalytics($pdo, $startDate, $endDate, $applicationID);
error_log("Final response: " . json_encode($data));
echo json_encode($data);
