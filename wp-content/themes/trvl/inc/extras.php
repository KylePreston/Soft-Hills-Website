<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Trvl
 */

/**
 * Adds custom classes to the array of body classes.
 */
function trvl_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of index to views that are not posts or pages.
	if ( ! is_singular() )
		$classes[] = 'indexed';

	return $classes;
}
add_filter( 'body_class', 'trvl_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function trvl_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'trvl_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function trvl_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'trvl' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'trvl_wp_title', 10, 2 );

function trvl_caption_atts( $atts ) {
	// Remove 10px that will be added by the caption shortcode.
	$atts['width'] = $atts['width'] - 10;

	return $atts;
}
add_filter( 'shortcode_atts_caption', 'trvl_caption_atts' );

/**
 * Switches default core markup for search form to output valid HTML5.
 *
 * @param string $format Expected markup format, default is `xhtml`
 * @return string Trvl loves HTML5.
 */
function trvl_search_form_format( $format ) {
	return 'html5';
}
add_filter( 'search_form_format', 'trvl_search_form_format' );
