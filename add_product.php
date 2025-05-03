<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $conn->real_escape_string($_POST['category']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = (float) $_POST['price'];
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "INSERT INTO products (category, name, description, price, image) 
            VALUES ('$category', '$name', '$description', $price, '$image')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add New Product</h2>
<form method="POST">
    <input type="text" name="category" placeholder="Category" required><br>
    <input type="text" name="name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="text" name="image" placeholder="Image path (e.g., images/pen1.jpg)" required><br>
    <button type="submit">Add Product</button>
</form>
