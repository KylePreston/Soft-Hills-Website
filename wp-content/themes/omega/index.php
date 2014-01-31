<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Omega
 */

get_header(); ?>

	<main class="<?php echo omega_apply_atomic( 'main_class', 'content' );?>" <?php omega_attr( 'content' ); ?>>

		<?php 
		omega_do_atomic( 'before_content' ); // omega_before_content 

		omega_do_atomic( 'index_content' ); // omega_content 
		
		omega_do_atomic( 'after_content' ); // omega_after_content 
		?>

	</main><!-- .content -->

<?php get_footer(); ?>