<?php
//fetch_resortdestination_category.php
include '../includes/db.php';

// Get the businessInfoID from the URL, defaulting to 1 if not set
$businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;

try {
  // Fetch businesses with BusinessType 'Resort', 'Farm', and 'Falls' where isActive is 1
  // and fetch establishment names and highlights for falls
  $stmt = $pdo->prepare("
      SELECT bm.Thumbnail, bm.Quotation, bif.BusinessName, bif.BusinessInfoID, bt.TypeName, ba.barangayId, ba.establishment, bm.Image1, bm.Image2, bm.Image3, bm.Image4, bm.Image5, bm.Image6
      FROM business_media bm
      JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
      JOIN businesstype bt ON bif.BusinessTypeID = bt.BusinessTypeID
      LEFT JOIN barangay_accounts ba ON bm.barangayId = ba.barangayId
      WHERE bm.isActive = 1
      UNION
      SELECT bm.Thumbnail, bm.Quotation, NULL AS BusinessName, NULL AS BusinessInfoID, 'Falls' AS TypeName, ba.barangayId, ba.establishment, bm.Image1, bm.Image2, bm.Image3, bm.Image4, bm.Image5, bm.Image6
      FROM barangay_accounts ba
      LEFT JOIN business_media bm ON ba.barangayId = bm.barangayId AND bm.isActive = 1
      WHERE ba.BusinessTypeID = 21
  ");
  $stmt->execute();
  $businesses = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Separate businesses by type
  $allBusinesses = [];
  $resortBusinesses = [];
  $farmBusinesses = [];
  $fallsBusinesses = [];

  foreach ($businesses as $business) {
    $allBusinesses[] = $business;
    switch ($business['TypeName']) {
      case 'Resort':
        $resortBusinesses[] = $business;
        break;
      case 'Farm':
        $farmBusinesses[] = $business;
        break;
      case 'Falls':
        $fallsBusinesses[] = $business;
        break;
    }
  }

  // Output the data for falls to the console
  echo '<script>console.log(' . json_encode($fallsBusinesses) . ');</script>';
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
