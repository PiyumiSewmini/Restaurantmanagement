<?php
session_start();
include_once "db_connection.php";

// Check if food_id is provided via POST
if (isset($_POST['food_id'])) {
    $foodId = $_POST['food_id'];
    $cartId = $_SESSION['cart_id'];

    // Prepare and execute a DELETE query to remove the item from tbl_cart
    $deleteItem = $conn->prepare("DELETE FROM tbl_cart WHERE cart_id = ? AND food_id = ?");
    $deleteItem->bind_param("si", $cartId, $foodId);

    if ($deleteItem->execute()) {
        // Deletion successful
        echo "Item deleted successfully.";
    } else {
        // Error deleting item
        echo "Error deleting item.";
    }
} else {
    // Food ID not provided
    echo "Food ID not provided.";
}
?>
