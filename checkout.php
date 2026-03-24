<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth_check.php';

// Requires user to be logged in to checkout

require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$res_cart = $_SESSION['reservation_cart'] ?? [];
if(empty($cart) && empty($res_cart)) {
    echo "<p>Cart is empty. Redirecting to menu...</p>";
    header("Refresh: 2; url=pages/orders.php");
    exit;
}
?>

<h2>Checkout</h2>
<form action="actions/checkout_process.php" method="POST">
    <label>Mobile Number:</label>
    <input type="text" name="delivery_address" placeholder="e.g. 0771234567" required style="width: 100%; padding: 0.8rem; margin-top: 0.5rem; margin-bottom: 1rem;">
    
    <h3>Payment Details</h3>
    <br>
    <button type="submit" class="btn">Confirm Order</button>
</form>

<?php require_once 'includes/footer.php'; ?>
