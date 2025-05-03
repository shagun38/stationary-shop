<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<h2>Product List</h2>
<a href="add_product.php">Add New Product</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Category</th><th>Name</th><th>Price</th><th>Actions</th>
    </tr>

<?php
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($product = $result->fetch_assoc()) {
        echo '<tr>
            <td>'.$product['id'].'</td>
            <td>'.$product['category'].'</td>
            <td>'.$product['name'].'</td>
            <td>₹'.$product['price'].'</td>
            <td>
                <a href="edit_product.php?id='.$product['id'].'">Edit</a> |
                <a href="delete_product.php?id='.$product['id'].'" onclick="return confirm(\'Delete this product?\')">Delete</a>
            </td>
        </tr>';
    }
}
?>

</table>
