<?php
require_once '../config/database.php';
require_once '../includes/staff_check.php';
require_once '../includes/header.php';

$orders = $pdo->query("SELECT o.*, u.full_name, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll();
?>
<div class="staff-container" style="display: flex; min-height: calc(100vh - 80px - 200px); background: #f8fafc;">
    
    <!-- Sidebar -->
    <aside style="width: 250px; background: var(--white); box-shadow: var(--shadow-sm); padding: 2rem 0;">
        <h3 style="text-align: center; color: var(--primary-dark); margin-bottom: 2rem; border-bottom: 1px solid #edf2f7; padding-bottom: 1rem;">Staff Control</h3>
        <ul style="list-style: none;">
            <li><a href="dashboard.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="view_orders.php" style="display: block; padding: 1rem 2rem; color: var(--primary); font-weight: 500; background: var(--bg-color); border-right: 4px solid var(--primary);"><i class="fa-solid fa-receipt"></i> View Orders</a></li>
            <li><a href="manage_menu.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-utensils"></i> Manage Menu</a></li>
            <li><a href="view_bookings.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-book-open"></i> View Bookings</a></li>
            <li><a href="register_staff.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-user-plus"></i> Register Staff</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div style="flex: 1; padding: 3rem; overflow-x: auto;">
        <h2 style="margin-bottom: 2rem;"><i class="fa-solid fa-receipt" style="color:var(--accent);"></i> All Orders</h2>
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
            <div style="background: var(--bg-color); border-left: 4px solid var(--primary); padding: 1rem; margin-bottom: 2rem;">
                <p style="color: var(--primary-dark); font-weight: 500; margin:0;">Order successfully deleted.</p>
            </div>
        <?php endif; ?>

        <table style="width: 100%; border-collapse: collapse; background: var(--white); box-shadow: var(--shadow-sm); border-radius: var(--radius);">
            <tr style="background: var(--primary); color: var(--white); text-align: left;">
                <th style="padding: 1rem;">ID</th>
                <th style="padding: 1rem;">Customer</th>
                <th style="padding: 1rem;">Total</th>
                <th style="padding: 1rem;">Status</th>
                <th style="padding: 1rem;">Date</th>
                <th style="padding: 1rem; text-align: center;">Action</th>
            </tr>
            <?php foreach($orders as $o): ?>
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem; font-weight: 500;">#<?= $o['id'] ?></td>
                <td style="padding: 1rem;"><?= htmlspecialchars($o['full_name']) ?><br><small style="color: var(--text-muted);"><?= htmlspecialchars($o['email']) ?></small></td>
                <td style="padding: 1rem; font-weight: 600;">Rs. <?= number_format($o['total_amount'], 2) ?></td>
                <td style="padding: 1rem;">
                    <span style="background: <?= $o['status'] == 'completed' ? 'var(--accent)' : '#edf2f7' ?>; color: var(--text-main); padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.9rem;">
                        <?= ucfirst(htmlspecialchars($o['status'])) ?>
                    </span>
                </td>
                <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;"><?= date('M j, g:i A', strtotime($o['created_at'])) ?></td>
                <td style="padding: 1rem; text-align: center;">
                    <form action="../actions/order_process.php" method="POST" style="margin:0;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <button type="submit" class="btn btn-outline" style="padding: 0.3rem 0.8rem; color: #e53e3e; border-color: #e53e3e; font-size: 0.85rem;" onclick="return confirm('WARNING: Are you sure you want to permanently delete order #<?= $o['id'] ?>?');"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
