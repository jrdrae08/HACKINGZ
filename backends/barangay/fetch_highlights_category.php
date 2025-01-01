<?php
include "../includes/db.php";

try {
  // Fetch highlights that are active and connected to the barangayId
  $stmt = $pdo->prepare("
      SELECT HighlightID, HighlightName, BarangayID
      FROM highlights
      WHERE IsActive = 1
  ");
  $stmt->execute();
  $highlights = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Organize highlights by barangayId
  $organizedHighlights = [];
  foreach ($highlights as $highlight) {
    $barangayId = $highlight['BarangayID'];
    if (!isset($organizedHighlights[$barangayId])) {
      $organizedHighlights[$barangayId] = [];
    }
    $organizedHighlights[$barangayId][] = $highlight;
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
