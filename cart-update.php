<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "login_required";
    exit;
}



$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? 'add';

if (!$id) {
    http_response_code(400);
    echo "invalid";
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = ['quantity' => 0];
}

if ($action === 'add') {
    $_SESSION['cart'][$id]['quantity']++;
} elseif ($action === 'remove') {
    $_SESSION['cart'][$id]['quantity']--;
    if ($_SESSION['cart'][$id]['quantity'] <= 0) {
        unset($_SESSION['cart'][$id]);
    }
}

echo $_SESSION['cart'][$id]['quantity'] ?? 0;

