<?php
include '../../includes/db.php';

if (isset($_POST['demogId'])) {
  $demogId = $_POST['demogId'];

  try {
    $stmt = $pdo->prepare("SELECT name, sex, location, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry FROM demographics WHERE demogId = :demogId");
    $stmt->execute([':demogId' => $demogId]);

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
      for ($i = 0; $i < count($names); $i++) {
        $table .= "<tr>";
        $table .= "<td>" . htmlspecialchars($names[$i]) . "</td>";
        $table .= "<td>" . htmlspecialchars($sexes[$i]) . "</td>";
        $table .= "<td>" . htmlspecialchars($locations[$i]) . "</td>";
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
