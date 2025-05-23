<?php
session_start();

// Include your database connection file
include 'functions/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please log in to continue.");</script>';
    echo '<script>window.location.href = "login.html";</script>';
    exit();
}

// Check if there is a session cart_id
$sqlCheckCartId = "SELECT cart_id FROM tbl_cart";
$resultCheckCartId = $conn->query($sqlCheckCartId);

if ($resultCheckCartId->num_rows == 0) {
    echo '<script>alert("Please select food items to continue.");</script>';
    echo '<script>window.location.href = "menu.php";</script>';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<style>
.cart-row{padding:15px 0}
.cart-row:nth-child(even){background:#efefef}
.product-name{font-size:16px;font-weight:600}
.product-options{font-size:12px;margin-bottom:5px}
.product-options span{color:#666;font-weight:400;text-transform:uppercase}
.product-articlenr{color:#666;font-weight:400;text-transform:uppercase}
.product-price small{color:#666;font-weight:300;font-size:20px;margin:0;padding:0;line-height:initial}
.cart-table .cart-row input{width:30px;height:auto;padding:2px;border-radius:0;border-color:#000;float:left;font-size:14px;text-align:center}
.cart-table .cart-row button.update{border:0;padding:7px 8px;background:#000;color:#fff;font-size:9px;float:left;margin-right:5px}
.cart-table .cart-row button.delete{background-color:#FFB2B2;color:#000!important;padding:7px 13px;font-size:13px;border:0;border-radius:50px}
.product-price-total{font-size:16px;font-weight:400;width:80%;float:left}
.cart-actions{display:flex;justify-content:center;align-items:center}
.cart-special-holder{background:#efefef}
.cart-special{padding:1em 1em 0;display:block;margin-top:.5em;border-top:1px solid #dadada}
.cart-special .cart-special-content:before{content:"\21b3";font-size:1.5em;margin-right:1em;color:#6f6f6f;font-family:helvetica,arial,sans-serif}
</style>
<body>
<div class="container">
    <h1 style="font-weight:300">Cart</h1>
    <h6><a href="menu.php">Return to Menu</a></h6>
    <form method="post" action="functions/checkout.php"> <!-- Added form for submitting the order -->
        <div class="cart-table">
            <?php
            // Initialize total price variable
            $totalPrice = 0;

            // Check if cart_id is set in the session
            if (isset($_SESSION['cart_id'])) {
                $cartId = $_SESSION['cart_id'];

                // Prepare and execute a SELECT query to fetch cart items from tbl_cart
                $selectCartItems = $conn->prepare("SELECT food_id, quantity, price FROM tbl_cart WHERE cart_id = ?");
                $selectCartItems->bind_param("s", $cartId);
                $selectCartItems->execute();
                $result = $selectCartItems->get_result();

                if ($result->num_rows > 0) {
                    // Cart items found, display them in the cart
                    while ($row = $result->fetch_assoc()) {
                        // Fetch food details using food_id
                        $foodDetailsQuery = $conn->prepare("SELECT name, price, image_url FROM tbl_food WHERE id = ?");
                        $foodDetailsQuery->bind_param("i", $row['food_id']);
                        $foodDetailsQuery->execute();
                        $foodDetails = $foodDetailsQuery->get_result()->fetch_assoc();

                        // Calculate total price for this item
                        $itemTotalPrice = $foodDetails['price'] * $row['quantity'];
                        $totalPrice += $itemTotalPrice; // Add item total price to the total price

                        ?>
                        <div class="row cart-row">
                            <!-- Display cart item details here -->
                            <div class="col-xs-12 col-md-2">
                                <!-- Display food image -->
                                <!-- Inside the while loop where you display cart items -->
                                    <input type="hidden" name="food_id[]" value="<?php echo $row['food_id']; ?>">
                                    <img src="img/<?php echo $foodDetails['image_url']; ?>" width="100%">
                            </div>
                            <div class="col-md-6">
                                <!-- Display food details -->
                                <div class="product-articlenr">#<?php echo $row['food_id']; ?></div>
                                <div class="product-name"><?php echo $foodDetails['name']; ?></div>
                                <div class="product-options">
                                    <!-- Display options like color and size -->
                                </div>
                                <div class="product-price">
                                    <!-- Input for quantity -->
                                    <input type="number" name="quantity[]" value="<?php echo $row['quantity']; ?>" size="1" class="form-control quantityInput" oninput="updateQuantity(this, <?php echo $row['food_id']; ?>)">
                                    <div class="product-price"><small>x</small> <?php echo $foodDetails['price']; ?> RS</div>
                                </div>
                            </div>
                            <div class="col-md-3 cart-actions">
                                <!-- Display total price for this item -->
                                <div class="product-price-total"><?php echo $itemTotalPrice; ?> RS</div>
                                <div class="product-delete">
                                    <button type="button" data-toggle="tooltip" title="Delete" class="delete"
                                            onclick="deleteCartItem(<?php echo $row['food_id']; ?>);"><i class="fas fa-times-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div><!-- cart-row-->
                        <?php
                    }
                } else {
                    echo '<p>Your cart is empty.</p>';
                }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
            ?>
            <div class="row cart-special-holder">
                <div class="col-md-12">
                    <!-- Display the total price -->
                    <div class="cart-special"><div class="final-price text-danger">Total Price : <?php echo $totalPrice; ?> RS</div></div>
                </div>
            </div>
        </div>
        <!-- Hidden input fields for username and total price -->
        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
        <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">

        <button type="submit" name="checkout" class="btn btn-primary">Confirm Order</button>
    </form>
</div>

<script>
    function updateQuantity(input, foodId) {
        const newQuantity = input.value;
        
        // Check if the new quantity is not less than 0
        if (newQuantity < 0) {
            input.value = 0;
            return;
        }

        // Send an AJAX request to update the quantity in the database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions/update_quantity.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Quantity updated successfully
                    console.log('Quantity updated successfully.');
                    // Reload the page to reflect the updated quantity
                    window.location.reload();
                } else {
                    // Error updating quantity
                    console.error('Error updating quantity.');
                }
            }
        };
        xhr.send('food_id=' + foodId + '&quantity=' + newQuantity);
    }


    function deleteCartItem(foodId) {
        // Send an AJAX request to delete the item from the cart
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'functions/delete_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Item deleted successfully, refresh the cart
                    window.location.reload();
                } else {
                    // Error deleting item
                    console.error('Error deleting item.');
                }
            }
        };
        xhr.send('food_id=' + foodId);
    }
</script>


</body>
</html>
