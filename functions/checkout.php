<?php
session_start();
include_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $username = $_SESSION['username'];
    $cartId = $_SESSION['cart_id'];

    // Calculate total price from tbl_cart
    $totalPriceQuery = $conn->prepare("SELECT SUM(price * quantity) AS total_price FROM tbl_cart WHERE cart_id = ?");
    $totalPriceQuery->bind_param("s", $cartId);
    $totalPriceQuery->execute();
    $totalPriceResult = $totalPriceQuery->get_result();
    $totalPriceRow = $totalPriceResult->fetch_assoc();
    $totalPrice = $totalPriceRow['total_price'];

    // Get food items with the same cart_id
    $selectCartItems = $conn->prepare("SELECT food_id, quantity, price FROM tbl_cart WHERE cart_id = ?");
    $selectCartItems->bind_param("s", $cartId);
    $selectCartItems->execute();
    $result = $selectCartItems->get_result();

    if ($result->num_rows > 0) {
        $foodIds = [];
        $quantities = [];
        while ($row = $result->fetch_assoc()) {
            $foodIds[] = $row['food_id'];
            $quantities[] = $row['quantity'];
        }
        $foodIdsString = implode(',', $foodIds);
        $quantitiesString = implode(',', $quantities);

        // Insert the order into tbl_order
        $insertOrder = $conn->prepare("INSERT INTO tbl_order (username, food_id, quantity, price, date_ordered, time_ordered) VALUES (?, ?, ?, ?, CURDATE(), CURTIME())");
        $insertOrder->bind_param("ssds", $username, $foodIdsString, $quantitiesString, $totalPrice);

        if ($insertOrder->execute()) {
            // Order inserted successfully
            echo '<script>alert("Order placed successfully!");</script>';
            echo '<script>window.location.href = "../menu.php";</script>';
        } else {
            // Error inserting order
            echo '<script>alert("Error placing order. Please try again.");</script>';
            echo '<script>window.location.href = "../menu.php";</script>';
        }

        // Clear the cart after placing the order
        $clearCart = $conn->prepare("DELETE FROM tbl_cart WHERE cart_id = ?");
        $clearCart->bind_param("s", $cartId);
        $clearCart->execute();
    } else {
        // No items in the cart
        echo '<script>alert("Your cart is empty.");</script>';
    }
}
?>