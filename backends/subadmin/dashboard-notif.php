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
