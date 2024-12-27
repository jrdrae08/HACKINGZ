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
            GROUP_CONCAT(f.FeatureName SEPARATOR ' • ') as Features
        FROM business_media bm
        JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
        JOIN businesstype bt ON bif.BusinessTypeID = bt.BusinessTypeID
        LEFT JOIN business_features bf ON bif.BusinessInfoID = bf.BusinessInfoID
        LEFT JOIN features f ON bf.FeatureID = f.FeatureID
        WHERE bm.isActive = 1 
        AND bif.BusinessName LIKE :search
        GROUP BY bif.BusinessInfoID
    ";

  $stmt = $pdo->prepare($query);
  $stmt->execute(['search' => "%$searchTerm%"]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
