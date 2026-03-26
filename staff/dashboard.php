<?php
require_once '../config/database.php';
require_once '../includes/staff_check.php';
require_once '../includes/header.php';

$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$pending_bookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$total_staff = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'staff'")->fetchColumn();
?>
<div class="staff-container" style="display: flex; min-height: calc(100vh - 80px - 200px); background: #f8fafc;">
    
    <!-- Sidebar -->
    <aside style="width: 250px; background: var(--white); box-shadow: var(--shadow-sm); padding: 2rem 0;">
        <h3 style="text-align: center; color: var(--primary-dark); margin-bottom: 2rem; border-bottom: 1px solid #edf2f7; padding-bottom: 1rem;">Staff Control</h3>
        <ul style="list-style: none;">
            <li><a href="dashboard.php" style="display: block; padding: 1rem 2rem; color: var(--primary); font-weight: 500; background: var(--bg-color); border-right: 4px solid var(--primary);"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="view_orders.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-receipt"></i> View Orders</a></li>
            <li><a href="manage_menu.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-utensils"></i> Manage Menu</a></li>
            <li><a href="view_bookings.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-book-open"></i> View Bookings</a></li>
            <li><a href="register_staff.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-user-plus"></i> Register Staff</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div style="flex: 1; padding: 3rem;">
        <h2 style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-gauge-high" style="color:var(--primary);"></i> Overview</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary);">
                <h3 style="color: var(--text-muted); font-size: 1.1rem;">Pending Orders</h3>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--text-main); margin-top: 0.5rem;"><?= $pending_orders ?></p>
            </div>
            
            <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary-light);">
                <h3 style="color: var(--text-muted); font-size: 1.1rem;">Pending Bookings</h3>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--text-main); margin-top: 0.5rem;"><?= $pending_bookings ?></p>
            </div>
            
            <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid #718096;">
                <h3 style="color: var(--text-muted); font-size: 1.1rem;">Active Staff</h3>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--text-main); margin-top: 0.5rem;"><?= $total_staff ?></p>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
