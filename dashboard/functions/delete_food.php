<?php
error_reporting(E_ERROR | E_WARNING);
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $foodID = $_GET['id'];

    $sql = "SELECT * FROM tbl_food WHERE id='$foodID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $deleteQuery = "DELETE FROM tbl_food WHERE id='$foodID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<code>Food deleted successfully.</code>";
        } else {
            echo "<code>Error deleting food: " . mysqli_error($conn) . "</code>";
        }
    } else {
        echo "<code>Food not found.</code>";
    }
} else {
    echo "<code>Food ID not provided.</code>";
}

mysqli_close($conn);
?>
