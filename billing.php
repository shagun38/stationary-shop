<?php
session_start();
include 'db.php';

$orderPlaced = false; // 👈 flag for success

// Calculate total
$total = 0;
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='home.php'>Go back to shop</a></p>";
    exit();
}
foreach ($_SESSION['cart'] as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "NULL";

    $sql = "INSERT INTO orders (user_id, total, name, address, phone, email) 
            VALUES ($user_id, '$total', '$name', '$address', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;  // get the new order's ID

        // Insert each cart item into order_items table
        foreach ($_SESSION['cart'] as $item) {
            $name = $conn->real_escape_string($item['name']);
            $qty = (int)$item['quantity'];
            $price = (float)$item['price'];

            $conn->query("INSERT INTO order_items (order_id, product_name, quantity, price) 
                        VALUES ($order_id, '$name', $qty, $price)");
        }

        unset($_SESSION['cart']);
        $orderPlaced = true;
    }
 else {
        $error = "Error placing order: " . $conn->error;
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
    <nav class="navbar">
        <div class="logo"><a href="home.php" style="text-decoration: none; color: #333;">Stationery Shop</a></div>

        <ul class="nav-links">
            <li><a href="product-category-writing.php">Writing Supplies</a></li>
            <li><a href="product-category-paper.php">Paper Products</a></li>
            <li><a href="product-category-art.php">Art & Craft</a></li>
            <li><a href="product-category-office.php">Office Essentials</a></li>
        </ul>

        <div class="nav-right">
            <input type="text" placeholder="Search..." class="search-box">
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
            <img src="images/user-icon.ico" alt="User" width="32" height="32"
                class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
<section class="cart-header">
    <h1>Checkout</h1>
</section>

<?php if ($orderPlaced): ?>

<section class="cart-items">
    <h3>Thank you for your purchase! Your order has been placed.</h3>
    <a href="home.php" class="btn mt-3">Continue Shopping</a>
</section>

<?php else: ?>

<?php
$billingName = '';
$billingAddress = '';
$billingPhone = '';
$billingEmail = '';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $res = $conn->query("SELECT * FROM users WHERE id = $userId");
    if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $billingName = $user['name'] ?? '';
        $billingAddress = $user['address'] ?? '';
        $billingPhone = $user['phone'] ?? '';
        $billingEmail = $user['email'] ?? '';
    }
}
?>

<section class="cart-items">
    <h3>Order Summary</h3>
    <?php
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        echo '<div class="cart-row">
                <div class="cart-product">
                    <strong>' . htmlspecialchars($item['name']) . '</strong> x ' . (int)$item['quantity'] . '
                </div>
                <div class="cart-total">₹' . number_format($subtotal, 2) . '</div>
              </div>';
    }
    ?>
    <div class="cart-summary">
        <h3>Total: ₹<?php echo number_format($total, 2); ?></h3>
    </div>
</section>

<section class="checkout-form container mt-5">
    <h3>Billing Details</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" value="<?php echo htmlspecialchars($billingName); ?>" required>
        </div>
        <div class="mb-3">
            <input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo htmlspecialchars($billingAddress); ?>" required>
        </div>
        <div class="mb-3">
            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" value="<?php echo htmlspecialchars($billingPhone); ?>" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php echo htmlspecialchars($billingEmail); ?>" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Place Order</button>
    </form>
</section>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>