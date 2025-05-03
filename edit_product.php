<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $conn->real_escape_string($_POST['category']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = (float) $_POST['price'];
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "UPDATE products 
            SET category='$category', name='$name', description='$description', price=$price, image='$image' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Edit Product</h2>
<form method="POST">
    <input type="text" name="category" value="<?php echo $product['category']; ?>" required><br>
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
    <textarea name="description"><?php echo $product['description']; ?></textarea><br>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br>
    <input type="text" name="image" value="<?php echo $product['image']; ?>" required><br>
    <button type="submit">Update Product</button>
</form>
