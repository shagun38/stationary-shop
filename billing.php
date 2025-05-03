<?php
session_start();
include "db_connect.php";
$name = "";
$email = "";
$address = "";
$phone = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        // If later you add address and phone to users table, you can auto-fill them too.
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
<section class="checkout-header">
    <h1>Checkout</h1>
</section>

<section class="checkout-form">

<?php
$total = 0;

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total += $product['price'] * $quantity;
        }
    }
} else {
    echo "<p>Your cart is empty. Please add some products before checking out.</p>";
    exit();
}
?>

<form action="place_order.php" method="POST">
    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Full Name" required>
    <input type="text" name="address" placeholder="Address" required>
    <input type="tel" name="phone" placeholder="Phone Number" required>
    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required>


    <p><strong>Total Amount:</strong> ₹<?php echo $total; ?></p>

    <input type="hidden" name="total" value="<?php echo $total; ?>">

    <button type="submit" class="btn">Place Order</button>
</form>

</section>


</body>
</html>