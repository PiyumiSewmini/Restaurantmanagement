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
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['updateOrder'])) {
            $username = $_POST['username'];
            $foodID = $_POST['food_id'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $dateOrdered = $_POST['date_ordered'];
            $timeOrdered = $_POST['time_ordered'];
            $status = $_POST['status'];

            $updateQuery = "UPDATE tbl_order SET username='$username', food_id='$foodID', quantity='$quantity', price='$price', date_ordered='$dateOrdered', time_ordered='$timeOrdered', stts='$status' WHERE order_id='$orderID'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                echo "<code>Order updated successfully.</code>";
            } else {
                echo "<code>Error updating order: " . mysqli_error($conn) . "</code>";
            }
        }

        // HTML form to update order details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Order</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>

        <div class="container mt-5">
            <h1 class="mb-4">Update Order</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $orderID; ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="food_id">Food ID:</label>
                    <input type="text" id="food_id" name="food_id" class="form-control" value="<?php echo $row['food_id']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo $row['quantity']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="date_ordered">Date Ordered:</label>
                    <input type="date" id="date_ordered" name="date_ordered" class="form-control" value="<?php echo $row['date_ordered']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="time_ordered">Time Ordered:</label>
                    <input type="time" id="time_ordered" name="time_ordered" class="form-control" value="<?php echo $row['time_ordered']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" class="form-control" value="<?php echo $row['stts']; ?>" required>
                </div>

                <button type="submit" name="updateOrder" class="btn btn-primary">Update Order</button>
            </form>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo "<code>Order not found.</code>";
    }
} else {
    echo "<code>Order ID not provided.</code>";
}

mysqli_close($conn);
?>
