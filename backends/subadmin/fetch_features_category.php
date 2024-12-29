<?php
include "../includes/db.php";

// Fetch all businesses
$businessesStmt = $pdo->prepare("
    SELECT bm.BusinessInfoID, bi.BusinessName, bm.Thumbnail, bm.Quotation
    FROM business_media bm
    JOIN businessinformationform bi ON bm.BusinessInfoID = bi.BusinessInfoID
");
$businessesStmt->execute();
$businesses = $businessesStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare features data
$featuresData = [];
foreach ($businesses as $business) {
  $businessInfoID = $business['BusinessInfoID'];

  $featuresStmt = $pdo->prepare("
        SELECT f.FeatureID, f.FeatureName, bf.IsActive
        FROM business_features bf 
        JOIN features f ON bf.FeatureID = f.FeatureID
        WHERE bf.BusinessInfoID = :businessInfoID AND bf.IsActive = 1
    ");
  $featuresStmt->execute(['businessInfoID' => $businessInfoID]);
  $featuresData[$businessInfoID] = $featuresStmt->fetchAll(PDO::FETCH_ASSOC);
}
// Optional: You can output the data as JSON or in any format you prefer
// header('Content-Type: application/json');
// echo json_encode(['businesses' => $businesses, 'features' => $featuresData]);
