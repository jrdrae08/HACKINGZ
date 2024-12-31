<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

$barangayId = $_SESSION['user_id'];

try {
  $stmt = $pdo->prepare("
        SELECT Thumbnail, Quotation, Image1, Image2, Image3, Image4, Image5, Image6
        FROM business_media
        WHERE barangayId = :barangayId AND isActive = 1
    ");
  $stmt->execute(['barangayId' => $barangayId]);
  $media = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($media) {
    echo json_encode($media);
  } else {
    echo json_encode(['error' => 'No media found']);
  }
} catch (PDOException $e) {
  echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
