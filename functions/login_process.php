<?php
// Start a PHP session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "db_connection.php";

    // Get form data and sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username exists in the database
    $check_query = "SELECT * FROM tbl_user WHERE username='$username'";
    $result = mysqli_query($conn, $check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Check if the password matches
        if ($password == $user['password']) {
            // Password is correct, store username in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            // Redirect to dashboard or homepage
            header("Location: ../index.php");
            exit();
        } else {
            // Password is incorrect, redirect back to login with error
            header("Location: ../login.html?error=invalid_password");
            exit();
        }
    } else {
        // User not found, redirect back to login with error
        header("Location: ../login.html?error=user_not_found");
        exit();
    }
} else {
    // If the form was not submitted, redirect to the login page
    header("Location: ../login.html");
    exit();
}
?>
