<?php require_once 'includes/header.php'; ?>
<div class="login-container" style="max-width: 400px; margin: 4rem auto; background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-md);">
    <h2>Login to Hedawa</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <p style="color: red; margin-bottom: 1rem; font-size: 0.9rem;">Invalid credentials or empty fields.</p>
    <?php endif; ?>
    <?php if(isset($_GET['success'])): ?>
        <p style="color: var(--primary); margin-bottom: 1rem; font-size: 0.9rem; background: var(--bg-color); padding: 0.5rem; border-radius: 4px;">Registration successful. Please login.</p>
    <?php endif; ?>

    <form action="actions/login_process.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
        <input type="email" name="email" placeholder="Email Address" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        <input type="password" name="password" placeholder="Password" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        <button type="submit" class="btn">Login</button>
    </form>
    
    <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>
<?php require_once 'includes/footer.php'; ?>
