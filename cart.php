<?php
require_once 'includes/db_connect.php';
require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$res_cart = $_SESSION['reservation_cart'] ?? [];
$cart_total = 0;
?>

<h2>Your Cart</h2>

<?php if (empty($cart) && empty($res_cart)): ?>
    <div style="background: var(--white); padding: 3rem; text-align: center; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
        <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Your cart is empty.</p>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center;">
            <a href="pages/orders.php" class="btn">Browse Menu</a>
            <a href="pages/reservation.php" class="btn btn-outline">Make a Reservation</a>
        </div>
    </div>
<?php else: ?>
    <?php if(!empty($cart)): ?>
    <h3 style="margin-bottom: 1rem; color: var(--primary-dark);"><i class="fa-solid fa-utensils"></i> Food Orders</h3>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($cart as $item_id => $quantity): 
                $stmt = $pdo->prepare("SELECT name, price FROM food WHERE id = ?");
                $stmt->execute([$item_id]);
                $item = $stmt->fetch();
                if($item):
                    $subtotal = $item['price'] * $quantity;
                    $cart_total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $quantity ?></td>
                <td>Rs. <?= number_format($item['price'], 2) ?></td>
                <td>Rs. <?= number_format($subtotal, 2) ?></td>
                <td>
                    <form action="actions/cart_process.php" method="POST" style="display:inline; padding:0; box-shadow:none; margin:0;">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="item_id" value="<?= $item_id ?>">
                        <button type="submit" style="background:none; border:1px solid #e53e3e; color:#e53e3e; padding: 0.3rem 0.6rem; border-radius: 4px; cursor: pointer;">Remove</button>
                    </form>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if(!empty($res_cart)): ?>
    <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: var(--primary-dark);"><i class="fa-solid fa-calendar-check"></i> Reservations</h3>
    <table class="cart-table" style="margin-bottom: 2rem;">
        <thead>
            <tr>
                <th>Space</th>
                <th>Date & Time</th>
                <th>Guests</th>
                <th>Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($res_cart as $res_id => $res): 
                $stmt = $pdo->prepare("SELECT name, price FROM rooms WHERE id = ?");
                $stmt->execute([$res['room_id']]);
                $room = $stmt->fetch();
                if($room):
                    $cart_total += $room['price'];
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($room['name']) ?></strong></td>
                <td><?= htmlspecialchars($res['date']) ?> at <?= htmlspecialchars($res['time']) ?></td>
                <td><?= htmlspecialchars($res['guests']) ?> people</td>
                <td>Rs. <?= number_format($room['price'], 2) ?></td>
                <td>
                    <form action="actions/cart_process.php" method="POST" style="display:inline; padding:0; box-shadow:none; margin:0;">
                        <input type="hidden" name="action" value="remove_reservation">
                        <input type="hidden" name="res_id" value="<?= $res_id ?>">
                        <button type="submit" style="background:none; border:1px solid #e53e3e; color:#e53e3e; padding: 0.3rem 0.6rem; border-radius: 4px; cursor: pointer;">Remove</button>
                    </form>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
        <h3 style="margin: 0; color: var(--primary-dark);">Total: Rs. <?= number_format($cart_total, 2) ?></h3>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
