<?php
include "db.php";

$category = "Paper Products";

$sql = "SELECT * FROM products WHERE category = '$category'";
$result = $conn->query($sql);

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

<section class="category-header">
    <h1>Paper Products</h1>
    <p>High-quality paper products for all your writing and printing needs.</p>
</section>
<section class="product-list">
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="product-row">
                <div class="product-image">
                    <img src="'.$row['image'].'" alt="'.$row['name'].'">
                </div>
                <div class="product-details">
                    <h3>'.$row['name'].'</h3>
                    <p>'.$row['description'].'</p>
                    <p class="price">₹'.$row['price'].'</p>
                </div>
                 <div class="product-action">
                   <div class="product-action">
                    <form method="POST" action="cart.php" class="add-to-cart-form">
                        <input type="hidden" name="id" value="'.$row['id'].'">
                        <input type="hidden" name="name" value="'.$row['name'].'">
                        <input type="hidden" name="price" value="'.$row['price'].'">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                    </div>
                </div>
            </div>';
    }
} else {
    echo "<p>No products found.</p>";
}
?>
</section>
</body>
</html>