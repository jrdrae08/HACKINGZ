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
        COALESCE(SUM(CASE WHEN t.location = 'This City/Municipality' AND t.sex = 'Male' THEN 1 ELSE 0 END), 0) as thisCityMale,
        COALESCE(SUM(CASE WHEN t.location = 'This City/Municipality' AND t.sex = 'Female' THEN 1 ELSE 0 END), 0) as thisCityFemale,
        COALESCE(SUM(CASE WHEN t.location = 'Other City/Municipality' AND t.sex = 'Male' THEN 1 ELSE 0 END), 0) as otherCityMale,
        COALESCE(SUM(CASE WHEN t.location = 'Other City/Municipality' AND t.sex = 'Female' THEN 1 ELSE 0 END), 0) as otherCityFemale,
        COALESCE(SUM(CASE WHEN t.location = 'Other Province' AND t.sex = 'Male' THEN 1 ELSE 0 END), 0) as otherProvinceMale,
        COALESCE(SUM(CASE WHEN t.location = 'Other Province' AND t.sex = 'Female' THEN 1 ELSE 0 END), 0) as otherProvinceFemale,
        COALESCE(SUM(CASE WHEN t.location = 'Foreign Country' AND t.sex = 'Male' THEN 1 ELSE 0 END), 0) as foreignCountryMale,
        COALESCE(SUM(CASE WHEN t.location = 'Foreign Country' AND t.sex = 'Female' THEN 1 ELSE 0 END), 0) as foreignCountryFemale,
        COALESCE(SUM(CASE WHEN t.location = 'This City/Municipality' THEN 1 ELSE 0 END), 0) as thisCity,
        COALESCE(SUM(CASE WHEN t.location = 'Other City/Municipality' THEN 1 ELSE 0 END), 0) as otherCity,
        COALESCE(SUM(CASE WHEN t.location = 'Other Province' THEN 1 ELSE 0 END), 0) as otherProvince,
        COALESCE(SUM(CASE WHEN t.location = 'Foreign Country' THEN 1 ELSE 0 END), 0) as foreignCountry,
        COALESCE(SUM(t.totalnumAttendees), 0) as totalnumAttendees,
        COALESCE(SUM(t.totalmale), 0) as totalmale,
        COALESCE(SUM(t.totalfemale), 0) as totalfemale
      FROM (
        SELECT created_at, totalnumAttendees, totalmale, totalfemale, sex, location 
        FROM bownerdemographics 
        WHERE ApplicationID = :applicationID
        UNION ALL
        SELECT created_at, totalnumAttendees, totalmale, totalfemale, sex, location 
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

    return $result;
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