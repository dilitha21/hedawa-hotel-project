    </main>
    
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-about">
                <h3><i class="fa-solid fa-leaf"></i> Hedawa Restaurant</h3>
                <p>Authentic dining experience bringing you the freshest ingredients and finest culinary traditions in a relaxing, green environment.</p>
            </div>
            
            <div class="footer-contact">
                <h3>Contact Information</h3>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-location-dot"></i> Humbutiyaawa Rd, Veyangoda</li>
                    <li><i class="fa-solid fa-phone"></i> 077 763 8980</li>
                    <li><i class="fa-solid fa-envelope"></i> hello@hedawa.com</li>
                </ul>
            </div>
            
            <div class="footer-social">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/HEDEWARESORT" aria-label="Facebook" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@hedewa.resort" aria-label="TikTok" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Hedawa Restaurant. All rights reserved.</p>
        </div>
    </footer>

    <script src="<?= $base_url ?>assets/js/script.js"></script>
    <script>
        // Simple mobile menu toggle inline for reliability
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.mobile-toggle');
            const navLinks = document.querySelector('.nav-links');
            
            if(toggle) {
                toggle.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                    const icon = toggle.querySelector('i');
                    if(navLinks.classList.contains('active')) {
                        icon.classList.replace('fa-bars', 'fa-xmark');
                    } else {
                        icon.classList.replace('fa-xmark', 'fa-bars');
                    }
                });
            }
        });
    </script>
</body>
</html>
