<?php
include __DIR__ . '/../../includes/db.php';

function getExpiredBusinesses($pdo)
{
  try {
    $stmt = $pdo->prepare("SELECT b.ApplicationID, DATE_FORMAT(b.CreatedAt, '%Y-%m-%d') AS 'Date Registered', 
                t.TypeName AS BusinessType, i.BusinessName, b.PermitExpDate, b.reuploadDate
            FROM businessapplicationform b
            JOIN businessinformationform i ON b.ApplicationID = i.ApplicationID
            JOIN businesstype t ON i.BusinessTypeID = t.BusinessTypeID
            WHERE b.Status = 'Approved' AND b.ReminderSent = 1
            ORDER BY b.CreatedAt DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die('Query failed: ' . $e->getMessage());
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicationId'])) {
  $applicationId = $_POST['applicationId'];

  try {
    $stmt = $pdo->prepare("SELECT reuploadDate, BusinessPermitImage, PermitExpDate, newPermitDate FROM businessapplicationform WHERE ApplicationID = ?");
    $stmt->execute([$applicationId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extract the unique ID from the existing BusinessPermitImage
    $parts = explode('-', $result['BusinessPermitImage']);
    $uniqueID = $parts[0];

    // Construct the new permit image name
    $newPermitImage = $uniqueID . '-' . date('Ymd') . '-' . end($parts);

    // Add the new permit image to the result
    $result['newPermitImage'] = $newPermitImage;
    echo json_encode($result);
  } catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
  }
}
