<?php
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. <a href='login.php'>Login here</a>.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stationery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo" ><a href="home.html" style="text-decoration: none;color: #333">Stationery Shop</a></div>

        <ul class="nav-links">
            <li><a href="product-category-writing.php">Writing Supplies</a></li>
            <li><a href="product-category-paper.php">Paper Products</a></li>
            <li><a href="product-category-art.php">Art & Craft</a></li>
            <li><a href="product-category-office.php">Office Essentials</a></li>
        </ul>

        <div class="nav-right">
            <input type="text" placeholder="Search..." class="search-box">
            <a href="login.php">Login</a>
            <a href="cart.php">Cart</a>
        </div>
    </nav>
</header>

<section class="login-header">
    <h1>Create an Account</h1>
</section>

<section class="login-form">

    <form action="#" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" class="btn">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

</section>

</body>
</html>