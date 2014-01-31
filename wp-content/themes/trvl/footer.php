<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Trvl
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav id="site-navigation" class="navigation-main clear" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Menu', 'trvl' ); ?></h1>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1, 'fallback_cb' => '__return_false' ) ); ?>
		</nav><!-- #site-navigation -->
		<?php endif; ?>

		<?php get_sidebar(); ?>

		<div class="site-info">
			<?php do_action( 'trvl_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'trvl' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'trvl' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'trvl' ), 'Trvl', '<a href="http://theme.wordpress.com/" rel="designer">WordPress.com</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>