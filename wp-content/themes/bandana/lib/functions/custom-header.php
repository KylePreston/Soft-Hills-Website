<?php
/** Theme Custom Header */
$custom_header_support = array( 
	
	'default-image' => '%s/images/headers/header-default.png',
	'default-text-color' => '',
	'width' => apply_filters( 'bandana_header_image_width', 280 ),
	'height' => apply_filters( 'bandana_header_image_height', 80 ),
	'flex-height' => true,
	'header-text' => false,
	'wp-head-callback' => 'bandana_header_style',
	'admin-head-callback' => 'bandana_admin_header_style',
	'admin-preview-callback' => 'bandana_admin_header_image'
	
);

add_theme_support( 'custom-header', $custom_header_support );

/** Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI. */
register_default_headers( array(
	
	'bandana' => array(
		'url' => '%s/images/headers/header-default.png',
		'thumbnail_url' => '%s/images/headers/header-default.png',
		'description' => __( 'Bandana', 'bandana' )
	)

) );

/** Styles the header image and text displayed on the blog. */
function bandana_header_style() {
}

/** Styles the header image displayed on the Appearance > Header admin panel. */
function bandana_admin_header_style() {
?>
<style type="text/css">
.appearance_page_custom-header #headimg {
	width: 280px;
	overflow: hidden;
	border: none;
}

#headimg #logo-image img {
	max-width: 280px;
	height: auto;
	width: 100%;
}

#headimg #logo-text {
	margin: 18px 0;
}

#headimg #logo-text a {
	text-decoration: none;
}

#headimg #logo-text .site-name  {
	display: block;
	font-family: 'Oswald', sans-serif;
	font-size: 28px; 
	line-height: 34px; 
}

#headimg #logo-text .site-description {
	display: block;
}
</style>
<?php
}

/** Styles the header image and text displayed on the blog preview. */
function bandana_admin_header_image() {
?>
<div id="headimg">	
<?php if ( get_header_image() ) : ?>

<div id="logo-image">
  <a href="<?php echo home_url( '/' ); ?>" onclick="return false;"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
</div><!-- end of #logo -->

<?php else: // header image was removed ?>

<div id="logo-text">
  <span class="site-name"><a href="<?php echo home_url( '/' ); ?>" onclick="return false;" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
  <span class="site-description"><?php bloginfo( 'description' ); ?></span>
</div><!-- end of #logo -->

<?php endif; // header image was removed (again) ?>

</div>

<?php
}
?>