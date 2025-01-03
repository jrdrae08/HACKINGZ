<?php
include '../../includes/db.php';

try {
  $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

  $query = "
        SELECT DISTINCT 
            bm.Thumbnail, 
            bm.Quotation, 
            bif.BusinessName, 
            bif.BusinessInfoID, 
            bt.TypeName,
            ba.establishment,
            ba.barangayId,  -- Include barangayId
            GROUP_CONCAT(f.FeatureName SEPARATOR ' • ') as Features
        FROM business_media bm
        JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
        JOIN businesstype bt ON bif.BusinessTypeID = bt.BusinessTypeID
        LEFT JOIN barangay_accounts ba ON bm.barangayId = ba.barangayId
        LEFT JOIN business_features bf ON bif.BusinessInfoID = bf.BusinessInfoID
        LEFT JOIN features f ON bf.FeatureID = f.FeatureID
        WHERE bm.isActive = 1 
        AND (bif.BusinessName LIKE :search OR ba.establishment LIKE :search)
        GROUP BY bif.BusinessInfoID, ba.barangayId
        
        UNION
        
        SELECT DISTINCT 
            bm.Thumbnail,
            bm.Quotation,
            NULL as BusinessName,
            NULL as BusinessInfoID,
            'Falls' as TypeName,
            ba.establishment,
            ba.barangayId,  -- Include barangayId
            NULL as Features
        FROM barangay_accounts ba
        LEFT JOIN business_media bm ON ba.barangayId = bm.barangayId AND bm.isActive = 1
        WHERE ba.BusinessTypeID = 21
        AND ba.establishment LIKE :search
    ";

  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$searchTerm%"
  ]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Debugging: Log the results to the PHP error log
  error_log(print_r($results, true));

  header('Content-Type: application/json');
  echo json_encode([
    'status' => 'success',
    'results' => $results
  ]);
} catch (PDOException $e) {
  header('Content-Type: application/json');
  http_response_code(500);
  echo json_encode([
    'status' => 'error',
    'message' => $e->getMessage()
  ]);
}
