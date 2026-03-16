<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

// Fetch Pending Bookings
$stmtBookings = $pdo->prepare("SELECT b.*, r.name as room_name FROM bookings b LEFT JOIN rooms r ON b.room_id = r.id WHERE b.user_id = ? AND b.status = 'pending'");
$stmtBookings->execute([$user_id]);
$pending_bookings = $stmtBookings->fetchAll();

// Fetch Pending Orders built from DB
$stmtOrders = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'pending'");
$stmtOrders->execute([$user_id]);
$pending_orders = $stmtOrders->fetchAll();
?>
<div style="max-width: 1000px; margin: 0 auto;">
    
    <h2>Shopping Cart (Unordered Food)</h2>
    <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
        <?php if(empty($cart)): ?>
            <p style="color: var(--text-muted);">Your food cart is empty.</p>
            <a href="orders.php" class="btn" style="margin-top: 1rem;">Browse Menu</a>
        <?php else: ?>
            <table style="width: 100%; text-align: left; margin-bottom: 2rem; border-collapse: collapse;">
                <tr style="border-bottom: 2px solid #edf2f7; color: var(--text-muted);">
                    <th style="padding:1rem 0;">Item Name</th>
                    <th style="text-align: center;">Price</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Action</th>
                </tr>
                <?php 
                $cart_total = 0;
                foreach($cart as $id => $qty): 
                    $stmtF = $pdo->prepare("SELECT name, price FROM food WHERE id = ?");
                    $stmtF->execute([$id]);
                    $foodData = $stmtF->fetch();
                    if($foodData) {
                        $cart_total += ($foodData['price'] * $qty);
                    }
                ?>
                <tr style="border-bottom: 1px solid #edf2f7;">
                    <td style="padding: 1rem 0; font-weight: 500;"><?= htmlspecialchars($foodData['name']) ?></td>
                    <td style="text-align: center; color: var(--text-muted);">$<?= number_format($foodData['price'], 2) ?></td>
                    <td style="text-align: center; font-weight: 600;"><?= $qty ?></td>
                    <td style="text-align: right;">
                        <form action="../actions/cart_process.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="item_id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-outline" style="padding:0.3rem 0.8rem; font-size:0.85rem; color: #e53e3e; border-color: #e53e3e;">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right; padding: 1rem 1rem 1rem 0; font-weight: 600; font-size: 1.1rem;">Estimated Total:</td>
                    <td style="text-align: right; font-weight: 700; font-size: 1.2rem; color: var(--primary);">$<?= number_format($cart_total, 2) ?></td>
                </tr>
            </table>

            <h4 style="margin-bottom: 1rem;">Complete Checkout</h4>
            <form action="../actions/order_process.php" method="POST" style="background: var(--bg-color); padding: 1.5rem; border-radius: var(--radius);">
                <input type="hidden" name="action" value="add">
                <label style="display:block; margin-bottom:0.5rem; color: var(--text-main); font-weight: 500;">Delivery Address / Table Number:</label>
                <textarea name="delivery_address" required rows="3" placeholder="E.g., Delivered to Room 42, or Home Address..." style="width: 100%; padding:0.8rem; border:1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family); resize: vertical; margin-bottom: 1rem;"></textarea>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn" style="padding: 0.8rem 2rem; font-size: 1rem;"><i class="fa-solid fa-check"></i> Place Food Order</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Unified display matching "Cart must show bookings and orders" -->
    <h2 style="margin-bottom: 1.5rem; border-bottom: 2px solid var(--primary-light); padding-bottom: 0.5rem;">Cart Overview (Processing)</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Active Pending Bookings -->
        <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-top: 4px solid var(--accent);">
            <h3 style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-bed" style="color:var(--primary);"></i> Pending Bookings</h3>
            <?php if(empty($pending_bookings)): ?>
                <p style="color: var(--text-muted); margin-top: 1rem;">No awaiting bookings.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin-top: 1rem;">
                <?php foreach($pending_bookings as $pb): ?>
                    <li style="padding: 1rem 0; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-weight: 600; color: var(--text-main); display: block; margin-bottom: 0.2rem;"><?= htmlspecialchars($pb['room_name'] ?? 'Table Booking') ?></span>
                            <span style="color: var(--text-muted); font-size: 0.9rem;">
                                <i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($pb['booking_date']) ?> &nbsp;
                                <i class="fa-regular fa-clock"></i> <?= htmlspecialchars($pb['booking_time']) ?> &nbsp;
                                <i class="fa-solid fa-users"></i> <?= $pb['guests'] ?>
                            </span>
                        </div>
                        <form action="../actions/booking_process.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="booking_id" value="<?= $pb['id'] ?>">
                            <button type="submit" class="btn btn-outline" style="padding:0.3rem 0.8rem; font-size:0.85rem; color: #e53e3e; border-color: #e53e3e;" onclick="return confirm('Remove this booking?');">Cancel Booking</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Active Pending Orders -->
        <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-top: 4px solid var(--accent);">
            <h3 style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-utensils" style="color:var(--primary);"></i> Pending Kitchen Orders</h3>
            <?php if(empty($pending_orders)): ?>
                <p style="color: var(--text-muted); margin-top: 1rem;">No processed orders waiting.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin-top: 1rem;">
                <?php foreach($pending_orders as $po): ?>
                    <li style="padding: 1rem 0; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-weight: 600; color: var(--text-main); display: block; margin-bottom: 0.2rem;">Order #<?= $po['id'] ?></span>
                            <span style="color: var(--text-muted); font-size: 0.85rem;"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars(substr($po['delivery_address'], 0, 20)).'...' ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="color: var(--primary); font-weight: 700; font-size: 1.1rem;">Rs. <?= number_format($po['total_amount'], 2) ?></span>
                            <form action="../actions/order_process.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="order_id" value="<?= $po['id'] ?>">
                                <button type="submit" class="btn btn-outline" style="padding:0.3rem 0.8rem; font-size:0.85rem; color: #e53e3e; border-color: #e53e3e;" onclick="return confirm('Cancel this order?');">Cancel Order</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
