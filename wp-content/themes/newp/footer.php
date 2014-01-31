<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Newp
 */
?>

	</div><!-- #content -->
</div><!-- #page -->
	<footer id="colophon" class="site-footer" role="contentinfo">
    
    <div id="footer-container">
      <?php if ( of_get_option('credit1', true) == 0 ) { ?>
		<div class="site-info">
			<?php do_action( 'newp_credits' ); ?>
			<?php printf( __( 'Newp Theme by %1$s', 'newp' ), '<a href="http://rohitink.com" rel="designer">Rohit Tripathi</a>' ); ?>
		</div><!-- .site-info -->
      <?php } //endif ?>  
        <div id="footertext">
        	<?php
			if ( (function_exists( 'of_get_option' ) && (of_get_option('footertext2', true) != 1) ) ) {
			 	echo of_get_option('footertext2', true); } ?>
        </div>    
        
        </div><!--#footer-container-->
	</footer><!-- #colophon -->
	<?php		if ( (function_exists( 'of_get_option' ) && (of_get_option('footercode1', true) != 1) ) ) {
			 	echo of_get_option('footercode1', true); } ?>
<?php wp_footer(); ?>

</body>
</html>