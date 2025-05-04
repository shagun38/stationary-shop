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
        unset($_SESSION['cart']);
        $orderPlaced = true;  // 👈 set the success flag
    } else {
        $error = "Error placing order: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stationery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo" ><a href="home.html" style="text-decoration: none;color: #333">Stationery Shop</a></div>

        <ul class="nav-links">
            <li><a href="product-category-writing.php">Writing Supplies</a></li>
            <li><a href="product-category-paper.php">Paper Products</a></li>
            <li><a href="product-category-art.php">Art & Craft</a></li>
            <li><a href="product-category-office.php">Office Essentials</a></li>
        </ul>

        <div class="nav-right">
            <input type="text" placeholder="Search..." class="search-box">
            <a href="login.php">Login</a>
            <a href="cart.php">Cart</a>
        </div>
    </nav>
</header>
<section class="cart-header">
    <h1>Checkout</h1>
</section>

<?php if ($orderPlaced): ?>

<section class="cart-items">
    <h3>Thank you for your purchase! Your order has been placed.</h3>
    <a href="home.html" class="btn mt-3">Continue Shopping</a>
</section>

<?php else: ?>

<section class="cart-items">
    <h3>Order Summary</h3>
    <?php
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        echo '<div class="cart-row">
                <div class="cart-product">
                    <strong>'.$item['name'].'</strong> x '.$item['quantity'].'
                </div>
                <div class="cart-total">₹'.$subtotal.'</div>
              </div>';
    }
    ?>
    <div class="cart-summary">
        <h3>Total: ₹<?php echo $total; ?></h3>
    </div>
</section>

<section class="checkout-form container mt-5">
    <h3>Billing Details</h3>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Your Name" required><br>
        <input type="text" name="address" placeholder="Address" required><br>
        <input type="tel" name="phone" placeholder="Phone Number" required><br>
        <input type="email" name="email" placeholder="Email Address" required><br>
        <button type="submit" class="btn mt-3">Place Order</button>
    </form>
</section>

<?php endif; ?>


</body>
</html>