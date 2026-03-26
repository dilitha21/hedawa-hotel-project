<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth_check.php';

require_once 'includes/header.php';

$user_id = $_SESSION['user_id'];

// Get user info
$stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Get orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

// Get bookings
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<h2>My Profile</h2>
<p>Welcome back, <strong><?= htmlspecialchars($user['full_name']) ?></strong> (<?= htmlspecialchars($user['email']) ?>)</p>

<h3>My Orders</h3>
<?php if(empty($orders)): ?>
    <p>No past orders.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <?php foreach($orders as $order): ?>
        <tr>
            <td>#<?= $order['id'] ?></td>
            <td><?= $order['created_at'] ?></td>
            <td>Rs. <?= number_format($order['total_amount'], 2) ?></td>
            <td><?= ucfirst($order['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h3>My Bookings</h3>
<?php if(empty($bookings)): ?>
    <p>No bookings made.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Guests</th>
            <th>Status</th>
        </tr>
        <?php foreach($bookings as $book): ?>
        <tr>
            <td><?= $book['booking_date'] ?></td>
            <td><?= $book['booking_time'] ?></td>
            <td><?= $book['guests'] ?></td>
            <td><?= ucfirst($book['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
