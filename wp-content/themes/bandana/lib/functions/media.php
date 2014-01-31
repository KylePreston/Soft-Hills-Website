<?php
/** Register Bandana Core scripts. */
add_action( 'wp_enqueue_scripts', 'bandana_register_scripts', 1 );

/** Load Bandana Core scripts. */
add_action( 'wp_enqueue_scripts', 'bandana_enqueue_scripts' );

/** Register JavaScript and Stylesheet files for the framework. */
function bandana_register_scripts() {

	/** Register the 'Superfish Plugin' scripts. */
	wp_register_script( 'bandana-js-superfish', esc_url( BANDANA_JS_URI . 'superfish/superfish-combine.min.js' ), array( 'jquery' ), '1.5.9', true );
	
	/** Register the 'common' scripts. */
	wp_register_script( 'bandana-js-common', esc_url( BANDANA_JS_URI . 'common.js' ), array( 'jquery' ), '1.0', true );
	
	/** Register '960.css' for grid. */
	wp_register_style( 'bandana-css-960', esc_url( BANDANA_CSS_URI . '960.css' ) );
	
	/** Register Google Fonts. */
	$protocol = is_ssl()? 'https' : 'http';
	wp_register_style( 'bandana-google-fonts', esc_url( $protocol . '://fonts.googleapis.com/css?family=Open+Sans|Radley' ) );
}

/** Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function. */
function bandana_enqueue_scripts() {

	/** Load the comment reply script on singular posts with open comments if threaded comments are supported. */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/** Load the 'Superfish Plugin' scripts. */
	wp_enqueue_script( 'bandana-js-superfish' );
	
	/** Load the 'common' scripts. */
	wp_enqueue_script( 'bandana-js-common' );
	
	/** Load '960.css' for grid. */
	wp_enqueue_style( 'bandana-css-960' );
	
	/** Load Google Fonts. */
	wp_enqueue_style( 'bandana-google-fonts' );
}