<?php
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include '../functions/config.php';

$sql = "SELECT * FROM tbl_food";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="container w-75">';
    echo '<div class="row mb-4">';
    echo '<div class="col-md-6">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Search...">';
    echo '</div>';
    echo '<div class="col-md-6 text-right">';
    echo '<a href="functions/add_food.php" class="btn btn-primary ml-2"><i class="fas fa-plus"></i> Add Food</a>';
    echo '</div>';
    echo '</div>';

    echo '<div class="row" id="foodsContainer">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-lg-4 col-md-6 mb-4 foodItem">';
        echo '<div class="card">';
        echo '<img src="../img/' . $row['image_url'] . '" class="card-img-top" alt="../' . $row['image_url'] . '" width="300px" height="225px">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['name'] . '</h5>';
        echo '<p class="card-text">' . $row['description'] . '</p>';
        echo '</div>';
        echo '<ul class="list-group list-group-flush">';
        echo '<li class="list-group-item">Category: ' . $row['category'] . '</li>';
        echo '<li class="list-group-item">Price: ' . $row['price'] . '</li>';
        echo '</ul>';
        echo '<div class="card-body">';
        echo '<a href="functions/update_food.php?id=' . $row['id'] . '" class="btn btn-primary"><i class="fas fa-pen"></i> Update</a>';
        echo '<a href="functions/delete_food.php?id=' . $row['id'] . '" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo "No foods found.";
}

mysqli_close($conn);
?>

<script>
$(document).ready(function() {  
    $('#searchInput').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();
        $('.foodItem').each(function() { // Change the selector to target the food items
            var lineText = $(this).text().toLowerCase();
            if (lineText.indexOf(searchText) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});

</script>

