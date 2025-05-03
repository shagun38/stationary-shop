<?php
session_start();
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>All Orders</h1>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Total</th>
        <th>Created At</th>
    </tr>

<?php
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($order = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$order['id'].'</td>
                <td>'.$order['user_id'].'</td>
                <td>'.$order['name'].'</td>
                <td>'.$order['address'].'</td>
                <td>'.$order['phone'].'</td>
                <td>'.$order['email'].'</td>
                <td>₹'.$order['total'].'</td>
                <td>'.$order['created_at'].'</td>
            </tr>';
    }
} else {
    echo '<tr><td colspan="8">No orders found.</td></tr>';
}
?>

</table>

</body>
</html>
