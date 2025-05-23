<?php
error_reporting(E_ERROR | E_WARNING);
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    $sql = "SELECT * FROM tbl_user WHERE id='$userID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $deleteQuery = "DELETE FROM tbl_user WHERE id='$userID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<code>User deleted successfully.</code>";
        } else {
            echo "<code>Error deleting user: " . mysqli_error($conn) . "</code>";
        }
    } else {
        echo "<code>User not found.</code>";
    }
} else {
    echo "<code>User ID not provided.</code>";
}

mysqli_close($conn);
?>
