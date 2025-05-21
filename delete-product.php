<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID not provided.");
}

$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
