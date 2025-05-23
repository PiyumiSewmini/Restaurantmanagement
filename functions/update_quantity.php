<?php
session_start();
include_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['food_id']) && isset($_POST['quantity'])) {
    $foodId = $_POST['food_id'];
    $newQuantity = $_POST['quantity'];

    // Update the quantity in tbl_cart
    $updateQuantityQuery = $conn->prepare("UPDATE tbl_cart SET quantity = ? WHERE food_id = ?");
    $updateQuantityQuery->bind_param("ii", $newQuantity, $foodId);

    if ($updateQuantityQuery->execute()) {
        // Quantity updated successfully
        echo 'Quantity updated successfully.';
    } else {
        // Error updating quantity
        echo 'Error updating quantity.';
    }
} else {
    // Invalid request
    echo 'Invalid request.';
}
?>
