<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity']
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if item already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $item['id']) {
            $cart_item['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }
}
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
<nav class="navbar navbar-expand-lg bg-white border-bottom px-3">
  <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">


    <a class="navbar-brand fw-bold" href="home.php" style="color: #333;">Stationery Shop</a>

    <div class="collapse navbar-collapse justify-content-center" id="navCategories">
    <ul class="navbar-nav mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="product-category-writing.php">Writing Supplies</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-paper.php">Paper Products</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-art.php">Art & Craft</a></li>
      <li class="nav-item"><a class="nav-link" href="product-category-office.php">Office Essentials</a></li>
    </ul>
  </div>

    <div class="d-flex align-items-center gap-3 flex-wrap">


      <form method="GET" action="search.php" class="d-flex">
        <input class="form-control" type="search" name="query" placeholder="Search..." required>
      </form>

      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="admin.php" class="btn btn-warning btn-sm">Admin Panel</a>
      <?php endif; ?>


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
        <a href="login.php" title="Login" aria-label="Login">
          <img src="images/user-icon.ico" alt="Login" width="28" height="28">
        </a>
      <?php endif; ?>


      <a href="cart.php" class="position-relative" title="Cart" aria-label="View Cart">
        <img src="images/cart-icon.ico" alt="Cart" width="28" height="28">
        <?php if (!empty($_SESSION['cart'])): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>
          </span>
        <?php endif; ?>
      </a>


      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCategories"
              aria-controls="navCategories" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </div>
</nav>
</header>
<section class="cart-header">
    <h1>Your Cart</h1>
</section>

<section class="cart-items">
<?php
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
} else {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo '<div class="cart-row mb-2 p-2 border rounded bg-light d-flex justify-content-between align-items-center">
                <div>
                    <strong>'.$item['name'].'</strong><br>
                    ₹'.$item['price'].' x '.$item['quantity'].'
                </div>
                <div>
                    ₹'.$subtotal.'
                </div>
            </div>';
    }

    echo '<div class="cart-summary text-end mt-4">
            <h3>Total: ₹'.$total.'</h3>
            <div class="d-flex gap-3 justify-content-end">
                <a href="billing.php" class="btn">Proceed to Checkout</a>
                <a href="home.php" class="btn btn-secondary">Return to Home</a>
            </div>
          </div>';
}
?>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>