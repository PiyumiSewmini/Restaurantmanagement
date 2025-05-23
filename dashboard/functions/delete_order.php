<?php
error_reporting(E_ERROR | E_WARNING);
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $orderID = $_GET['id'];

    $sql = "SELECT * FROM tbl_order WHERE order_id='$orderID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $deleteQuery = "DELETE FROM tbl_order WHERE order_id='$orderID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<code>Order deleted successfully.</code>";
        } else {
            echo "<code>Error deleting order: " . mysqli_error($conn) . "</code>";
        }
    } else {
        echo "<code>Order not found.</code>";
    }
} else {
    echo "<code>Order ID not provided.</code>";
}

mysqli_close($conn);
?>
