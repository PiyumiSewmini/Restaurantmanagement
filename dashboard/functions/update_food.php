<?php
error_reporting(E_ERROR | E_WARNING);
session_start();

if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $foodID = $_GET['id'];

    $sql = "SELECT * FROM tbl_food WHERE id='$foodID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['updateFood'])) {
            $name = $_POST['name'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            // Check if an image is uploaded
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
                $targetDir = "../../img/";
                $imageName = basename($_FILES["image"]["name"]); // Get only the image name
                $targetFile = $targetDir . $imageName;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check file size (max allowed size in bytes)
                $maxFileSize = 5000000; // 5MB
                if ($_FILES["image"]["size"] > $maxFileSize) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                $allowedFileTypes = array("jpg", "jpeg", "png", "gif");
                if (!in_array($imageFileType, $allowedFileTypes)) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        // Update food in the database with the new image URL
                        $updateQuery = "UPDATE tbl_food SET name='$name', category='$category', description='$description', price='$price', image_url='$imageName' WHERE id='$foodID'";
                        $updateResult = mysqli_query($conn, $updateQuery);

                        if ($updateResult) {
                            echo "<code>Food updated successfully.</code>";
                        } else {
                            echo "<code>Error updating food: " . mysqli_error($conn) . "</code>";
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                // No image uploaded, update food in the database without changing the image URL
                $updateQuery = "UPDATE tbl_food SET name='$name', category='$category', description='$description', price='$price' WHERE id='$foodID'";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    echo "<code>Food updated successfully.</code>";
                } else {
                    echo "<code>Error updating food: " . mysqli_error($conn) . "</code>";
                }
            }
        }

        // HTML form to update food details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Food</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>

        <div class="container mt-5">
            <h1 class="mb-4">Update Food</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $foodID; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" class="form-control" value="<?php echo $row['category']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required><?php echo $row['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" class="form-control-file">
                </div>

                <button type="submit" name="updateFood" class="btn btn-primary">Update Food</button>
            </form>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo "<code>Food not found.</code>";
    }
} else {
    echo "<code>Food ID not provided.</code>";
}

mysqli_close($conn);
?>
