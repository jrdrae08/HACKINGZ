<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
  header('Location: ../login.php');
  exit;
}
include '../includes/db.php';

// Fetch the RefNum based on the ApplicationID stored in the session
$applicationID = $_SESSION['bowner_id'];
$businessinfoID = $_SESSION['business_info_id'];
echo "<script>console.log('ApplicationID: " . $applicationID . "');</script>";
echo "<script>console.log('BusinessInfoID: " . $businessinfoID . "');</script>";
$stmt = $pdo->prepare('SELECT RefNum, ReminderSent, isRenew, reuploadDate, renewalReject FROM businessapplicationform WHERE ApplicationID = :applicationID');
$stmt->execute(['applicationID' => $applicationID]);
$application = $stmt->fetch(PDO::FETCH_ASSOC);
$refNum = $application['RefNum'];
$reminderSent = $application['ReminderSent'];
$isRenew = $application['isRenew'];
$reuploadDate = $application['reuploadDate'];
$renewalReject = $application['renewalReject'];

try {
  $stmt = $pdo->prepare("
      SELECT 
          r.status, 
          COUNT(*) as count 
      FROM 
          reservations r
      JOIN 
          roominfotable rt ON r.roomID = rt.roomID
      WHERE 
          rt.BusinessInfoID = :businessinfoID
          AND r.status IN ('Pending', 'Accepted', 'Ongoing')
      GROUP BY 
          r.status
  ");
  $stmt->execute([':businessinfoID' => $businessinfoID]);
  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Initialize counts
  $pendingCount = 0;
  $acceptedCount = 0;
  $ongoingCount = 0;

  // Assign counts based on status
  foreach ($reservations as $reservation) {
      switch ($reservation['status']) {
          case 'Pending':
              $pendingCount = $reservation['count'];
              break;
          case 'Accepted':
              $acceptedCount = $reservation['count'];
              break;
          case 'Ongoing':
              $ongoingCount = $reservation['count'];
              break;
      }
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}