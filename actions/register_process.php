<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($fullName) || empty($email) || empty($password)) {
        header("Location: ../register.php?error=empty_fields");
        exit;
    }

    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    try {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
        if ($stmt->execute([$fullName, $email, $hashedPassword])) {
            header("Location: ../login.php?success=registered");
            exit;
        } else {
            header("Location: ../register.php?error=registration_failed");
            exit;
        }
    } catch (\PDOException $e) {
        // Typically hits here if email already exists
        header("Location: ../register.php?error=email_taken");
        exit;
    }
}
?>
