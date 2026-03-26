<?php require_once '../includes/header.php'; ?>
<div class="contact-container" style="max-width: 600px; margin: 2rem auto; background: var(--white); padding: 2.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <i class="fa-solid fa-envelope-open-text" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h2>Get in Touch</h2>
        <p style="color: var(--text-muted);">Have questions or feedback? Drop us a message below and we will get back to you.</p>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div style="background: var(--bg-color); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
            <p style="color: var(--primary-dark); margin: 0; font-weight: 500;"><i class="fa-solid fa-check-circle"></i> Your message has been saved to the database. We will reply soon!</p>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div style="background: #fff5f5; border-left: 4px solid #e53e3e; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
            <p style="color: #c53030; margin: 0; font-weight: 500;"><i class="fa-solid fa-xmark-circle"></i> Failed to save the message. Please check the fields.</p>
        </div>
    <?php endif; ?>

    <form action="../actions/contact_process.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Full Name</label>
            <input type="text" name="name" placeholder="John Doe" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Subject</label>
            <input type="text" name="subject" placeholder="Inquiry about event spaces" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family);">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-main);">Message</label>
            <textarea name="message" placeholder="Type your message here..." required rows="5" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: var(--radius); font-family: var(--font-family); resize: vertical;"></textarea>
        </div>
        
        <button type="submit" class="btn" style="padding: 1rem; font-size: 1.05rem;"><i class="fa-regular fa-paper-plane"></i> Send Message</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>
