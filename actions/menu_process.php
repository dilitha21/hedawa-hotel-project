<?php
require_once '../config/database.php';
require_once '../includes/staff_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = (float)$_POST['price'];
        $category = trim($_POST['category']);
        $is_available = isset($_POST['is_available']) ? 1 : 0;

        if (empty($name) || $price < 0) {
            header("Location: ../staff/manage_menu.php?err=invalid_data");
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO food (name, description, price, category, is_available) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $category, $is_available]);
            header("Location: ../staff/manage_menu.php?msg=added");
        } catch(PDOException $e) {
            header("Location: ../staff/manage_menu.php?err=db_error");
        }
    } 
    elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = (float)$_POST['price'];
        $category = trim($_POST['category']);
        $is_available = isset($_POST['is_available']) ? 1 : 0;

        if (empty($name) || $price < 0) {
            header("Location: ../staff/manage_menu.php?err=invalid_data");
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE food SET name=?, description=?, price=?, category=?, is_available=? WHERE id=?");
            $stmt->execute([$name, $description, $price, $category, $is_available, $id]);
            header("Location: ../staff/manage_menu.php?msg=updated");
        } catch(PDOException $e) {
            header("Location: ../staff/manage_menu.php?err=db_error");
        }
    }
    elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        try {
            // Because order_items references this with ON DELETE CASCADE,
            // deleting a food item might also delete all order items associated with it!
            // Usually we softly delete or make unavailable. Let's just make it unavailable instead of hard delete to save history.
            $stmt = $pdo->prepare("UPDATE food SET is_available = 0 WHERE id=?");
            $stmt->execute([$id]);
            header("Location: ../staff/manage_menu.php?msg=disabled");
        } catch(PDOException $e) {
            header("Location: ../staff/manage_menu.php?err=db_error");
        }
    }
}
