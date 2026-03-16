<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];
$foods = $pdo->query("SELECT * FROM food WHERE is_available = 1")->fetchAll();
?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Food Menu</h2>
    <a href="cart.php" class="btn btn-outline"><i class="fa-solid fa-cart-shopping"></i> View Cart</a>
</div>

<?php if(isset($_GET['error'])): ?>
    <p style="color:red; margin-bottom: 1rem;">Failed to process order request.</p>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
    <?php foreach($foods as $food): ?>
    <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; overflow: hidden;">
        <img src="../assets/images/<?= $food['id'] ?>.png" alt="<?= htmlspecialchars($food['name']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid #eee;">
        <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
            <h3 style="color: var(--primary-dark); margin-bottom: 0.5rem; font-size: 1.2rem;"><?= htmlspecialchars($food['name']) ?></h3>
        <span style="font-size: 0.8rem; background: var(--bg-color); color: var(--primary); padding: 0.2rem 0.6rem; border-radius: 4px; margin-bottom: 0.5rem; display: inline-block; width: fit-content;"><?= htmlspecialchars($food['category']) ?></span>
        
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem; flex: 1;"><?= htmlspecialchars($food['description']) ?></p>
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #edf2f7; padding-top: 1rem;">
            <span style="font-weight: 600; font-size: 1.25rem; color: var(--text-main);">Rs. <?= number_format($food['price'], 2) ?></span>
            <form action="../actions/cart_process.php" method="POST" style="margin: 0; display: flex; gap: 0.5rem; align-items: center;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="item_id" value="<?= $food['id'] ?>">
                <input type="number" name="quantity" value="1" min="1" max="20" style="width: 50px; padding: 0.4rem; border: 1px solid #ddd; border-radius: 4px;">
                <button type="button" class="btn add-to-cart" data-id="<?= $food['id'] ?>" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-plus"></i> Add</button>
            </form>
        </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script src="../assets/js/cart.js"></script>
<?php require_once '../includes/footer.php'; ?>
