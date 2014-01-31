<?php
/**
 * Newp functions and definitions
 *
 * @package Newp
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'newp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function newp_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Newp, use a find and replace
	 * to change 'newp' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'newp', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	

	add_image_size( 'homepage-thumb', 300, 200, true ); //(cropped)
	
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'newp' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'newp_custom_background_args', array(
		'default-color' => '2f2f2f',
		'default-image' => '',
	) ) );
}
endif; // newp_setup
add_action( 'after_setup_theme', 'newp_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function newp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'newp' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'newp_widgets_init' );

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>
 
<?php
}

/**
 * Enqueue scripts and styles
 */
function newp_scripts() {
	wp_enqueue_style( 'newp-style', get_stylesheet_uri(), array('newp-fonts') );
	wp_enqueue_style( 'newp-fonts', '//fonts.googleapis.com/css?family=Cabin+Condensed|Yanone+Kaffeesatz:400,200|Montserrat:700|Open+Sans' );
	wp_enqueue_style( 'newp-nivo-slider-dark-style', get_template_directory_uri()."/css/themes/dark/dark.css" );
	wp_enqueue_style( 'newp-nivo-slider-style', get_template_directory_uri()."/css/nivo.css" );
	wp_enqueue_script( 'newp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'newp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'newp-nivo-slider', get_template_directory_uri() . '/js/nivo.slider.js', array('jquery') );
	if ( ( of_get_option('slider_enabled') != 0 ) && ( is_front_page() ||  is_home() ) )  {
		wp_enqueue_script( 'newp-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery','newp-nivo-slider') );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'newp-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'newp_scripts' );

function newp_custom_head_codes() {
 if ( (function_exists( 'of_get_option' )) && (of_get_option('headcode1', true) != 1) ) {
	echo of_get_option('headcode1', true);
 }
 if ( (function_exists( 'of_get_option' )) && (of_get_option('style2', true) != 1) ) {
	echo "<style>".of_get_option('style2', true)."</style>";
 }
}
add_action('wp_head', 'newp_custom_head_codes');
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

