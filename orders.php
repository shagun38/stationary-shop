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
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
</head>
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
    <h2>Orders</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM orders ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $orderId = $row['id'];
                    echo "<tr>
                        <td>{$orderId}</td>
                        <td>{$row['user_id']}</td>
                        <td>₹" . number_format($row['total'], 2) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . nl2br(htmlspecialchars($row['address'])) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>{$row['created_at']}</td>
                        <td><ul>";

                    // Fetch order items
                    $itemRes = $conn->query("SELECT * FROM order_items WHERE order_id = $orderId");
                    if ($itemRes && $itemRes->num_rows > 0) {
                        while ($item = $itemRes->fetch_assoc()) {
                            echo "<li>" . htmlspecialchars($item['product_name']) .
                                " × {$item['quantity']} (₹" . number_format($item['price'], 2) . " each)</li>";
                        }
                    } else {
                        echo "<li>No items found</li>";
                    }

                    echo "</ul></td></tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>

        </tbody>
    </table>

</div>

</body>
</html>
