<?php
include 'db.php';

// Get product ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Product ID not provided.");
}

// Fetch current product data
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $update_sql = "UPDATE products SET 
                    category = '$category', 
                    name = '$name', 
                    description = '$description', 
                    price = '$price', 
                    image = '$image'
                    WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
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
    <h2>Edit Product</h2>
    <form method="POST" action="">

    <div class="mb-3">
        <label>Category</label>
        <select name="category" class="form-control" required>
            <option value="">Select a Category</option>
            <?php
            $cat_sql = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''";
            $cat_result = $conn->query($cat_sql);

            while($cat_row = $cat_result->fetch_assoc()) {
                echo "<option value='{$cat_row['category']}'>{$cat_row['category']}</option>";
            }
            ?>
        </select>
    </div>


        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?php echo $product['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" value="<?php echo $product['image']; ?>" required>
        </div>

        <button type="submit" class="btn">Update Product</button>
    </form>
</div>

</body>
</html>
