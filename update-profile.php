<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$sql = "UPDATE users SET 
            name = '$name',
            email = '$email',
            phone = '$phone',
            address = '$address'
        WHERE id = $userId";

if ($conn->query($sql)) {
    $_SESSION['user_name'] = $name;
    header("Location: user-dashboard.php?updated=1");
} else {
    echo "Error updating profile: " . $conn->error;
}
