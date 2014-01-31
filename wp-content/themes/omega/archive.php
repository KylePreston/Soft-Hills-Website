<?php
/**
 * The template for displaying Archive pages.
 *
 * @package Omega
 */

get_header(); ?>

	<main  class="<?php echo omega_apply_atomic( 'main_class', 'content' );?>" <?php omega_attr( 'content' ); ?>>

		<?php 
		omega_do_atomic( 'before_content' ); // omega_before_content

		omega_do_atomic( 'content' ); // omega_content

		omega_do_atomic( 'after_content' ); // omega_after_content 
		?>
		
	</main><!-- .content -->

<?php get_footer(); ?>