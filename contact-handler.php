<?php
include 'db.php'; // your db connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$name || !$email || !$message) {
        header("Location: contact.php?error=1");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        header("Location: contact.php?success=1");
    } else {
        header("Location: contact.php?error=1");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: contact.php");
    exit;
}
