<?php
session_start();
require_once '../config/database.php';

/**
 * Save a new contact message to the database.
 */
function saveContactMessage($name, $email, $subject, $message) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $subject, $message]);
    } catch (\PDOException $e) {
        error_log("Save Contact Message Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: ../contact.php?error=empty_fields");
        exit;
    }

    if (saveContactMessage($name, $email, $subject, $message)) {
        header("Location: ../contact.php?success=sent");
    } else {
        header("Location: ../contact.php?error=failed");
    }
    exit;
}
?>
