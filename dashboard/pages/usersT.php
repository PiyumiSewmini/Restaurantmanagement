<?php
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include '../functions/config.php';

$sql = "SELECT * FROM tbl_user";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<div class="row mb-4">';
    echo '<div class="col-md-6">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Search...">';
    echo '</div>';
    echo '<div class="col-md-6 text-right">';
    echo '<a href="functions/add_user.php" class="btn btn-primary ml-2"><i class="fas fa-plus"></i> Add User</a>';
    echo '</div>';
    echo '</div>';

    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Username</th>';
    echo '<th>Email</th>';
    echo '<th>Phone</th>';
    echo '<th>Address</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['phone'] . '</td>';
        echo '<td>' . $row['address'] . '</td>';
        echo '<td>';    
        echo '<a href="functions/update_user.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>';
        echo '<a href="functions/delete_user.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo "No users found.";
}

mysqli_close($conn);
?>

<script>
$(document).ready(function() {  
    $('#searchInput').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();
        $('tbody tr').each(function() {
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
