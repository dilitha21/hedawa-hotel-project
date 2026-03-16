<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth_check.php';

// Requires user to be logged in to checkout

require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if(empty($cart)) {
    echo "<p>Cart is empty. Redirecting to menu...</p>";
    header("Refresh: 2; url=pages/orders.php");
    exit;
}
?>

<h2>Checkout</h2>
<form action="actions/checkout_process.php" method="POST">
    <label>Delivery Address:</label>
    <textarea name="delivery_address" required></textarea>
    
    <h3>Payment Details</h3>
    <br>
    <button type="submit" class="btn">Confirm Order</button>
</form>

<?php require_once 'includes/footer.php'; ?>
