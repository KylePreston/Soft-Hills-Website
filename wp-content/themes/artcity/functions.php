<?php
/**
 * @package		ArtCity
 * @version		1.0
 * @author		Piet Bos <piet@senlinonline.com>
 * @copyright	Copyright (c) 2013, Piet Bos
 * @link		http://themehybrid.com/themes/artcity
 * @license:	GNU General Public License v2.0 or later
 * @license URI:http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Add the child theme setup function to the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'artcity_setup', 10 );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function artcity_setup() {

	/**
	 * Add a custom background to overwrite the defaults.
	 * @link http://codex.wordpress.org/Custom_Backgrounds
	 * @since  0.1.0
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f2f3f7',
		)
	);

	/**
	 * Add a custom header to overwrite the defaults.
	 * @link http://codex.wordpress.org/Custom_Headers
	 * @since  0.1.0
	 */
	add_theme_support( 
		'custom-header', 
		array(
			'default-text-color' => '1a5895',
			'default-image'		 => '%2$s/images/headers/vlc2.jpg',
			'random-default'     => false
		)
	);

	/* Un-Register default Parent Theme headers for the child theme. */
	unregister_default_headers(
		array( 'horizon', 'orange-burn', 'planets-blue', 'planet-burst', 'space-splatters' )
	);

	/**
	 * Registers default headers for the theme.
	 * @link http://codex.wordpress.org/Function_Reference/register_default_headers
	 * @since  0.1.0
	 */
	register_default_headers(
		array(
			'vlc1' => array(
				'url'           => '%2$s/images/headers/vlc1.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc1-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC1', 'artcity' )
			),
			'vlc2' => array(
				'url'           => '%2$s/images/headers/vlc2.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc2-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC2', 'artcity' )
			),
			'vlc3' => array(
				'url'           => '%2$s/images/headers/vlc3.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc3-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC3', 'artcity' )
			),
			'vlc4' => array(
				'url'           => '%2$s/images/headers/vlc4.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc4-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC4', 'artcity' )
			),
			'vlc5' => array(
				'url'           => '%2$s/images/headers/vlc5.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc5-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC5', 'artcity' )
			),
			'vlc6' => array(
				'url'           => '%2$s/images/headers/vlc6.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc6-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC6', 'artcity' )
			),
			'vlc7' => array(
				'url'           => '%2$s/images/headers/vlc7.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc7-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC7', 'artcity' )
			),
			'vlc8' => array(
				'url'           => '%2$s/images/headers/vlc8.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc8-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC8', 'artcity' )
			),
			'vlc9' => array(
				'url'           => '%2$s/images/headers/vlc9.jpg',
				'thumbnail_url' => '%2$s/images/headers/vlc9-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'VLC9', 'artcity' )
			),
		)
	);
	
	/**
	 * Add a custom default color for the "primary" color option.
	 * @since 0.1.0
	 */
	add_filter( 'theme_mod_color_primary', 'artcity_color_primary' );
	
	/**
	 * Custom editor stylesheet.
	 * @since 0.1.1
	 */
	 add_editor_style( '//fonts.googleapis.com/css?family=Sacramento' );
	
	/**
	 * Load the artcity-fonts for the custom header front end.
	 * @since 0.1.1
	 */
	add_action( 'wp_enqueue_scripts', 'artcity_scripts_styles' );
	
	/**
	 * Load the artcity-fonts for the custom back end.
	 * @since 0.1.1
	 */
	add_action( 'admin_enqueue_scripts', 'artcity_scripts_styles' );
	
}

/**
 * Add a default custom color for the theme's "primary" color option.  Users can overwrite this from the 
 * theme customizer, so we want to make sure to check that there's no value before returning our custom 
 * color.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $hex
 * @return string
 */
function artcity_color_primary( $hex ) {
	return $hex ? $hex : 'ff5a00';
}

/**
 * Return the Google font stylesheet URL, if available.
 * Copied from Twenty Thirteen
 * @since 0.1.0
 * @return string Font stylesheet or empty string if disabled.
 */
function artcity_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Sacramento, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sacramento = _x( 'on', 'Sacramento font: on or off', 'artcity' );

	if ( 'off' !== $source_sacramento ) {
		$font_families = array();

		if ( 'off' !== $source_sacramento )
			$font_families[] = 'Sacramento:400';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue font styles for the front end / back end.
 *
 * @since 0.1.0
 *
 * @return void
 */
function artcity_scripts_styles() {
	// Add Sacramento font, used in the main/admin stylesheet.
	wp_enqueue_style( 'artcity-fonts', artcity_fonts_url(), array(), null );

}