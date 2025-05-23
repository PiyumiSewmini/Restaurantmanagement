<?php
error_reporting(E_ERROR | E_WARNING);
session_start();

// Check if the user is logged in and their user type is authorized (admin)
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}

// Include your database configuration file
include 'config.php';

// Check if the add order form is submitted
if (isset($_POST['addOrder'])) {

    $username = $_POST['username'];
    $foodID = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $dateOrdered = $_POST['date_ordered'];
    $timeOrdered = $_POST['time_ordered'];
    $status = $_POST['status'];

    // Insert new order into the database
    $insertQuery = "INSERT INTO tbl_order (username, food_id, quantity, price, date_ordered, time_ordered, stts) 
                    VALUES ('$username', '$foodID', '$quantity', '$price', '$dateOrdered', '$timeOrdered', '$status')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        echo "<code>Order added successfully.</code>";
    } else {
        echo "<code>Error adding order: " . mysqli_error($conn) . "</code>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Add Order</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="food_id">Food ID:</label>
            <input type="text" id="food_id" name="food_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_ordered">Date Ordered:</label>
            <input type="date" id="date_ordered" name="date_ordered" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time_ordered">Time Ordered:</label>
            <input type="time" id="time_ordered" name="time_ordered" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" class="form-control" required>
        </div>

        <button type="submit" name="addOrder" class="btn btn-primary">Add Order</button>
    </form>
</div>

</body>
</html>
