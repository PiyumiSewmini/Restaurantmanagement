<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Validate the username and password (for simplicity, using hardcoded values here)
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === 'admin' && $password === 'admin') {
            // Username and password match, set IsAdmin session variable to true
            $_SESSION['IsAdmin'] = true;

            // Redirect to the dashboard or home page
            header('Location: ../index.php');
            exit();
        } else {
            // Incorrect username or password, redirect back to the login page with an error message
            header('Location: login.html?error=1');
            exit();
        }
    } else {
        // Redirect back to the login page if username or password is not provided
        header('Location: login.html');
        exit();
    }
} else {
    // Redirect back to the login page if the form is not submitted
    header('Location: login.html');
    exit();
}
?>
