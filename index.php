<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<title>Resturent website</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet"href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <!--Navbar-->
    <header><?php include_once 'navbar.php'; ?></header>
    <!--home-->
    <section class="home" id="home">
      <div class="home-text">
          <h1> Hi Foodies<br> Enjoy your favorite meal.</h1>
          <a href="menu.php" class="btn" id="order-now-btn">Order Now</a> <!-- Added id attribute for targeting with JavaScript -->
      </div>
  </section>
    <!--about-->
    <section class="about" id="about">
        <div class="about-img">
            <img src="img/restaurant.jpg" alt="restaurant">
        </div>
        <div class="about-text">
            <h2>Our Restaurant</h2>
            <p>Step into Foodies Restaurant, where every meal is a journey through the senses. Nestled in the colombo city,  offers a culinary experience like no other. As you enter, you're greeted by the gentle melody of live jazz, setting the mood for an evening of indulgence. The ambiance is a harmonious blend of modern elegance and cozy charm, with soft lighting casting a warm glow over plush seating and tasteful decor.</p>

                <p>The menu at Restaurant is a masterpiece of creativity and innovation, curated by our team of culinary artists. 

                Each dish is a work of art, meticulously crafted to tantalize your taste buds and ignite your imagination. From the delicate flavors of hand-rolled sushi to the bold aromas of sizzling steaks, there's something to delight every palate.</p>
                
                <p>But is more than just a place to dine – it's a place to escape, to dream, to savor every moment. Whether you're enjoying an intimate dinner for two or celebrating a special occasion with friends and family, our attentive staff will ensure that every detail is taken care of, leaving you free to simply relax and enjoy..</p>
        </div>
    </section>
    <footer>
  <div class="container">
    <div class="footer-content">
      <div class="footer-section contact-form">
        <h2>Opening Hours</h2>
        <ul class="opening-hours">
          <li>Monday: 9am - 5pm</li>
          <li>Tuesday: 9am - 5pm</li>
          <li>Wednesday: 9am - 5pm</li>
          <li>Thursday: 9am - 5pm</li>
          <li>Friday: 9am - 5pm</li>
          <li>Saturday: Closed</li>
          <li>Sunday: Closed</li>
        </ul>
      </div>
      <div class="footer-section links">
        <h2>Quick Links</h2>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="menu.php">Menu</a></li>
          <li><a href="register.html">Register</a></li>
        </ul>
      </div>
      <div class="footer-section contact-form">
        <h2>Contact Us</h2>
        <ul class="contact-info">
          <li><span><i class="bx bx-map"></i></span>123 Street, City, Country</li>
          <li><span><i class="bx bx-envelope"></i></span>info@example.com</li>
          <li><span><i class="bx bx-phone"></i></span>+1234567890</li>
        </ul>
        <div class="social-media">
          <a href="#"><i class='bx bxl-facebook'></i></a>
          <a href="#"><i class='bx bxl-twitter'></i></a>
          <a href="#"><i class='bx bxl-instagram'></i></a>
          <a href="#"><i class='bx bxl-linkedin'></i></a>
        </div>
      </div>
    </div>
  </div>
</footer> 
<script src="script.js"></script>
</body>
</html>