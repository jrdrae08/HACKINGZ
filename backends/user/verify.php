<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=majayjaytourist';
$username = 'root';
$password = '';

try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo 'Successfully connected to the database.';
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}

$userId = isset($_GET['userID']) ? $_GET['userID'] : null;

if ($userId) {
  try {
    // Check if the user is already verified
    $stmt = $pdo->prepare("SELECT IsConfirm FROM useraccount WHERE userID = ?");
    $stmt->execute([$userId]);
    $isConfirm = $stmt->fetchColumn();

    if ($isConfirm == 1) {
      header("Location: ../../user/already-verif.php");
      exit();
    } else {
      header("Location: ../../user/user-setpassword.php?userID=" . $userId);
      exit();
    }
  } catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
  }
} else {
  die('Invalid request.');
}
