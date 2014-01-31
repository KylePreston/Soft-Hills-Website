<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Trvl
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function trvl_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'footer_widgets' => is_active_sidebar( 'sidebar-1' ) || has_nav_menu( 'primary' ),
		'container'      => 'content',
		'footer'         => 'page',
	) );
}
add_action( 'after_setup_theme', 'trvl_jetpack_setup' );
