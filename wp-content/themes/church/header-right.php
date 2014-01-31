<?php
/**
 * The Sidebar containing the header right widget areas.
 *
 * @package Church
 */

if ( is_active_sidebar( 'header-right' ) ) : ?>	

	<aside class="col-xs-12 col-md-8 header-right widget-area <?php echo apply_atomic( 'omega_sidebar_class', 'sidebar' );?>">
		
		<?php dynamic_sidebar( 'header-right' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

	