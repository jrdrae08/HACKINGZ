<?php
include '../../includes/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

function respond($status, $message, $data = null)
{
  echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
  exit;
}

try {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $refNum = $_POST['refNum'] ?? null;

    if ($refNum) {
      // Check if the reference number exists and meets the conditions
      $stmt = $pdo->prepare("SELECT * FROM businessapplicationform WHERE RefNum = :refNum AND Status = 'Approved' AND ReminderSent = 1");
      $stmt->bindParam(':refNum', $refNum, PDO::PARAM_STR);
      $stmt->execute();
      $applicationData = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($stmt->errorCode() != '00000') {
        respond('error', 'Query error: ' . implode(", ", $stmt->errorInfo()));
      }

      if ($applicationData) {
        $stmt = $pdo->prepare("SELECT bi.*, bt.TypeName AS BusinessType FROM businessinformationform bi JOIN businesstype bt ON bi.BusinessTypeID = bt.BusinessTypeID WHERE bi.ApplicationID = :applicationID");
        $stmt->bindParam(':applicationID', $applicationData['ApplicationID'], PDO::PARAM_INT);
        $stmt->execute();
        $businessData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->errorCode() != '00000') {
          respond('error', 'Query error: ' . implode(", ", $stmt->errorInfo()));
        }

        $data = array_merge($applicationData, $businessData);

        echo json_encode([
          'status' => 'success',
          'message' => 'Record has been found. Please wait...',
          'data' => $data,
          'applicationID' => $applicationData['ApplicationID'],
          'redirect' => '../../businessowner/business_renew.php'
        ]);
      } else {
        // Check if the reference number exists but ReminderSent is 0
        $stmt = $pdo->prepare("SELECT * FROM businessapplicationform WHERE RefNum = :refNum AND Status = 'Approved' AND ReminderSent = 0");
        $stmt->bindParam(':refNum', $refNum, PDO::PARAM_STR);
        $stmt->execute();
        $applicationData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($applicationData) {
          respond('error', 'Your business permit is not yet expired.');
        } else {
          respond('error', 'No record found for the given reference number.');
        }
      }
    } else {
      respond('error', 'Invalid input data.');
    }
  } else {
    respond('error', 'Invalid request method.');
  }
} catch (PDOException $e) {
  error_log('PDOException: ' . $e->getMessage());
  respond('error', 'Query failed: ' . $e->getMessage());
} catch (Exception $e) {
  error_log('Exception: ' . $e->getMessage());
  respond('error', 'An unexpected error occurred: ' . $e->getMessage());
}
