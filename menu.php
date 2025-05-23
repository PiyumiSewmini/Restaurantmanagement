<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .menu-card {
            width: calc(25% - 20px); /* 25% width for each card with a gap of 20px */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .menu-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .menu-card form{
            padding: 0;
            margin: 0;
        }

        .menu-info {
            padding: 15px;
        }

        .menu-info h2 {
            margin-bottom: 10px;
        }

        .menu-info h6 {
            text-align: center;
        }

        .menu-info p {
            margin-bottom: 5px;
        }
        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-container input,
        .search-container select,
        .search-container input[type="number"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Adjust input and select width as needed */
        .search-container input[type="text"] {
            width: 200px;
        }

        .search-container select {
            width: 150px;
        }

        .search-container input[type="number"] {
            width: 100px;
        }
        .buy-now-btn{
            background: green;
            margin: 5px;
            width: 60px;
            width: 120px;
            height: 40px;
        }
        .add-to-cart-btn{
            background: orange;
            width: 120px;
            height: 40px;
            margin: 5px;
        }
    </style>
</head>
<body>
<header><?php include_once 'navbar.php'; ?></header>
<div class="container" style="margin-top: 100px;">
        <h1>Our Menu</h1>
        <!-- Search bar with filter options -->
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="filterMenu()" placeholder="Search by name...">
            <select id="categoryFilter" onchange="filterMenu()">
                <option value="">All Categories</option>
                <option value="Main Course">Main Course</option>
                <option value="Bread">Bread</option>
                <option value="Beverage">Beverage</option>
                <option value="Dessert">Dessert</option>
                <option value="Appetizer">Appetizer</option>
                <option value="Side Dish">Side Dish</option>
            </select>
            <input type="number" id="priceFilter" min="0" max="100" placeholder="Max Price" oninput="filterMenu()">
            <input type="number" id="minPriceFilter" min="0" max="100" placeholder="Min Price" oninput="filterMenu()">
        </div>
        <!-- Menu cards -->
        <div class="menu-container" id="menuContainer">
            <?php
                // Include database connection
                include_once "functions/db_connection.php";

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmOrder'])) {
                    $foodId = $_POST['foodId'];
                    $quantity = $_POST['quantity'];
                    $price = $_POST['price'];
                    $username = $_SESSION['username'];
                    $date = date("Y-m-d");
                    $time = date("H:i:s");
                
                    // Using prepared statement to prevent SQL injection
                    $insertOrder = $conn->prepare("INSERT INTO tbl_order (username, food_id, quantity, price, date_ordered, time_ordered) VALUES (?, ?, ?, ?, ?, ?)");
                    $insertOrder->bind_param("siidss", $username, $foodId, $quantity, $price, $date, $time);
                
                    if ($insertOrder->execute()) {
                        http_response_code(200); // Success HTTP response code
                    } else {
                        http_response_code(400); // Error HTTP response code
                    }
                } else {
                    http_response_code(400); // Invalid request HTTP response code
                }

                // Fetch data from tbl_food
                $sql = "SELECT * FROM tbl_food";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display menu cards with Buy Now button
                        echo '<div class="menu-card">';
                        echo '<img src="img/' . $row['image_url'] . '" alt="' . $row['name'] . '">';
                        echo '<div class="menu-info">';
                        echo '<h2>' . $row['name'] . '</h2>';
                        echo '<h6>' . $row['category'] . '</h6>';
                        echo '<p>' . $row['description'] . '</p>';
                        echo '<p id="price_' . $row['id'] . '">Price: $' . $row['price'] . '</p>';
                        echo '<div class="button-container">';
                        echo '<button class="buy-now-btn" onclick="confirmOrder(' . $row['id'] . ', \'' . $row['price'] . '\')">Buy Now</button>';
                        echo '<form method="post" action="functions/add_to_cart.php">';
                        echo '<input type="hidden" name="addToCart" value="true">';
                        echo '<input type="hidden" name="foodId" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="quantity" value="1"> <!-- Default quantity -->';
                        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
                        echo '<button type="submit" class="add-to-cart-btn">Add to Cart</button>';
                        echo '</form>';
                        echo '</div>'; // Close button-container
                        echo '</div>'; // Close menu-info
                        echo '</div>'; // Close menu-card
                    }
                } else {
                    echo '<p>No items found.</p>';
                }

                // Close database connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

    <script>
        function filterMenu() {
            var input, filter, container, cards, card, title, category, price, categoryFilter, priceFilter, minPriceFilter, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            container = document.getElementById("menuContainer");
            cards = container.getElementsByClassName("menu-card");
            categoryFilter = document.getElementById("categoryFilter").value;
            priceFilter = document.getElementById("priceFilter").value;
            minPriceFilter = document.getElementById("minPriceFilter").value;

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                title = card.getElementsByTagName("h2")[0];
                category = card.querySelector(".menu-info h6:nth-of-type(1)").textContent.toUpperCase();
                price = card.querySelector(".menu-info p:nth-of-type(2)").textContent.replace("Price: $", "");

                if (
                    title.textContent.toUpperCase().indexOf(filter) > -1 &&
                    (categoryFilter === "" || category.includes(categoryFilter.toUpperCase())) &&
                    (priceFilter === "" || parseFloat(price) <= parseFloat(priceFilter)) &&
                    (minPriceFilter === "" || parseFloat(price) >= parseFloat(minPriceFilter))
                ) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>
<script>
    function confirmOrder(foodId, price) {
    // Check if the user is logged in
    if ('<?php echo isset($_SESSION['username']); ?>' !== '1') {
        alert('You must be logged in to place an order.');
        return;
    }

    var quantity = prompt("Enter quantity:", "1");
    if (quantity != null) {
        var totalPrice = parseFloat(price) * parseInt(quantity);
        var confirmMsg = "Confirm order for " + quantity + " item(s) totaling $" + totalPrice.toFixed(2) + "?";
        if (confirm(confirmMsg)) {
            buynow(foodId, quantity, totalPrice);
        }
    }
}


    function buynow(foodId, quantity, totalPrice) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    alert("Order confirmed. Thank you!");
                } else {
                    alert("Error processing order. Please try again.");
                }
            }
        };
        xhttp.open("POST", "menu.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("confirmOrder=true&foodId=" + foodId + "&quantity=" + quantity + "&price=" + totalPrice);
    }
</script>


</body>
</html>
