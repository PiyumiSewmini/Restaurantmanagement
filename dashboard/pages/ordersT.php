<?php
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header("Location: unauthorized.php");
    exit();
}
include '../functions/config.php';

$sql = "SELECT * FROM tbl_order";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<div class="row mb-4">';
    echo '<div class="col-md-6">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Search...">';
    echo '</div>';
    echo '<div class="col-md-6 text-right">';
    echo '<a href="functions/add_order.php" class="btn btn-primary ml-2"><i class="fas fa-plus"></i> Add Order</a>';
    echo '</div>';
    echo '</div>';

    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Order ID</th>';
    echo '<th>Username</th>';
    echo '<th>Food ID</th>';
    echo '<th>Quantity</th>';
    echo '<th>Price</th>';
    echo '<th>Date Ordered</th>';
    echo '<th>Time Ordered</th>';
    echo '<th>Status</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['order_id'] . '</td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['food_id'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . $row['date_ordered'] . '</td>';
        echo '<td>' . $row['time_ordered'] . '</td>';
        echo '<td>' . $row['stts'] . '</td>';
        echo '<td>';
        echo '<a href="functions/update_order.php?id=' . $row['order_id'] . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>';
        echo '<a href="functions/delete_order.php?id=' . $row['order_id'] . '" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo "No orders found.";
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
