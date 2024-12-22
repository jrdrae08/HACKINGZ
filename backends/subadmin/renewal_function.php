<?php
require '../../includes/db.php';

function respond($status, $message, $redirect = null)
{
  $response = ['status' => $status, 'message' => $message];
  if ($redirect) {
    $response['redirect'] = $redirect;
  }
  echo json_encode($response);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $refNum = $_POST['refNum'];

  $stmt = $pdo->prepare("SELECT * FROM businessapplicationform WHERE RefNum = ? AND Status = 'Approved'");
  $stmt->execute([$refNum]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    if ($result['ReminderSent'] == 1) {
      $applicationID = $result['ApplicationID'];
      respond('success', 'Record has been found. Please wait...', '../../businessowner/business_renew.php?application_id=' . $applicationID);
    } else {
      respond('error', 'Your Business Permit is not yet expired.');
    }
  } else {
    respond('error', 'Reference number not found.');
  }
}
