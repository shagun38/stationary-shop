<?php
include 'db.php';
session_start();

// Handle add category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_category'])) {
    $new_category = trim($_POST['new_category']);
    if (!empty($new_category)) {
        // Check if category already exists
        $check = $conn->query("SELECT DISTINCT category FROM products WHERE category = '$new_category'");
        if ($check->num_rows == 0) {
            // Insert a placeholder product to register category
            $sql = "INSERT INTO products (category, name, description, price, image) 
                    VALUES ('$new_category', 'Placeholder', 'Placeholder description', 0, 'placeholder.jpg')";
            $conn->query($sql);
        }
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

    <title>Categories - Admin Panel</title>
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
    <h2>Categories</h2>

    <form method="POST" action="" class="d-flex gap-2 mb-3">
        <input type="text" name="new_category" class="form-control" placeholder="New Category" required>
        <button type="submit" class="btn">Add Category</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $category = $row['category'];
                    echo "<tr>
                            <td>
                                <a href='category-products.php?category=" . urlencode($category) . "' class='action-link'>{$category}</a>
                            </td>
                            <td>
                                <a href='delete-category.php?category=".urlencode($category)."' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this category?')\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No categories found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
