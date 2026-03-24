<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];
$rooms = $pdo->query("SELECT * FROM rooms WHERE name NOT IN ('Dining Table', 'Reception Hall') AND is_available = 1")->fetchAll();
?>
<style>
    .room-card input[type="radio"]:checked + .card-content {
        border-color: var(--primary) !important;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    }
    .room-card:hover .card-content {
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }
</style>
<div style="max-width: 900px; margin: 0 auto;">
    <h2>Book a Room</h2>
    <?php if(isset($_GET['error'])): ?>
        <p style="color: red; margin-bottom: 1rem;">Failed to add booking. Please try again.</p>
    <?php endif; ?>

    <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
        <form action="../actions/booking_process.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: end;">
            <input type="hidden" name="action" value="add">
            
            <div style="grid-column: 1 / -1; margin-bottom: 1rem;">
                <label style="display:block; margin-bottom: 1rem; color: var(--text-muted); font-weight: 600; font-size: 1.1rem;">Select Room:</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <?php foreach($rooms as $room): ?>
                        <label class="room-card" style="cursor: pointer; position: relative; margin: 0;">
                            <input type="radio" name="room_id" value="<?= $room['id'] ?>" required style="position: absolute; opacity: 0; width: 0; height: 0;">
                            <div class="card-content" style="border: 2px solid #ddd; border-radius: var(--radius); overflow: hidden; background: var(--white); transition: all 0.3s ease;">
                                <img src="../assets/images/room_<?= $room['id'] ?>.png" alt="<?= htmlspecialchars($room['name']) ?>" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                                <div style="padding: 1.2rem; text-align: center;">
                                    <h4 style="margin-bottom: 0.5rem; color: var(--text-main); font-size: 1.2rem;"><?= htmlspecialchars($room['name']) ?></h4>
                                    <span style="color: var(--primary); font-weight: 600; font-size: 1.1rem;">Rs. <?= number_format($room['price'], 2) ?></span>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted);">Date:</label>
                <input type="date" name="booking_date" required min="<?= date('Y-m-d') ?>" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted);">Time:</label>
                <input type="time" name="booking_time" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.5rem; color: var(--text-muted);">Guests:</label>
                <input type="number" name="guests" min="1" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
            </div>
            
            <div>
                <button type="submit" class="btn" style="width: 100%; padding: 0.8rem;">Add Booking</button>
            </div>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
