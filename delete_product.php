<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_products.php");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
