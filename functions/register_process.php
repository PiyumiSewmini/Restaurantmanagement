<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "db_connection.php";

    // Get form data and sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validate password and confirm password match
    if ($password != $confirm_password) {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=password_mismatch");
        exit();
    }

    // Check if the username or email already exists in the database
    $check_query = "SELECT * FROM tbl_user WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=user_exists");
        exit();
    }

    // Insert user data into the database
    $insert_query = "INSERT INTO tbl_user (username, email, phone, address, password) 
                     VALUES ('$username', '$email', '$phone', '$address', '$password')";

    if (mysqli_query($conn, $insert_query)) {
        // Registration successful, redirect to login page
        header("Location: ../login.html");
        exit();
    } else {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=registration_failed");
        exit();
    }
} else {
    // If the form was not submitted, redirect to the registration page
    header("Location: register.html");
    exit();
}
?>
