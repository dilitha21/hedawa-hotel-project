<?php
session_start();
require_once '../includes/db_connect.php';

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$item_id = $_POST['item_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if($action === 'add' && $item_id) {
    if(isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }
    
    // Check if it's an AJAX request
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => true]);
        exit;
    }
    
    // Redirect if it's standard form submission
    header('Location: ../pages/orders.php');
    exit;
}

if($action === 'remove' && $item_id) {
    unset($_SESSION['cart'][$item_id]);
    header('Location: ../cart.php');
    exit;
}

if($action === 'clear') {
    $_SESSION['cart'] = [];
    $_SESSION['reservation_cart'] = [];
    header('Location: ../cart.php');
    exit;
}

if($action === 'add_reservation') {
    if(!isset($_SESSION['reservation_cart'])) {
        $_SESSION['reservation_cart'] = [];
    }
    
    $room_id = $_POST['room_id'] ?? 0;
    if($room_id) {
        $res_id = uniqid('res_');
        $_SESSION['reservation_cart'][$res_id] = [
            'room_id' => $room_id,
            'date' => $_POST['booking_date'],
            'time' => $_POST['booking_time'],
            'guests' => $_POST['guests']
        ];
    }
    header('Location: ../cart.php?success=reservation_added');
    exit;
}

if($action === 'remove_reservation') {
    $res_id = $_POST['res_id'] ?? '';
    if(isset($_SESSION['reservation_cart'][$res_id])) {
        unset($_SESSION['reservation_cart'][$res_id]);
    }
    header('Location: ../cart.php');
    exit;
}
