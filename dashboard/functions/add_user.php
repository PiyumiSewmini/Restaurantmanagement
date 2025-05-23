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

// Check if the add form is submitted
if (isset($_POST['addUser'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password']; // Note: You should hash passwords for security, this is just a basic example
    
    // Insert new user into the database
    $insertQuery = "INSERT INTO tbl_user (username, email, phone, address, password) 
                    VALUES ('$username', '$email', '$phone', '$address', '$password')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        echo "<code>User added successfully.</code>";
    } else {
        echo "<code>Error adding user: " . mysqli_error($conn) . "</code>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Add User</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="addUser" class="btn btn-primary">Add User</button>
    </form>
</div>

</body>
</html>
