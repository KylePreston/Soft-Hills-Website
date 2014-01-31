<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 
?>
</div>
	<footer id="colophon" role="contentinfo">
		<div class="wid960 clearfix">
			<?php
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>
		</div>
		<div id="site-generator">
			<div class="wid960 clearfix">
				<?php do_action( 'sgwp_credits' ); ?>
				<p class="fleft">Proudly powered by <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr( 'Semantic Personal Publishing Platform', 'sgwp' ); ?>" target="_blank">WordPress</a></p>
				<p class="fright">Designed by <a href="http://www.siteground.com/template-preview/wordpress/Wallpapered" target="_blank">SiteGround</a></p>
				
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>