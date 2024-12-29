<?php
session_start();
require '../../vendor/autoload.php';
include '../../includes/db.php';

// Debugging: Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
  // Check authentication
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
    throw new Exception('Unauthorized access');
  }

  // Get parameters
  $applicationID = $_SESSION['bowner_id'] ?? null;
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
  $query = "SELECT 
        DATE(t.created_at) as date,
        COALESCE(SUM(t.totalnumAttendees), 0) as totalnumAttendees,
        COALESCE(SUM(t.totalmale), 0) as totalmale,
        COALESCE(SUM(t.totalfemale), 0) as totalfemale,
        COALESCE(SUM(t.thisCity), 0) as thisCity,
        COALESCE(SUM(t.otherCity), 0) as otherCity,
        COALESCE(SUM(t.otherProvince), 0) as otherProvince,
        COALESCE(SUM(t.foreignCountry), 0) as foreignCountry
    FROM (
        SELECT created_at, totalnumAttendees, totalmale, totalfemale, 
               thisCity, otherCity, otherProvince, foreignCountry 
        FROM bownerdemographics 
        WHERE ApplicationID = :applicationID
        UNION ALL
        SELECT created_at, totalnumAttendees, totalmale, totalfemale, 
               thisCity, otherCity, otherProvince, foreignCountry 
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
  while ($row = $stmt->fetch()) {
    $date = new DateTime($row['date']);
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
      $date->format('j'),
      $date->format('D'),
      $row['totalmale'] ?? 0,
      $row['totalfemale'] ?? 0,
      $row['thisCity'] ?? 0,
      $row['totalmale'] ?? 0,
      $row['totalfemale'] ?? 0,
      $row['otherCity'] ?? 0,
      $row['totalmale'] ?? 0,
      $row['totalfemale'] ?? 0,
      $row['otherProvince'] ?? 0,
      $row['totalmale'] ?? 0,
      $row['totalfemale'] ?? 0,
      $row['foreignCountry'] ?? 0,
      $row['totalnumAttendees'] ?? 0
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
