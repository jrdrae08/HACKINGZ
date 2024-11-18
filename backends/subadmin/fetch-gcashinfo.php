<?php
// fetch-gcashinfo.php
session_start();
include "../../includes/db.php";

$response = [
  'message' => '',
  'message_type' => '',
  'data' => null
];

if (isset($_SESSION['business_info_id'])) {
  $businessInfoID = $_SESSION['business_info_id'];

  $stmt = $pdo->prepare("SELECT bgcashnum, bgcashname, bgcashQrImage FROM qcashPayment WHERE BusinessInfoID = ?");
  $stmt->execute([$businessInfoID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $response['data'] = $result;
    $response['message'] = 'Data fetched successfully.';
    $response['message_type'] = 'success';
  } else {
    $response['message'] = 'No data found.';
    $response['message_type'] = 'warning';
  }
} else {
  $response['message'] = 'Business Info ID not set.';
  $response['message_type'] = 'danger';
}

echo json_encode($response);
exit;
