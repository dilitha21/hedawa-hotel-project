<?php
require_once '../config/database.php';
require_once '../includes/staff_check.php';

// Handle staff registration logic directly here (rather than adding another action processor)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'register') {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($fullName) || empty($email) || empty($password)) {
        header("Location: register_staff.php?error=empty_fields");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'staff')");
        if ($stmt->execute([$fullName, $email, $hashedPassword])) {
            header("Location: register_staff.php?success=1");
            exit;
        } else {
            header("Location: register_staff.php?error=insert_failed");
            exit;
        }
    } catch (\PDOException $e) {
        header("Location: register_staff.php?error=email_taken");
        exit;
    }
}

require_once '../includes/header.php';
?>
<div class="staff-container" style="display: flex; min-height: calc(100vh - 80px - 200px); background: #f8fafc;">
    
    <!-- Sidebar -->
    <aside style="width: 250px; background: var(--white); box-shadow: var(--shadow-sm); padding: 2rem 0;">
        <h3 style="text-align: center; color: var(--primary-dark); margin-bottom: 2rem; border-bottom: 1px solid #edf2f7; padding-bottom: 1rem;">Staff Control</h3>
        <ul style="list-style: none;">
            <li><a href="dashboard.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="view_orders.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-receipt"></i> View Orders</a></li>
            <li><a href="manage_menu.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-utensils"></i> Manage Menu</a></li>
            <li><a href="view_bookings.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-book-open"></i> View Bookings</a></li>
            <li><a href="register_staff.php" style="display: block; padding: 1rem 2rem; color: var(--primary); font-weight: 500; background: var(--bg-color); border-right: 4px solid var(--primary);"><i class="fa-solid fa-user-plus"></i> Register Staff</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div style="flex: 1; padding: 3rem; display: flex; justify-content: center; align-items: flex-start;">
        <div style="background: var(--white); padding: 3rem; border-radius: var(--radius); box-shadow: var(--shadow-md); width: 100%; max-width: 500px;">
            <h2 style="margin-bottom: 1.5rem; color: var(--primary-dark); text-align: center;"><i class="fa-solid fa-user-shield"></i> Add New Staff</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Authorize a new employee with staff-level access.</p>

            <?php if(isset($_GET['error'])): ?>
                <div style="background: #fff5f5; border-left: 4px solid #e53e3e; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                    <p style="color: #c53030; margin: 0; font-weight: 500;">Failed: Email might already exist.</p>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success'])): ?>
                <div style="background: var(--bg-color); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                    <p style="color: var(--primary-dark); margin: 0; font-weight: 500;">New staff member officially registered!</p>
                </div>
            <?php endif; ?>

            <form method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <input type="hidden" name="action" value="register">
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Staff Full Name</label>
                    <input type="text" name="full_name" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Email Address</label>
                    <input type="email" name="email" required autocomplete="off" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Temporary Password</label>
                    <input type="password" name="password" required autocomplete="new-password" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
                </div>
                
                <button type="submit" class="btn" style="padding: 1rem; font-size: 1.05rem; margin-top: 1rem;"><i class="fa-solid fa-plus"></i> Register Staff Account</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
