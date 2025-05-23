
        <a href="#" class="logo">
            <img src="img/indian.jpg" alt="logo">
        </a>
        <!--menu icon-->
        <i class='bx bx-menu' id="menu-icon"></i>
        <!--links-->
        <ul class="navbar">
            <il><a href="index.php">HOME</a></il>
            <il><a href="#about">ABOUT US</a></il>
            <il><a href="menu.php">MENU</a></il>
            <?php
                
                if(isset($_SESSION['username'])) {
                    echo '<a href="#" class="username">Hi, ' . $_SESSION['username'] . '</a>';
                } else {
                    echo '<il><a href="register.html">REGISTER</a></il>';
                }
            ?>
        </ul>
        <!--icons-->
        <div class="header-icon">
        <?php
            if(isset($_SESSION['username'])) {
              echo '<a href="functions/logout.php" class="logout-link"><i class="bx bx-log-out"></i></a>';
            }
        ?>
        <a href="cart.php"><i class='bx bx-cart'></i></a>
        <i class='bx bx-search-alt' id="search-icon" ></i> 
    </div>   
    <!--search-->
    <div class="search-box">
        <input type="search" placeholder="search menu...">
    </div>
