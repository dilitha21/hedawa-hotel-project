<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=empty_fields");
        exit;
    }

    // Fetch user by email
    $stmt = $pdo->prepare("SELECT id, email, password_hash, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify user exists and password is correct
    if ($user && password_verify($password, $user['password_hash'])) {
        // Set Session Variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'staff') {
            header("Location: ../staff/dashboard.php");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        header("Location: ../login.php?error=invalid_credentials");
        exit;
    }
}
?>
