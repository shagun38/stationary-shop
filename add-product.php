<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql = "INSERT INTO products (category, name, description, price, image) 
            VALUES ('$category', '$name', '$description', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
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

    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
    <h2>Add New Product</h2>
    <form method="POST" action="">

        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <?php
                $cat_sql = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''";
                $cat_result = $conn->query($cat_sql);

                while($cat_row = $cat_result->fetch_assoc()) {
                    $selected = ($product['category'] == $cat_row['category']) ? "selected" : "";
                    echo "<option value='{$cat_row['category']}' $selected>{$cat_row['category']}</option>";
                }
                ?>
            </select>
        </div>



        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn">Add Product</button>
    </form>
</div>

</body>
</html>
