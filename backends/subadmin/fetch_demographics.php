<?php
// fetch_demographics.php
include '../../includes/db.php';

if (isset($_POST['bOwnerId'])) {
  $bOwnerId = $_POST['bOwnerId'];

  try {
    $stmt = $pdo->prepare("SELECT name, sex, location, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry FROM bOwnerdemographics WHERE bOwnerId = :bOwnerId ORDER BY created_at DESC");
    $stmt->execute([':bOwnerId' => $bOwnerId]);

    $demog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($demog) {
      $names = explode(', ', $demog['name']);
      $sexes = explode(', ', $demog['sex']);
      $locations = explode(', ', $demog['location']);

      $totalAttendees = $demog['totalnumAttendees'];
      $totalMale = $demog['totalmale'];
      $totalFemale = $demog['totalfemale'];
      $thisCity = $demog['thisCity'];
      $otherCity = $demog['otherCity'];
      $otherProvince = $demog['otherProvince'];
      $foreignCountry = $demog['foreignCountry'];

      // Prepare demographics details
      $details = "
        <li>Total Number of Attendees: $totalAttendees</li>
        <li>Total Male: $totalMale</li>
        <li>Total Female: $totalFemale</li>
        <li class='mt-4'>Locations</li>
        <li>This City/Municipality: $thisCity</li>
        <li>Other City/Municipality: $otherCity</li>
        <li>Other Province: $otherProvince</li>
        <li>Foreign Country: $foreignCountry</li>";

      // Prepare table rows
      $table = "";
      $maxCount = max(count($names), count($sexes), count($locations));
      for ($i = 0; $i < $maxCount; $i++) {
        $name = isset($names[$i]) ? htmlspecialchars($names[$i]) : '';
        $sex = isset($sexes[$i]) ? htmlspecialchars($sexes[$i]) : '';
        $location = isset($locations[$i]) ? htmlspecialchars($locations[$i]) : '';
        $table .= "<tr>";
        $table .= "<td>$name</td>";
        $table .= "<td>$sex</td>";
        $table .= "<td>$location</td>";
        $table .= "</tr>";
      }

      $response = [
        'details' => $details,
        'table' => $table,
      ];

      echo json_encode($response);
    } else {
      echo json_encode(['details' => '<li>No data found.</li>', 'table' => '']);
    }
  } catch (PDOException $e) {
    echo json_encode(['details' => '<li>An error occurred. Please try again later.</li>', 'table' => '']);
  }
}
