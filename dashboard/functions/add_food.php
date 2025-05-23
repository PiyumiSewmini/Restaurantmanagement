<?php
error_reporting(E_ERROR | E_WARNING);
session_start();

// Check if the user is logged in and their user type is authorized (2 for advertiser)
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}

// Include your database configuration file
include 'config.php';

// Function to handle unique file names by incrementing if the file exists
function getUniqueFileName($targetDir, $imageName) {
    $baseName = pathinfo($imageName, PATHINFO_FILENAME);
    $extension = pathinfo($imageName, PATHINFO_EXTENSION);
    $targetFile = $targetDir . $imageName;
    $counter = 1;

    while (file_exists($targetFile)) {
        $newFileName = $baseName . '-' . $counter . '.' . $extension;
        $targetFile = $targetDir . $newFileName;
        $counter++;
    }

    return $targetFile;
}

// Check if the add form is submitted
if (isset($_POST['addFood'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // File upload handling
    $targetDir = "../../img/";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageName = basename($_FILES["image"]["name"]); // Get only the image name
        $targetFile = getUniqueFileName($targetDir, $imageName);
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
        // if everything is ok, try to upload file and store image URL
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Insert new food into the database
                $insertQuery = "INSERT INTO tbl_food (name, category, description, price, image_url) 
                                VALUES ('$name', '$category', '$description', '$price', '$imageName')";
                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    echo "<code>Food added successfully.</code>";
                } else {
                    echo "<code>Error adding food: " . mysqli_error($conn) . "</code>";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Add Food</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control-file" required>
        </div>

        <button type="submit" name="addFood" class="btn btn-primary">Add Food</button>
    </form>
</div>

</body>
</html>
