<?php
session_start();
include 'db.php';

$query = $_GET['query'] ?? '';
$escaped = $conn->real_escape_string($query);

$sql = "SELECT * FROM products 
        WHERE name LIKE '%$escaped%' OR description LIKE '%$escaped%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Search Results - Stationery Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ✅ THEMED HEADER -->
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

<!-- ✅ SEARCH RESULTS -->
<div class="container mt-5">
    <h2 class="mb-4">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>"
                        alt="<?php echo htmlspecialchars($row['name']); ?>"
                        class="card-img-top object-fit-contain"
                        style="height: 180px; width: 100%; padding: 10px; object-fit: contain;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text small"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="fw-bold mb-2">₹<?php echo number_format($row['price'], 2); ?></p>
                            <form method="POST" action="cart-handler.php" class="mt-auto">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4">No products found matching your search.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
