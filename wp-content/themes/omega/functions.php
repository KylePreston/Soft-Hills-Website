<?php
/**
 * The functions file is utilized to initialize every little thing in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should must make a child theme and make modifications to its functions.php file (not this one).
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 or lower if wanting to run before the parent theme.
 *
 * @package Omega
 * @author ThemeHall <hello@themehall.com>
 * @copyright Copyright (c) 2013, themehall.com
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link http://themehall.com/omega
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require ( trailingslashit( get_template_directory() ) . 'lib/framework.php' );
new Omega();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function omega_theme_setup() {

	/* Load omega functions */
	require get_template_directory() . '/lib/hooks.php';

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );
	
	/* Load scripts. */
	add_theme_support( 
		'omega-scripts', 
		array( 'comment-reply' ) 
	);

	/* Load shortcodes. */
	add_theme_support( 'omega-shortcodes' );
	
	add_theme_support( 'omega-theme-settings', array( 'about' ) );

	/* Enable custom template hierarchy. */
	//add_theme_support( 'omega-template-hierarchy' );

	/* Enable theme layouts (need to add stylesheet support). */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => __( 'Content',           'omega' ),
			'2c-l'      => __( 'Content / Sidebar', 'omega' ),
			'2c-r'      => __( 'Sidebar / Content', 'omega' )
		),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l', 'customizer' => true ) 
	);
		
	/* implement editor styling, so as to make the editor content match the resulting post output in the theme. */
	add_editor_style();

	/* Enable responsive support */
	add_theme_support( 'omega-deprecated' );

	/* Support pagination instead of prev/next links. */
	add_theme_support( 'loop-pagination' );	

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Add default posts and comments RSS feed links to <head>.  */
	add_theme_support( 'automatic-feed-links' );

	/* Enable wraps */
	add_theme_support( 'omega-wraps' );

	/* Enable custom css */
	add_theme_support( 'omega-custom-css' );
	
	/* Enable custom logo */
	add_theme_support( 'omega-custom-logo' );

	/* Enable child themes page */
	add_theme_support( 'omega-child-page' );


	/* Handle content width for embeds and images. */
	omega_set_content_width( 640 );

}

add_action( 'after_setup_theme', 'omega_theme_setup' );