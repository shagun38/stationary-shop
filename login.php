<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: billing.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
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
    <h1>Login</h1>
</section>

<section class="login-form">

    <form action="#" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>

</section>



</body>
</html>
