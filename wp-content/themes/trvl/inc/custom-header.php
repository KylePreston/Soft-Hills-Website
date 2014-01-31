<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Trvl
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses trvl_header_style()
 * @uses trvl_admin_header_style()
 * @uses trvl_admin_header_image()
 *
 * @package Trvl
 */
function trvl_custom_header_setup() {
	$args = apply_filters( 'trvl_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '4ba6b5',
		'width'                  => 950,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'trvl_header_style',
		'admin-head-callback'    => 'trvl_admin_header_style',
		'admin-preview-callback' => 'trvl_admin_header_image',
	) );

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'trvl_custom_header_setup' );

if ( ! function_exists( 'trvl_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see trvl_custom_header_setup().
 */
function trvl_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // trvl_header_style

if ( ! function_exists( 'trvl_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see trvl_custom_header_setup().
 */
function trvl_admin_header_style() {
?>
	<style type="text/css">
		@font-face {
			font-family: 'LeagueGothicRegular';
			src: url('<?php echo get_template_directory_uri(); ?>/fonts/LeagueGothic-Regular-webfont.eot');
			src: url('<?php echo get_template_directory_uri(); ?>/fonts/LeagueGothic-Regular-webfont.eot?#iefix') format('embedded-opentype'),
			     url('<?php echo get_template_directory_uri(); ?>/fonts/LeagueGothic-Regular-webfont.woff') format('woff'),
			     url('<?php echo get_template_directory_uri(); ?>/fonts/LeagueGothic-Regular-webfont.ttf') format('truetype'),
			     url('<?php echo get_template_directory_uri(); ?>/fonts/LeagueGothic-Regular-webfont.svg#LeagueGothicRegular') format('svg');
			font-weight: normal;
			font-style: normal;
		}

		.appearance_page_custom-header #headimg {
			background: #<?php background_color(); ?>;
			border: none;
		}

		#headimg {
			text-align: center;
			padding-bottom: 60px;
		}

		#desc {
			color: #d6d6d6 !important;
			font: 14px/1 LeagueGothicRegular, Arial, sans-serif;
			letter-spacing: 7px;
			margin-bottom: 5px;
			padding-top: 8px;
			text-transform: uppercase;
		}

		#headimg h1 {
			font-family: LeagueGothicRegular, Arial, sans-serif;
			font-size: 160px;
			font-weight: normal;
			line-height: 1;
			letter-spacing: 1px;
			margin: 0;
			text-transform: uppercase;
		}

		#headimg h1 a {
			color: #4ba6b5;
			text-decoration: none;
		}

		#headimg img {
			display: inline-block;
			margin-top: 30px;
		}
	</style>
<?php
}
endif; // trvl_admin_header_style

if ( ! function_exists( 'trvl_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see trvl_custom_header_setup().
 */
function trvl_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}
endif; // trvl_admin_header_image
