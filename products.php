<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="Your one-stop Stationery Shop for writing supplies, paper products, art & craft materials, and office essentials. Best prices and fast delivery.">
<meta name="keywords" content="stationery, writing supplies, paper, office, art, craft, shop online">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Stationery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
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
    <h2>Products</h2>
    <a href="add-product.php" class="btn mb-3">Add New Product</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price (₹)</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = $sql = "SELECT * FROM products";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['category']}</td>

                        <td><img src='{$row['image']}' alt='{$row['name']}' style='max-height:50px;'></td>
                        <td>
                            <a class='action-link' href='edit-product.php?id={$row['id']}'>Edit</a>
                            <a class='action-link' href='delete-product.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this product?')\">Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
