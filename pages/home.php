<?php
require_once '../config/database.php';
require_once '../includes/header.php';
?>
<div class="hero" style="text-align: center; padding: 8rem 2rem; background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../assets/images/home_bg.png') center/cover no-repeat; color: var(--white); border-radius: var(--radius); margin-bottom: 3rem; box-shadow: var(--shadow-md);">
    <h1 style="font-size: 3rem; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Welcome to Hedawa Resort</h1>
    <p style="font-size: 1.3rem; margin-bottom: 2.5rem; max-width: 600px; margin-left: auto; margin-right: auto; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">Authentic flavors, green environment, unforgettable memories.</p>
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="bookings.php" class="btn" style="background: var(--accent); color: var(--primary-dark); font-weight: 600; padding: 0.8rem 2rem; font-size: 1.1rem; border: none;">Book a Room</a>
        <a href="orders.php" class="btn btn-outline" style="border-color: var(--white); color: var(--white); font-weight: 600; padding: 0.8rem 2rem; font-size: 1.1rem; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px);">Order Food</a>
    </div>
</div>

<div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <div class="feature-card" style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); text-align: center;">
        <i class="fa-solid fa-utensils" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h3>Delicious Food</h3>
        <p>Expertly crafted dishes using the finest and freshest ingredients specially prepared for you.</p>
    </div>
    <div class="feature-card" style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); text-align: center;">
        <i class="fa-solid fa-bed" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h3>Premium Rooms</h3>
        <p>Book a single, double, or suite room and stay comfortably in our lush green oasis.</p>
    </div>
    <div class="feature-card" style="background: var(--white); padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); text-align: center;">
        <i class="fa-solid fa-leaf" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h3>Eco-Friendly</h3>
        <p>We pride ourselves on our sustainable practices and deep integration with nature.</p>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
