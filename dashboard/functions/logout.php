<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// echo "<script>window.location.reload();</script>";
header('Location: ../login.html');
exit();
?>
