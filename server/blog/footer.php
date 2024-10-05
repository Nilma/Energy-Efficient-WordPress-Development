</main> <!-- Ensure you close the main tag opened in header.php -->

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h2><?php bloginfo('name'); ?></h2>
            <p><?php bloginfo('description'); ?></p>
        </div>
        
        <div class="footer-section">
            <h2>Quick Links</h2>
            <nav class="footer-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                ));
                ?>
            </nav>
        </div>
        
        <div class="footer-section">
            <h2>Connect with Us</h2>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
    <p><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?>.</p>
</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
