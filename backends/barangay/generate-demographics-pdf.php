<?php
session_start();
require '../../vendor/autoload.php';
include '../../includes/db.php';

try {
  // Check authentication
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
    throw new Exception('Unauthorized access');
  }

  // Get parameters
  $barangayId = $_SESSION['user_id'];
  $startDate = $_GET['startDate'] ?? null;
  $endDate = $_GET['endDate'] ?? null;

  if (!$startDate || !$endDate || !$barangayId) {
    throw new Exception('Missing required parameters');
  }

  // Fetch barangay name
  $barangayQuery = "SELECT establishment FROM barangay_accounts WHERE barangayId = :barangayId LIMIT 1";
  $barangayStmt = $pdo->prepare($barangayQuery);
  $barangayStmt->execute(['barangayId' => $barangayId]);
  $barangay = $barangayStmt->fetch(PDO::FETCH_ASSOC);

  if (!$barangay) {
    throw new Exception('Barangay not found');
  }

  $barangayName = $barangay['establishment'];

  // Create PDF with Legal size in portrait mode
  $pdf = new TCPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false);
  $pdf->SetMargins(5, 20, 5); // Adjust margins to add more space on the left and right
  $pdf->SetAutoPageBreak(false); // Disable automatic page breaks
  $pdf->SetCreator('Barangay System');
  $pdf->SetTitle('Demographics Report');
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);
  $pdf->AddPage('P', 'LEGAL');

  // Add title and date range
  $pdf->SetFont('helvetica', 'B', 12); // Adjust font size
  $pdf->Cell(0, 10, 'Tourism Attraction Visitor Record', 0, 1, 'L');
  $pdf->SetFont('helvetica', '', 5); // Adjust font size
  $pdf->Cell(0, 10, '(This recording form can be used instead of just counting the visitors)', 0, 1, 'L');
  $pdf->SetFont('helvetica', '', 7); // Adjust font size
  $pdf->Cell(20, 10, '', 0, 0); // Add an empty cell for spacing (20 units)
  $pdf->Cell(0, 0, "Month/Year: " . date('F d, Y', strtotime($startDate)) . " - " . date('F d, Y', strtotime($endDate)), 0, 1, 'L');

  $pdf->SetFont('helvetica', '', 7); // Adjust font size
  $pdf->Cell(20, 10, '', 0, 0); // Add an empty cell for spacing (20 units)
  $pdf->Cell(0, 0, 'Name of Barangay: ' . $barangayName, 0, 1, 'L'); // No margin top
  $pdf->Ln(5); // Add empty space (5 units) below

  // Query data
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
  $stmt->execute([
    'barangayId' => $barangayId,
    'startDate' => $startDate,
    'endDate' => $endDate
  ]);

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $groupedData = [];
  $totals = [
    'thisCityMale' => 0,
    'thisCityFemale' => 0,
    'thisCity' => 0,
    'otherCityMale' => 0,
    'otherCityFemale' => 0,
    'otherCity' => 0,
    'otherProvinceMale' => 0,
    'otherProvinceFemale' => 0,
    'otherProvince' => 0,
    'foreignCountryMale' => 0,
    'foreignCountryFemale' => 0,
    'foreignCountry' => 0,
    'totalnumAttendees' => 0
  ];

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

    // Update totals
    $totals['thisCityMale'] += $groupedData[$row['date']]['thisCityMale'];
    $totals['thisCityFemale'] += $groupedData[$row['date']]['thisCityFemale'];
    $totals['thisCity'] += $groupedData[$row['date']]['thisCity'];
    $totals['otherCityMale'] += $groupedData[$row['date']]['otherCityMale'];
    $totals['otherCityFemale'] += $groupedData[$row['date']]['otherCityFemale'];
    $totals['otherCity'] += $groupedData[$row['date']]['otherCity'];
    $totals['otherProvinceMale'] += $groupedData[$row['date']]['otherProvinceMale'];
    $totals['otherProvinceFemale'] += $groupedData[$row['date']]['otherProvinceFemale'];
    $totals['otherProvince'] += $groupedData[$row['date']]['otherProvince'];
    $totals['foreignCountryMale'] += $groupedData[$row['date']]['foreignCountryMale'];
    $totals['foreignCountryFemale'] += $groupedData[$row['date']]['foreignCountryFemale'];
    $totals['foreignCountry'] += $groupedData[$row['date']]['foreignCountry'];
    $totals['totalnumAttendees'] += $groupedData[$row['date']]['totalnumAttendees'];
  }

  // Generate table HTML
  $html = '
