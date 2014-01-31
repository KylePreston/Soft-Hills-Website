<?php
/** Load the Core Files */
require_once( trailingslashit( get_template_directory() ) . 'lib/init.php' );
new Bandana();

/** Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'bandana_theme_setup' );

/** Theme setup function. */
function bandana_theme_setup() {
	
	/** Add theme support for Feed Links. */
	add_theme_support( 'automatic-feed-links' );
	
	/** Add theme support for Custom Background. */
	add_theme_support( 'custom-background', array( 'default-color' => 'fafafa' ) );
	
	/** Set content width. */
	bandana_set_content_width( 580 );
	
	/** Add custom image sizes. */
	add_action( 'init', 'bandana_add_image_sizes' );	

}

/** Adds custom image sizes */
function bandana_add_image_sizes() {
	add_image_size( 'featured', 580, 350, true );
}