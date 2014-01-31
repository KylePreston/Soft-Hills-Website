<?php
/** Function for setting the content width of a theme. */
function bandana_set_content_width( $width = '' ) {
	global $content_width;
	$content_width = absint( $width );
}

/** Function for getting the theme's content width. */
function bandana_get_content_width() {
	global $content_width;
	return $content_width;
}

/** Function for getting the theme's data */
function bandana_theme_data() {
	global $bandana;
	
	/** If the parent theme data isn't set, let grab it. */
	if ( empty( $bandana->theme_data ) ) {
		
		$bandana_theme_data = array();
		$theme_data = wp_get_theme();
		$bandana_theme_data['Name'] = $theme_data->get( 'Name' );
		$bandana_theme_data['ThemeURI'] = $theme_data->get( 'ThemeURI' );
		$bandana_theme_data['AuthorURI'] = $theme_data->get( 'AuthorURI' );
		$bandana_theme_data['Description'] = $theme_data->get( 'Description' );
		
		$bandana->theme_data = $bandana_theme_data;
	
	}

	/** Return the parent theme data. */
	return $bandana->theme_data;
}
?>