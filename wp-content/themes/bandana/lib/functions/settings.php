<?php
/** Bandana Default Settings. */	
function bandana_settings_default()  {
	
	$default = array(
			
		'bandana_nav_style' => 'numeric',
		
		'bandana_post_style' => 'content',
		'bandana_featured_image_control' => 'manual',
		
		'bandana_copyright_control' => 0,
		'bandana_copyright' => '',
		
		'bandana_reset_control' => 0
		
	);
	
	return $default;
	
}

/** Loads the Bandana theme setting. */
function bandana_get_settings() {
	global $bandana;

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	if ( !isset( $bandana->settings ) ) {
		$bandana->settings = wp_parse_args( get_option( 'bandana_options', bandana_settings_default() ), bandana_settings_default() );
	}
	
	/** return settings. */
	return $bandana->settings;
}