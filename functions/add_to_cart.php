<?php
session_start();
include_once "db_connection.php";

// Check if cart_id is already set in the session
if (!isset($_SESSION['cart_id'])) {
    // Generate a unique cart ID and store it in the session
    $_SESSION['cart_id'] = generateUniqueCartId($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
    $cartId = $_SESSION['cart_id']; // Get the cart_id from the session

    $foodId = $_POST['foodId'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Using prepared statement to prevent SQL injection
    $insertCart = $conn->prepare("INSERT INTO tbl_cart (cart_id, food_id, quantity, price) VALUES (?, ?, ?, ?)");
    if (!$insertCart) {
        // Error in preparing the statement
        echo '<script>alert("Error preparing statement. Please try again.");</script>';
    } else {
        $insertCart->bind_param("sidi", $cartId, $foodId, $quantity, $price);
        if ($insertCart->execute()) {
            // Item added to cart successfully
            echo '<script>alert("Item added to cart successfully!");</script>';
            // Redirect to menu.php
            echo '<script>window.location.href = "../menu.php";</script>';
            exit();
        } else {
            // Error adding item to cart
            echo '<script>alert("Error adding item to cart. Please try again.");</script>';
        }
    }
}

function generateUniqueCartId($conn) {
    $cartId = uniqid(); // Generate a unique ID

    // Check if the generated ID already exists in the database
    $checkCartId = $conn->prepare("SELECT cart_id FROM tbl_cart WHERE cart_id = ?");
    $checkCartId->bind_param("s", $cartId);
    $checkCartId->execute();
    $checkCartId->store_result();

    if ($checkCartId->num_rows > 0) {
        // If the ID exists, generate a new unique ID recursively
        $cartId = generateUniqueCartId($conn);
    }

    return $cartId;
}
?>
