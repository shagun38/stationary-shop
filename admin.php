<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Your one-stop Stationery Shop for writing supplies, paper products, art & craft materials, and office essentials. Best prices and fast delivery.">
    <meta name="keywords" content="stationery, writing supplies, paper, office, art, craft, shop online">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <title>Admin Dashboard - Stationery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo"><a href="admin.php" style="text-decoration: none; color: #333;">Stationery Shop Admin</a></div>
        <ul class="nav-links">
            <li><a href="products.php">Products</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>
    </nav>
</header>

<div class="container mt-5">
    <h1>Welcome to Admin Dashboard</h1>
    <p>Manage your products, categories, and orders with ease.</p><br><br>

    <div class="d-flex justify-content-center gap-5 flex-wrap mt-4">
        <div class="card p-3" style="width: 250px;">
            <h3>Products</h3>
            <p>Add, edit, or remove products.</p><br>
            <a href="products.php" class="btn">Manage Products</a>
        </div>
        <div class="card p-3" style="width: 250px;">
            <h3>Categories</h3>
            <p>Add, edit, or remove categories.</p>
            <a href="categories.php" class="btn">Manage Categories</a>
        </div>
        <div class="card p-3" style="width: 250px;">
            <h3>Orders</h3>
            <p>View and manage customer orders.</p>
            <a href="orders.php" class="btn">View Orders</a>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a href="http://localhost/stationary-shop/home.php" class="btn btn-secondary">Return to Home</a>
    </div>
</div>

</body>
</html>
