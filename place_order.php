<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $total = (float) $_POST['total'];

    // Save order to database
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';

    $sql = "INSERT INTO orders (user_id, total, name, address, phone, email) 
            VALUES ($user_id, $total, '$name', '$address', '$phone', '$email')";


    if ($conn->query($sql) === TRUE) {
        // Clear the cart
        unset($_SESSION['cart']);
        echo "<h2>Thank you! Your order has been placed successfully.</h2>";
        echo '<a href="home.html">Return to Home</a>';
    } else {
        echo "Error placing order: " . $conn->error;
    }

} else {
    echo "Invalid request.";
}
?>
