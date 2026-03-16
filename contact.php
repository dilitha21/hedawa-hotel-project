<?php
require_once 'includes/db_connect.php';
require_once 'includes/header.php';
?>

<h2>Contact Us</h2>
<p>If you have any questions, feel free to drop us a message!</p>

<?php if(isset($_GET['success'])): ?>
    <div style="color: green;">Message sent successfully!</div>
<?php endif; ?>

<form action="actions/contact_process.php" method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>
    
    <label>Email:</label>
    <input type="email" name="email" required>
    
    <label>Subject:</label>
    <input type="text" name="subject">
    
    <label>Message:</label>
    <textarea name="message" rows="5" required></textarea>
    
    <button type="submit">Send Message</button>
</form>

<?php require_once 'includes/footer.php'; ?>
