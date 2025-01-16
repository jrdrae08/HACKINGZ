<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Return a response
echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
exit();
?>