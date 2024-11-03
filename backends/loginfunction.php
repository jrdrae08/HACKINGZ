<?php
include "../includes/db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  if (!empty($username) && !empty($password)) {
    // Check in the admin table
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['passcode'])) {
      $_SESSION['user_id'] = $admin['id'];
      $_SESSION['role'] = 'admin';
      $_SESSION['username'] = $admin['username'];
      $_SESSION['message_type'] = 'success';
      header("Location: ../admin/dashboard.php");
      exit;
    }

    // Check in the barangay_accounts table
    $stmt = $pdo->prepare("SELECT * FROM barangay_accounts WHERE email = ?");
    $stmt->execute([$username]);
    $barangayAccount = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($barangayAccount && password_verify($password, $barangayAccount['password'])) {
      // Debugging statement to show the decrypted password
      $_SESSION['user_id'] = $barangayAccount['barangayId'];
      $_SESSION['role'] = 'barangay';
      $_SESSION['username'] = $barangayAccount['email'];
      $_SESSION['message_type'] = 'success';
      header("Location: ../barangay/dashboard.php");
      echo "Decrypted password: " . htmlspecialchars($password) . "');";
      exit;
    }

    // Check in the account table for different roles
    $stmt = $pdo->prepare("SELECT a.*, bt.TypeName AS BusinessType, b.BusinessInfoID 
                           FROM account a 
                           LEFT JOIN businessinformationform b ON a.ApplicationID = b.ApplicationID 
                           LEFT JOIN businesstype bt ON b.BusinessTypeID = bt.BusinessTypeID 
                           WHERE a.Email = ?");
    $stmt->execute([$username]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account && password_verify($password, $account['PasswordHash'])) {
      // Check if the account is inactive and the role is subadmin
      if ($account['role'] == 'subadmin' && $account['BusinessStatus'] == 'Inactive') {
        $_SESSION['message'] = 'Your account is inactive. Please contact the system administrator to reactivate your account.';
        $_SESSION['message_type'] = 'warning';
        header("Location: ../login.php");
        exit;
      } elseif ($account['BusinessArchive'] == 1) {
        $_SESSION['message'] = 'Your account is disabled. Please contact the administrator to recover your account.';
        $_SESSION['message_type'] = 'warning';
        header("Location: ../login.php");
        exit;
      } else {
        $_SESSION['bowner_id'] = $account['ApplicationID'];
        $_SESSION['user_id'] = $account['AccountID'];
        $_SESSION['role'] = $account['role'];
        $_SESSION['username'] = $account['Email'];
        $_SESSION['business_info_id'] = $account['BusinessInfoID'];
        $_SESSION['message_type'] = 'success';

        // Check if first login is required
        if ($account['FirstLoginRequired'] == 1) {
          header("Location: ../../businessowner/changepass.php");
          exit;
        }

        // Determine the appropriate dashboard based on role and business type
        if ($account['role'] == 'subadmin') {
          if ($account['BusinessType'] === 'Falls') {
            $_SESSION['role'] = 'barangay';
            header("Location: ../barangay/dashboard.php");
          } else {
            $_SESSION['role'] = 'businessowner';
            header("Location: ../businessowner/dashboard.php");
          }
          exit;
        }
      }
    } else {
      $_SESSION['message'] = 'Invalid username or password.';
      $_SESSION['message_type'] = 'danger';
      header("Location: ../login.php");
      exit;
    }
  } else {
    $_SESSION['message'] = 'Please fill in all fields.';
    $_SESSION['message_type'] = 'warning';
    header("Location: ../login.php");
    exit;
  }
} else {
  $_SESSION['message'] = 'Invalid request method.';
  $_SESSION['message_type'] = 'danger';
  header("Location: ../login.php");
  exit;
}
