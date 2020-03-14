<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package villagelanephotography
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
			<?php
				if ( has_nav_menu( 'social' ) ) :
			?>
			<div class="footer-wrap-both">
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
					<?php wp_nav_menu( array(
					'theme_location' => 'social',
					'menu_id' => 'social-menu',
					'container' => '',
					'items_wrap' => '<div id="social-menu-foot"><ul>%3$s</ul></div>',
					'walker' => new VL_Walker_Nav_Menu(), ) ); ?>
				</nav><!-- .social-navigation -->
			<?php
			else : ?>
			
			<div class="footer-wrap-right">
			
			<?php
				
			endif;
	
			?>
				<div class="site-info">
					<p><a href="/terms-of-use/">Terms of Use</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/privacy-policy/">Privacy Policy</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/privacy-tools/">Privacy Tools</a><br>All images copyright Village Lane Photography &copy; <?php echo date("Y"); ?></p>
				</div><!-- .site-info -->
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
