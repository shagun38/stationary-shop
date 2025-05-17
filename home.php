<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stationery Shop</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shop premium stationery online: pens, paper, office and art supplies. Affordable, fast, and student-friendly.">
    <meta name="keywords" content="stationery, pens, paper, art, office, school supplies">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo"><a href="home.php" style="text-decoration: none; color: #333;">Stationery Shop</a></div>

        <ul class="nav-links">
            <li><a href="product-category-writing.php">Writing Supplies</a></li>
            <li><a href="product-category-paper.php">Paper Products</a></li>
            <li><a href="product-category-art.php">Art & Craft</a></li>
            <li><a href="product-category-office.php">Office Essentials</a></li>
        </ul>

        <div class="nav-right d-flex align-items-center gap-3">

    <!-- SEARCH FORM -->
    <form method="GET" action="search.php" class="d-flex">
        <input class="form-control me-2" type="search" name="query" placeholder="Search..." required>
    </form>

    <!-- ADMIN PANEL BUTTON -->
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="admin.php" class="btn btn-warning btn-sm">Admin Panel</a>
    <?php endif; ?>

    <!-- USER DROPDOWN / LOGIN -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown">
            <img src="images/user-icon.ico" alt="User" width="32" height="32"
                 class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="user-dashboard.php">Dashboard</a></li>
                <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a href="login.php" title="Login">
            <img src="images/user-icon.ico" alt="Login" width="28" height="28">
        </a>
    <?php endif; ?>

    <!-- CART -->
    <a href="cart.php" class="position-relative" title="Cart">
        <img src="images/cart-icon.ico" alt="Cart" width="28" height="28">
        <?php if (!empty($_SESSION['cart'])): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?>
            </span>
        <?php endif; ?>
    </a>
    </div>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>Welcome to Stationery Shop</h1>
        <p>Your one-stop shop for writing, paper, and art supplies.</p>
        <a href="#shop" class="btn">Shop Now</a>
    </div>
</section>

<section class="categories" id="shop">
    <h2>Shop by Category</h2>
    <div class="card-container">
        <?php
        $categories = [
            ['title' => 'Writing Supplies', 'img' => 'images/showcase/pen_showcase_1.png', 'link' => 'product-category-writing.php'],
            ['title' => 'Paper Products', 'img' => 'images/showcase/paper_showcase.jpg', 'link' => 'product-category-paper.php'],
            ['title' => 'Art & Craft', 'img' => 'images/showcase/art_showcase.jpg', 'link' => 'product-category-art.php'],
            ['title' => 'Office Essentials', 'img' => 'images/showcase/office_showcase.jpg', 'link' => 'product-category-office.php'],
        ];
        foreach ($categories as $cat) {
            echo "<div class='card'>
                    <a href='{$cat['link']}' style='text-decoration: none; color: #333;'>
                        <img src='{$cat['img']}' alt='{$cat['title']}'>
                        <h3>{$cat['title']}</h3>
                    </a>
                  </div>";
        }
        ?>
    </div>
</section>

<section class="offer-banner" id="offerBanner">
    <p>🎉 Get Flat 20% Off on Your First Order! Use Code: FIRST20 🎉</p>
</section>

<br>
<br>
<section class="product-carousel">
  <h2 class="text-center mb-4">Featured Products</h2>

    <div class="carousel-row" id="featuredCarousel">

        <div class="product-card">
            <img src="images/featured products/pen.jpg" alt="Ball Pen">
            <h3>Ball Pen</h3>
            <p>₹10</p>
        </div>
        <div class="product-card">
            <img src="images/featured products/marker.jpg" alt="Permanent Marker">
            <h3>Permanent Marker</h3>
            <p>₹25</p>
        </div>
        <div class="product-card">
            <img src="images/featured products/spiral notebook.jpg" alt="Spiral Notebook">
            <h3>Spiral Notebook</h3>
            <p>₹60</p>
        </div>
        <div class="product-card">
            <img src="images/featured products/sketch book.jpg" alt="Sketchbook">
            <h3>Sketchbook</h3>
            <p>₹120</p>
        </div>
                <div class="product-card">
            <img src="images/featured products/pen.jpg" alt="Ball Pen">
            <h3>Ball Pen</h3>
            <p>₹10</p>
        </div>
        
    </div>
</section>


<section class="brands">
    <h2>Our Partner Brands</h2><br>
    <div id="brandCarousel" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-flex justify-content-center custom-gap">
                    <img src="images/logo/camlin.png" alt="Camlin" style="max-height: 50px;">
                    <img src="images/logo/faber-castell.svg" alt="Faber-Castell" style="max-height: 80px;">
                    <img src="images/logo/classmate.svg" alt="Classmate" style="max-height: 80px;">
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center custom-gap">
                    <img src="images/logo/pental" alt="Pental" style="max-height: 80px;">
                    <img src="images/logo/Reynolds.png" alt="Reynolds" style="max-height: 80px;">
                    <img src="images/logo/pentonic.png" alt="Pentonic" style="max-height: 80px;">
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center custom-gap">
                    <img src="images/logo/cello.webp" alt="Cello" style="max-height: 80px;">
                    <img src="images/logo/LINC" alt="LINC" style="max-height: 80px;">
                    <img src="images/logo/uniball.webp" alt="Uniball" style="max-height: 80px;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#brandCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#brandCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="newsletter">
    <h2>Stay Updated!</h2>
    <p>Subscribe to our newsletter and get 10% off your first purchase.</p>
    <form class="newsletter-form" id="newsletterForm">
        <input type="email" placeholder="Enter your email" id="emailInput" required>
        <button type="submit">Subscribe</button>
    </form>
    <p id="successMessage" style="color: green; font-weight: bold; display: none; margin-top: 15px;">
        Thank you for subscribing!
    </p>
</section>

<section class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial-container">
        <div class="testimonial-card">
            <p>"Excellent quality stationery at great prices. Fast delivery too!"</p>
            <h4>- Riya Shah</h4>
        </div>
        <div class="testimonial-card">
            <p>"I love the variety. Got all my office supplies from here!"</p>
            <h4>- Ankit Patel</h4>
        </div>
        <div class="testimonial-card">
            <p>"Their customer service is top-notch. Highly recommended."</p>
            <h4>- Meera Desai</h4>
        </div>
    </div>
</section>

<section class="about-us">
    <h2>Why Choose Our Stationery Shop?</h2>
    <p>
        We offer a wide variety of high-quality stationery products at affordable prices.
        Our commitment to fast delivery, excellent customer service, and exclusive deals
        makes us the preferred choice for students, artists, and professionals.
    </p>
</section>

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="#">About Us</a>
            <a href="#">Contact</a>
            <a href="#">Privacy Policy</a>
        </div>
        <p>&copy; 2025 Stationery Shop. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
