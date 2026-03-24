<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

// Fetch the newly added table/hall rooms
$rooms = $pdo->query("SELECT * FROM rooms WHERE name IN ('Dining Table', 'Reception Hall') AND is_available = 1")->fetchAll();
?>
<style>
    .space-card input[type="radio"]:checked + .card-content {
        border-color: var(--primary) !important;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    }
    .space-card:hover .card-content {
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }
</style>
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    <h2 style="margin-bottom: 2rem; color: var(--primary-dark);"> Make a Reservation</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <p style="color: red; margin-bottom: 1rem;">Failed to add reservation. Please try again.</p>
    <?php endif; ?>

    <div style="background: var(--white); padding: 2.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
        <p style="margin-bottom: 2rem; color: var(--text-muted);">Reserve a dining table for an intimate meal or a grand reception hall for your special events.</p>
        <form action="../actions/cart_process.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; align-items: end;">
            <input type="hidden" name="action" value="add_reservation">
            
            <div style="grid-column: 1 / -1; margin-bottom: 1rem;">
                <label style="display:block; margin-bottom: 1rem; color: var(--text-muted); font-weight: 600; font-size: 1.1rem;">Select Space:</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                    <?php foreach($rooms as $room): 
                        // Map specific image for Table and Hall
                        $img = $room['name'] === 'Dining Table' ? 'reserve_table.png' : 'reserve_hall.png';
                    ?>
                        <label class="space-card" style="cursor: pointer; position: relative; margin: 0;">
                            <input type="radio" name="room_id" value="<?= $room['id'] ?>" required style="position: absolute; opacity: 0; width: 0; height: 0;">
                            <div class="card-content" style="border: 2px solid #edf2f7; border-radius: var(--radius); overflow: hidden; background: var(--white); transition: all 0.3s ease;">
                                <img src="../assets/images/<?= $img ?>" alt="<?= htmlspecialchars($room['name']) ?>" style="width: 100%; height: 200px; object-fit: cover; display: block;">
                                <div style="padding: 1.5rem; text-align: center;">
                                    <h4 style="margin-bottom: 0.5rem; color: var(--text-main); font-size: 1.3rem; font-weight: 600;"><?= htmlspecialchars($room['name']) ?></h4>
                                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;"><?= htmlspecialchars($room['description']) ?></p>
                                    <span style="display: inline-block; background: var(--bg-color); color: var(--primary); font-weight: 600; font-size: 1.1rem; padding: 0.5rem 1rem; border-radius: 20px;">Fee: Rs. <?= number_format($room['price'], 2) ?></span>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted); font-weight: 500;"><i class="fa-regular fa-calendar" style="color:var(--primary-light);"></i> Date:</label>
                <input type="date" name="booking_date" required min="<?= date('Y-m-d') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted); font-weight: 500;"><i class="fa-regular fa-clock" style="color:var(--primary-light);"></i> Time:</label>
                <input type="time" name="booking_time" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted); font-weight: 500;"><i class="fa-solid fa-users" style="color:var(--primary-light);"></i> Guests:</label>
                <input type="number" name="guests" min="1" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div style="grid-column: 1 / -1; margin-top: 1rem;">
                <button type="submit" class="btn" style="width: 100%; padding: 1rem; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-cart-plus"></i> Add Reservation to Cart
                </button>
            </div>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
