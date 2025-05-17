<?php
include "db.php";
session_start();


$category = "Art & Craft";

$sql = "SELECT * FROM products WHERE category = '$category'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Your one-stop Stationery Shop for writing supplies, paper products, art & craft materials, and office essentials. Best prices and fast delivery.">
    <meta name="keywords" content="stationery, writing supplies, paper, office, art, craft, shop online">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <title>Stationery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
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
<section class="category-header">
    <h1>Art & Craft</h1>
    <p>Unleash your creativity with our wide range of art and craft supplies.</p>
</section>
<section class="product-list">
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productId = $row['id'];
        $quantity = $_SESSION['cart'][$productId]['quantity'] ?? 0;

        echo '<div class="product-row">
                <div class="product-image">
                    <img src="' . $row['image'] . '" alt="' . $row['name'] . '">
                </div>
                <div class="product-details">
                    <h3>' . $row['name'] . '</h3>
                    <p>' . $row['description'] . '</p>
                    <p class="price">₹' . $row['price'] . '</p>
                </div>
                <div class="product-action">';

        if ($quantity > 0) {
            echo "<div class='qty-controls'>
                    <form method='POST' action='cart-handler.php'>
                        <input type='hidden' name='id' value='{$productId}'>
                        <input type='hidden' name='action' value='remove'>
                        <button class='qty-btn'>−</button>
                    </form>
                    <span class='qty-display'>{$quantity}</span>
                    <form method='POST' action='cart-handler.php'>
                        <input type='hidden' name='id' value='{$productId}'>
                        <input type='hidden' name='action' value='add'>
                        <button class='qty-btn'>+</button>
                    </form>
                </div>";
        } else {
            echo "<form method='POST' action='cart-handler.php'>
                    <input type='hidden' name='id' value='{$productId}'>
                    <input type='hidden' name='name' value=\"{$row['name']}\">
                    <input type='hidden' name='price' value='{$row['price']}'>
                    <input type='hidden' name='quantity' value='1'>
                    <button type='submit' class='btn btn-success'>Add to Cart</button>
                </form>";
        }

        echo '</div></div>';

    }
} else {
    echo "<p>No products found.</p>";
}
?>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>