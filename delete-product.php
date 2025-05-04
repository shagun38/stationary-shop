<?php
include 'db.php';

// Get product ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID not provided.");
}

// Delete the product
$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
