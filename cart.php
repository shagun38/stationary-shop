<?php
session_start();
include "db_connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_qty'])) {
    $product_id = $_POST['product_id'];
    $new_qty = max(1, intval($_POST['quantity']));  // Ensure at least 1
    $_SESSION['cart'][$product_id] = $new_qty;
    header("Location: cart.php");
    exit();
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
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
    <h1>Your Cart</h1>
</section>


<section class="cart-items">

<?php
$total = 0;

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

    foreach ($_SESSION['cart'] as $product_id => $quantity) {

        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();

            $item_total = $product['price'] * $quantity;
            $total += $item_total;

            echo '<div class="cart-row">
                    <div class="cart-product">
                        <img src="'.$product['image'].'" alt="'.$product['name'].'">
                        <div>
                            <h3>'.$product['name'].'</h3>
                            <p>Price: ₹'.$product['price'].'</p>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="product_id" value="'.$product_id.'">
                                <input type="number" name="quantity" value="'.$quantity.'" min="1" style="width:60px;">
                                <button type="submit" name="update_qty">Update</button>
                            </form>
                            <a href="cart.php?remove='.$product_id.'" onclick="return confirm(\'Remove this item?\')" style="color:red; margin-left:10px;">Remove</a>
                        </div>
                    </div>
                    <div class="cart-total">
                        ₹'.$item_total.'
                    </div>
                </div>';
        }
    }

    echo '<section class="cart-summary">
            <p><strong>Subtotal:</strong> ₹'.$total.'</p>
            <a href="billing.php" class="btn">Proceed to Checkout</a>
        </section>';

} else {
    echo "<p>Your cart is empty.</p>";
}
?>

</section>


</body>
</html>