<table border="1" cellpadding="4"> <!-- Adjust cellpadding to fit content -->
   <thead>
    <tr>
      <th rowspan="3" style="text-align:center; font-size: 8px;">Day</th> <!-- Adjust font size -->
      <th rowspan="3" style="text-align:center; font-size: 8px;">Week Day<br>(Mon-Sun)</th>
      <th colspan="9" style="text-align:center; font-size: 8px;">Philippines</th>
      <th colspan="3" style="text-align:center; font-size: 8px;">Foreign Country Residence</th>
      <th rowspan="3" style="text-align:center; font-size: 8px;">Grand Total<br>Number of Visitors</th>
    </tr>
    <tr>
      <th colspan="3" style="text-align:center; font-size: 8px;">This City/Municipality</th>
      <th colspan="3" style="text-align:center; font-size: 8px;">Other City/Municipality</th>
      <th colspan="3" style="text-align:center; font-size: 8px;">Other Province</th>
      <th colspan="3" style="text-align:center; font-size: 8px;">Foreign Country</th>
    </tr>
    <tr>
      <th style="text-align:center; font-size: 8px;">Male</th>
      <th style="text-align:center; font-size: 8px;">Female</th>
      <th style="text-align:center; font-size: 8px;">Total</th>
      <th style="text-align:center; font-size: 8px;">Male</th>
      <th style="text-align:center; font-size: 8px;">Female</th>
      <th style="text-align:center; font-size: 8px;">Total</th>
      <th style="text-align:center; font-size: 8px;">Male</th>
      <th style="text-align:center; font-size: 8px;">Female</th>
      <th style="text-align:center; font-size: 8px;">Total</th>
      <th style="text-align:center; font-size: 8px;">Male</th>
      <th style="text-align:center; font-size: 8px;">Female</th>
      <th style="text-align:center; font-size: 8px;">Total</th>
    </tr>
</thead>
    <tbody>';

  // Generate rows for each day of the month
  $start = new DateTime($startDate);
  $end = new DateTime($endDate);
  for ($date = clone $start; $date <= $end; $date->modify('+1 day')) {
    $formattedDate = $date->format('Y-m-d');
    $data = $groupedData[$formattedDate] ?? [
      'thisCityMale' => 0,
      'thisCityFemale' => 0,
      'otherCityMale' => 0,
      'otherCityFemale' => 0,
      'otherProvinceMale' => 0,
      'otherProvinceFemale' => 0,
      'foreignCountryMale' => 0,
      'foreignCountryFemale' => 0,
      'totalnumAttendees' => 0,
      'thisCity' => 0,
      'otherCity' => 0,
      'otherProvince' => 0,
      'foreignCountry' => 0
    ];

    $html .= sprintf(
      '<tr>
              <td style="text-align:center; font-size: 9px;">%s</td>
              <td style="text-align:center; font-size: 9px;">%s</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
              <td style="text-align:center; font-size: 9px;">%d</td>
          </tr>',
      $date->format('j'),
      $date->format('D'),
      $data['thisCityMale'],
      $data['thisCityFemale'],
      $data['thisCity'],
      $data['otherCityMale'],
      $data['otherCityFemale'],
      $data['otherCity'],
      $data['otherProvinceMale'],
      $data['otherProvinceFemale'],
      $data['otherProvince'],
      $data['foreignCountryMale'],
      $data['foreignCountryFemale'],
      $data['foreignCountry'],
      $data['totalnumAttendees']
    );
  }

  // Append totals row
  $html .= sprintf(
    '<tr>
            <td style="text-align:center; font-size: 9px;" colspan="2">Total of this month</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
            <td style="text-align:center; font-size: 9px;">%d</td>
        </tr>',
    $totals['thisCityMale'],
    $totals['thisCityFemale'],
    $totals['thisCity'],
    $totals['otherCityMale'],
    $totals['otherCityFemale'],
    $totals['otherCity'],
    $totals['otherProvinceMale'],
    $totals['otherProvinceFemale'],
    $totals['otherProvince'],
    $totals['foreignCountryMale'],
    $totals['foreignCountryFemale'],
    $totals['foreignCountry'],
    $totals['totalnumAttendees']
  );

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
