<?php
require_once 'includes/db_connect.php';
require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$cart_total = 0;
?>

<h2>Your Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty. <a href="pages/orders.php">Browse Menu</a></p>
<?php else: ?>
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
            $cart_total = 0;
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
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <form action="actions/cart_process.php" method="POST" style="display:inline; padding:0; box-shadow:none; margin:0;">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="item_id" value="<?= $item_id ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total:</th>
                <th colspan="2">$<?= number_format($cart_total, 2) ?></th>
            </tr>
        </tfoot>
    </table>
    
    <div class="cart-summary">
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
