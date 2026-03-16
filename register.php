<?php require_once 'includes/header.php'; ?>
<div class="register-container" style="max-width: 400px; margin: 4rem auto; background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-md);">
    <h2>Create Account</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <p style="color: red; margin-bottom: 1rem; font-size: 0.9rem;">Registration failed. Email might already be in use.</p>
    <?php endif; ?>

    <form action="actions/register_process.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
        <input type="text" name="full_name" placeholder="Full Name" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        <input type="email" name="email" placeholder="Email Address" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        <input type="password" name="password" placeholder="Password" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        <button type="submit" class="btn">Register</button>
    </form>
    
    <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>
<?php require_once 'includes/footer.php'; ?>
