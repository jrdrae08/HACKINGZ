<?php
session_start();
require '../../vendor/autoload.php';
include '../../includes/db.php';

// Debugging: Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
  // Check authentication
  if (!isset($_SESSION['bowner_id'])) {
    throw new Exception('Unauthorized access');
  }

  // Get parameters
  $applicationID = $_SESSION['bowner_id'];
  $startDate = $_GET['startDate'] ?? null;
  $endDate = $_GET['endDate'] ?? null;

  if (!$startDate || !$endDate || !$applicationID) {
    throw new Exception('Missing required parameters');
  }

  // Debugging: Log parameters
  error_log("Parameters - ApplicationID: $applicationID, StartDate: $startDate, EndDate: $endDate");

  // Create PDF with Legal size
  $pdf = new TCPDF('L', 'mm', 'LEGAL', true, 'UTF-8', false);
  $pdf->SetMargins(10, 10, 10);
  $pdf->SetCreator('Tourism System');
  $pdf->SetTitle('Demographics Report');
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);
  $pdf->AddPage('L', 'LEGAL');

  // Add title and date range
  $pdf->SetFont('helvetica', 'B', 16);
  $pdf->Cell(0, 10, 'Tourism Visitor Record', 0, 1, 'C');
  $pdf->SetFont('helvetica', '', 12);
  $pdf->Cell(0, 10, "Period: " . date('F d, Y', strtotime($startDate)) . " - " . date('F d, Y', strtotime($endDate)), 0, 1, 'C');

  // Query data
  $query = "
    SELECT 
      DATE(t.created_at) as date,
      COALESCE(SUM(t.totalnumAttendees), 0) as totalnumAttendees,
      COALESCE(SUM(t.totalmale), 0) as totalmale,
      COALESCE(SUM(t.totalfemale), 0) as totalfemale,
      GROUP_CONCAT(t.sex ORDER BY t.created_at SEPARATOR ', ') as sex,
      GROUP_CONCAT(t.location ORDER BY t.created_at SEPARATOR ', ') as location
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
  $stmt->execute([
    'applicationID' => $applicationID,
    'startDate' => $startDate,
    'endDate' => $endDate
  ]);

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

  // Generate table HTML
  $html = '
<table border="1" cellpadding="5">
   <thead>
    <tr>
        <th rowspan="3" style="text-align:center;">Day</th>
        <th rowspan="3" style="text-align:center;">Week Day<br>(Mon-Sun)</th>
        <th colspan="9" style="text-align:center;">Philippines</th>
        <th colspan="3" style="text-align:center;">Foreign Country Residence</th>
        <th rowspan="3" style="text-align:center;">Grand Total<br>Number of Visitors</th>
    </tr>
    <tr>
        <th colspan="3" style="text-align:center;">This City/Municipality</th>
        <th colspan="3" style="text-align:center;">Other City/Municipality</th>
        <th colspan="3" style="text-align:center;">Other Province</th>
        <th colspan="3" style="text-align:center;">Foreign Country</th>
    </tr>
    <tr>
        <th style="text-align:center;">Male</th>
        <th style="text-align:center;">Female</th>
        <th style="text-align:center;">Total</th>
        <th style="text-align:center;">Male</th>
        <th style="text-align:center;">Female</th>
        <th style="text-align:center;">Total</th>
        <th style="text-align:center;">Male</th>
        <th style="text-align:center;">Female</th>
        <th style="text-align:center;">Total</th>
        <th style="text-align:center;">Male</th>
        <th style="text-align:center;">Female</th>
        <th style="text-align:center;">Total</th>
    </tr>
</thead>
    <tbody>';
  foreach ($groupedData as $date => $data) {
    $dateObj = new DateTime($date);
    $html .= sprintf(
      '<tr>
              <td style="text-align:center;">%s</td>
              <td style="text-align:center;">%s</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
              <td style="text-align:center;">%d</td>
          </tr>',
      $dateObj->format('j'),
      $dateObj->format('D'),
      $data['thisCityMale'] ?? 0,
      $data['thisCityFemale'] ?? 0,
      $data['thisCity'] ?? 0,
      $data['otherCityMale'] ?? 0,
      $data['otherCityFemale'] ?? 0,
      $data['otherCity'] ?? 0,
      $data['otherProvinceMale'] ?? 0,
      $data['otherProvinceFemale'] ?? 0,
      $data['otherProvince'] ?? 0,
      $data['foreignCountryMale'] ?? 0,
      $data['foreignCountryFemale'] ?? 0,
      $data['foreignCountry'] ?? 0,
      $data['totalnumAttendees'] ?? 0
    );
  }

  $html .= '</tbody></table>';

  // Output table
  $pdf->writeHTML($html, true, false, true, false, '');

  // Ensure no output before PDF
  while (ob_get_level()) {
    ob_end_clean();
  }

  // Output PDF
  $pdf->Output('demographics_report.pdf', 'I');
  exit();
} catch (Exception $e) {
  error_log("PDF Generation Error: " . $e->getMessage());
  error_log("Stack trace: " . $e->getTraceAsString());
  header("Content-Type: text/plain");
  die("Error generating PDF report: " . $e->getMessage());
}
