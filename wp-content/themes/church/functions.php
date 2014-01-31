<?php
/**
 * Church functions and definitions
 *
 * @package Church
 */

function church_setup() {

	add_theme_support( 'omega-footer-widgets', 4 );
	remove_action( 'omega_before_header', 'omega_get_primary_menu' );	
	add_action( 'omega_after_header', 'omega_get_primary_menu' );

	add_action ('omega_header', 'church_header_right');

	/* Add support for a custom header image. */
	add_theme_support(
		'custom-header',
		array( 'header-text' => false,
			'flex-width'    => true,
			'uploads'       => true,
			'default-image' => get_stylesheet_directory_uri() . '/images/header.jpg' ,
			'admin-head-callback'    => 'church_admin_header_style',
			'admin-preview-callback' => 'church_admin_header_image'
			));


	/* Custom background. */
	add_theme_support( 
		'custom-background',
		array( 'default-color' => 'e8e4dc' )
	);

	add_theme_support( 'color-palette', array( 'callback' => 'church_register_colors' ) );

	add_filter( 'loop_pagination_args', 'church_loop_pagination_args' );

	add_action( 'widgets_init', 'church_widgets_init', 15 );

	remove_action( 'omega_home_before_entry', 'omega_entry_header' );

	add_filter( 'theme_mod_theme_layout', 'church_theme_layout', 15 );

	add_action( 'omega_after_header', 'church_banner' );

	add_action('init', 'church_init', 1);

	add_action('custom_header_options', 'church_header_image_option');
	add_action('admin_head', 'church_header_image_option_save');

}

add_action( 'after_setup_theme', 'church_setup', 11  );

function church_loop_pagination_args( $args ) {
	/* Set up some default arguments for the paginate_links() function. */
	$args = array(
		'end_size'     => 5,
		'mid_size'     => 4
	);
	return $args;
}

function church_header_right() {
	get_template_part( 'header', 'right' );
}

function church_theme_layout( $layout ) {
	//global $post;
	//echo (get_post_layout( get_queried_object_id() ));
	if ( is_front_page() && !is_home() && get_post_layout( get_queried_object_id() ) == 'default' )
		$layout = '1c';

	return $layout;
}

function church_get_header_image() {
	if (get_header_image()) {
		if (get_theme_mod( 'church_header_link' )) {
			echo '<a href="'.get_theme_mod( 'church_header_link' ).'"><img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="' . get_bloginfo( 'description' ) . '" /></a>';
		} else {
			echo '<img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="' . get_bloginfo( 'description' ) . '" />';
		}
	}
}

function church_banner() {
	
?>
	<div class="banner">
		<div class="wrap">
			<?php
			if(is_front_page()) {
				if ( is_active_sidebar( 'banner' ) ) {
					 dynamic_sidebar( 'banner' );
				} else {
					church_get_header_image();
				}
			} elseif ( !is_front_page() && get_theme_mod( 'church_header_home' ) ) {
					echo '';
			} else {	
				// get title		
				$id = get_option('page_for_posts');
				if ( is_day() || is_month() || is_year() || is_tag() || is_category() || is_singular('post' ) || is_home() ) {
					$the_title = get_the_title($id);
				} else {
					$the_title = get_the_title(); 
				}

				if(is_home() || is_singular('post' ) ) {
					if ( has_post_thumbnail($id) ) {
						echo get_the_post_thumbnail( $id, 'full' );
					} else {
						church_get_header_image();
					}
				} elseif ( has_post_thumbnail() && is_singular('page' ) ) {	
						the_post_thumbnail();
				} else {
					church_get_header_image();
				}
			}
			?>
		</div><!-- .wrap -->
  	</div><!-- .banner -->
<?php  	
}

/**
 * Registers colors for the Color Palette extension.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $color_palette
 * @return void
 */

function church_register_colors( $color_palette ) {

	/* Add custom colors. */
	$color_palette->add_color(
		array( 'id' => 'primary', 'label' => __( 'Primary Color', 'church' ), 'default' => '211b1a' )
	);
	$color_palette->add_color(
		array( 'id' => 'secondary', 'label' => __( 'Secondary Background', 'church' ), 'default' => '050505' )
	);
	$color_palette->add_color(
		array( 'id' => 'link', 'label' => __( 'Link Color', 'church' ), 'default' => '9aa32c' )
	);

	/* Add rule sets for colors. */

	$color_palette->add_rule_set(
		'primary',
		array(
			'color'               => 'h1.site-title a, .site-description, .entry-meta, .header-right',
			'background-color'    => '.tinynav, .nav-primary .wrap, .omega-nav-menu li ul li:hover, .footer-widgets .wrap, button, input[type="button"], input[type="reset"], input[type="submit"]'
		)
	);
	$color_palette->add_rule_set(
		'secondary',
		array(
			'background-color'    => '.site-footer .wrap, .omega-nav-menu li:hover, .omega-nav-menu li:hover ul'
		)
	);
	$color_palette->add_rule_set(
		'link',
		array(
			'color'    => '.site-inner .entry-meta a, .site-inner .entry-content a, .site-inner .sidebar a'
		)
	);
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function church_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Header Right', 'church' ),
		'id'            => 'header-right',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Banner', 'church' ),
		'id'            => 'banner',
		'description'   => 'This widget area will replace the homepage header image',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}

function church_init() {
	if(!is_admin()){
		wp_enqueue_script("tinynav", get_stylesheet_directory_uri() . '/js/tinynav.js', array('jquery'));
	} 
}

function church_header_image_option() {
?>
<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e( 'Header Image Link' ); ?></th>
			<td>
				<p>
					<input type="input" class="regular-text code" name="church_header_link" id="church_header_link" value="<?php echo get_theme_mod( 'church_header_link' ); ?>" />
				</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Show image on front page only:' ); ?></th>
			<td>
				<p>
					<input type="checkbox" name="church_header_home" id="church_header_home" value="1" <?php checked( get_theme_mod( 'church_header_home', false ) ); ?> />
				</p>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="custom_header_option" value="1" />
<?php
}

function church_header_image_option_save() {
	if ( isset( $_POST['custom_header_option'] ) ) {
		// validate the request itself by verifying the _wpnonce-custom-header-options nonce
		// (note: this nonce was present in the normal Custom Header form already, so we didn't have to add our own)
		check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );

		// be sure the user has permission to save theme options (i.e., is an administrator)
		if ( current_user_can('manage_options') ) {
			// NOTE: Add your own validation methods here
			set_theme_mod( 'church_header_link', esc_url($_POST['church_header_link']) );
			if ( isset($_POST['church_header_home'])) {
				set_theme_mod( 'church_header_home', $_POST['church_header_home'] );
			} else {
				set_theme_mod( 'church_header_home', 0 );
			}
			
		}
	}
	return;
}

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see church_custom_header_setup().
 */
function church_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
	</style>
<?php
}

/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see church_custom_header_setup().
 */
function church_admin_header_image() {
	$header_image = get_header_image();
?>
	<div id="headimg">
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}

?>