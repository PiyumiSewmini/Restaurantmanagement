<?php
error_reporting(E_ERROR | E_WARNING);
session_start();

if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    $sql = "SELECT * FROM tbl_user WHERE id='$userID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['updateUser'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = $_POST['password'];

            $updateQuery = "UPDATE tbl_user SET username='$username', email='$email', phone='$phone', address='$address', password='$password' WHERE id='$userID'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                echo "<code>User updated successfully.</code>";
            } else {
                echo "<code>Error updating user: " . mysqli_error($conn) . "</code>";
            }
        }

        // HTML form to update user details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>

        <div class="container mt-5">
            <h1 class="mb-4">Update User</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $userID; ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo $row['address']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" value="<?php echo $row['password']; ?>" placeholder="Enter new password">
                </div>

                <button type="submit" name="updateUser" class="btn btn-primary">Update User</button>
            </form>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo "<code>User not found.</code>";
    }
} else {
    echo "<code>User ID not provided.</code>";
}

mysqli_close($conn);
?>
