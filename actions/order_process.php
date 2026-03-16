<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

/**
 * Adds an order and its associated food items.
 */
function addOrder($userId, $deliveryAddress, $cartItems) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // 1. Calculate total and gather items safely
        $totalAmount = 0;
        $orderData = [];
        
        foreach ($cartItems as $foodId => $qty) {
            $stmt = $pdo->prepare("SELECT price FROM food WHERE id = ?");
            $stmt->execute([$foodId]);
            $food = $stmt->fetch();
            
            if ($food) {
                $totalAmount += ($food['price'] * $qty);
                $orderData[] = [
                    'food_id' => $foodId,
                    'qty' => $qty,
                    'price' => $food['price']
                ];
            }
        }
        
        // 2. Insert the main order
        $stmtOrder = $pdo->prepare("INSERT INTO orders (user_id, total_amount, delivery_address) VALUES (?, ?, ?)");
        $stmtOrder->execute([$userId, $totalAmount, $deliveryAddress]);
        $orderId = $pdo->lastInsertId();
        
        // 3. Insert order items
        $stmtItems = $pdo->prepare("INSERT INTO order_items (order_id, food_id, quantity, price_at_time) VALUES (?, ?, ?, ?)");
        foreach ($orderData as $data) {
            $stmtItems->execute([$orderId, $data['food_id'], $data['qty'], $data['price']]);
        }
        
        $pdo->commit();
        return $orderId;
        
    } catch (\Exception $e) {
        $pdo->rollBack();
        error_log("Add Order Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Deletes an order (staff only, or strictly bounded to customer).
 */
function deleteOrder($orderId, $userId = null) {
    global $pdo;
    try {
        if ($userId !== null) {
            $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
            return $stmt->execute([$orderId, $userId]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
            return $stmt->execute([$orderId]);
        }
    } catch (\PDOException $e) {
        error_log("Delete Order Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $address = $_POST['delivery_address'];
        $cart = $_SESSION['cart'] ?? [];
        
        if (empty($cart)) {
            header("Location: ../cart.php?error=empty");
            exit;
        }

        $orderId = addOrder($_SESSION['user_id'], $address, $cart);
        
        if ($orderId) {
            $_SESSION['cart'] = []; // Clear cart on success
            header("Location: ../pages/cart.php?success=ordered");
        } else {
            header("Location: ../pages/cart.php?error=failed");
        }
        exit;
    }
    
    if ($action === 'delete') {
        $orderId = $_POST['order_id'];
        
        if ($_SESSION['role'] === 'staff') {
            deleteOrder($orderId);
            header("Location: ../admin/orders.php?msg=deleted");
        } else {
            // Usually customers can only cancel, but here is delete logic as requested
            deleteOrder($orderId, $_SESSION['user_id']);
            header("Location: ../pages/cart.php?msg=deleted");
        }
        exit;
    }
}
?>
