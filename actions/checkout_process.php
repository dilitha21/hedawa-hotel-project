<?php
session_start();
require_once '../includes/db_connect.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$res_cart = $_SESSION['reservation_cart'] ?? [];

if(empty($cart) && empty($res_cart)) {
    header('Location: ../index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_address = trim($_POST['delivery_address']);
    $user_id = $_SESSION['user_id'];
    
    $cart = $_SESSION['cart'];
    $total_amount = 0;
    
    // Calculate accurate total from DB
    $items_data = [];
    foreach($cart as $item_id => $qty) {
        $stmt = $pdo->prepare("SELECT price FROM food WHERE id = ? AND is_available = 1");
        $stmt->execute([$item_id]);
        $item = $stmt->fetch();
        if($item) {
            $total_amount += ($item['price'] * $qty);
            $items_data[] = ['id' => $item_id, 'qty' => $qty, 'price' => $item['price']];
        }
    }
    
    // Create order
    $pdo->beginTransaction();
    try {
        // Create order if food is present
        if(!empty($items_data)) {
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, delivery_address) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $total_amount, $delivery_address]);
            $order_id = $pdo->lastInsertId();
            
            // Create order items
            $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, food_id, quantity, price_at_time) VALUES (?, ?, ?, ?)");
            foreach($items_data as $data) {
                $stmt_item->execute([$order_id, $data['id'], $data['qty'], $data['price']]);
            }
        }
        
        // Handle reservations
        if(!empty($res_cart)) {
            $stmt_book = $pdo->prepare("INSERT INTO bookings (user_id, room_id, booking_date, booking_time, guests) VALUES (?, ?, ?, ?, ?)");
            foreach($res_cart as $res) {
                $stmt_book->execute([$user_id, $res['room_id'], $res['date'], $res['time'], $res['guests']]);
            }
        }
        
        $pdo->commit();
        
        // Clear carts
        $_SESSION['cart'] = [];
        $_SESSION['reservation_cart'] = [];
        header('Location: ../profile.php?success=checkout_complete');
    } catch (\Exception $e) {
        $pdo->rollBack();
        die("<h2>Checkout failed</h2><p>Database Error: " . htmlspecialchars($e->getMessage()) . "</p>");
    }
}
