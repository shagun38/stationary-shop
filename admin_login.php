<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple hardcoded login
    if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['admin'] = true;
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Invalid admin login.";
    }
}
?>
<html>


<h2>Admin Login</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Admin Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

</html>