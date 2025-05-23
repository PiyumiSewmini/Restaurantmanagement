<?php
session_start();
if (!isset($_SESSION['IsAdmin']) || $_SESSION['IsAdmin'] !== true) {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <style>
        body{
            overflow-x: hidden;
        }
        .sidebarDash {
            position: fixed;
            top: 0;
            left: 0px;
            width: 250px;
            height: 100vh;
            background-color: #333;
            transition: left 0.3s ease-in-out;
            z-index: 1000;
            /* Ensure it's above other content */
        }

        .sidebarDash-content {
            padding: 50px 20px 20px 20px;
        }

        .sidebarDash-content li {
            padding: 20px;
        }

        .sidebarDash-content li:hover {
            background: #595959;
        }

        .sidebarDash-content li a {
            text-decoration: none;
        }

        /* Adjust content area to accommodate sidebar */
        #contentDash {
            transition: margin-left 0.3s ease-in-out;
            margin-left: 250px;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <!-- Toggle button for sidebar -->
    <div class="toggle-btn d-none" id="toggleBtn">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Sidebar -->
    <div class="sidebarDash">
        <div class="sidebarDash-content">
            <h5 class="text-white">Welcome, Admin</h5>
            <ul class="list-unstyled">
                <li><a href="#" data-page="foodsT.php" class="text-white">Foods</a></li>
                <li><a href="#" data-page="usersT.php" class="text-white">Customers</a></li>
                <li><a href="#" data-page="ordersT.php" class="text-white">Orders</a></li>  
                <button type="button" class="btn btn-primary ml-2" id="webBtn">Go To Website</button>
                <button type="button" class="btn btn-danger ml-2 mt-2" id="logoutBtn">Logout</button>
            </ul>
        </div>
    </div>

    <!-- Content Area -->
    <div id="contentDash" class="container">
        <!-- Dynamic content will be loaded here -->
    </div>

    <script>
        $(document).ready(function() {
            $('#logoutBtn').on('click', function() {
            window.location.href = 'functions/logout.php'; // Redirect to logout.php
        });

        $('#webBtn').on('click', function() {
            window.location.href = '../';
        });

            var currentPage = sessionStorage.getItem('currentPage');
            if (currentPage) {
                loadPage(currentPage);
            } else {
                loadPage('foodsT.php'); // Set 'home.php' as the default page
            }
            // Handle sidebar item clicks to load pages
            $('.sidebarDash a').on('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                var pageUrl = $(this).data('page'); // Get the data-page attribute value
                loadPage(pageUrl);
                // Save the current page to session storage
                sessionStorage.setItem('currentPage', pageUrl);
            });
            // Load the initial page content
            function loadPage(pageUrl) {
                $('#contentDash').load('pages/' +
                pageUrl); // Load the page content into the #contentDash element
            }
        });
    </script>
</body>

</html>