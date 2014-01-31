<?php
class BandanaAdmin {
		
		/** Constructor Method */
		function __construct() {
	
			/* Hook the settings page function to 'admin_menu'. */
			add_action( 'admin_menu', array( &$this, 'settings_page_init' ) );

			/** Load the admin_init functions. */
			add_action( 'admin_init', array( &$this, 'admin_init' ) );					
	
		}
		
		/** Initializes any admin-related features needed for the framework. */
		function admin_init() {
			
			/** Registers admin JavaScript and Stylesheet files for the framework. */
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_register_scripts' ), 1 );
		
			/** Loads admin JavaScript and Stylesheet files for the framework. */
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
			
		}
		
		/** Registers admin JavaScript and Stylesheet files for the framework. */
		function admin_register_scripts() {
			
			/** Register Admin Stylesheet */
			wp_register_style( 'bandana-admin-css-style', esc_url( BANDANA_ADMIN_URI . 'style.css' ) );
			
			/** Register Admin Scripts */
			wp_register_script( 'bandana-admin-js-bandana', esc_url( BANDANA_ADMIN_URI . 'common.js' ) );
			wp_register_script( 'bandana-admin-js-jquery-cookie', esc_url( BANDANA_JS_URI . 'jquery-cookie/jquery.cookie.js' ) );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for the framework. */
		function admin_enqueue_scripts() {			
		}
		
		/** Initializes all the theme settings page functionality. This function is used to create the theme settings page */
		function settings_page_init() {
			
			global $bandana;
			
			/** Register theme settings. */
			register_setting( 'bandana_options_group', 'bandana_options', array( &$this, 'bandana_options_validate' ) );
			
			/* Create the theme settings page. */
			$bandana->settings_page = add_theme_page( 
				esc_html( __( 'Bandana Options', 'bandana' ) ),	/** Settings page name. */
				esc_html( __( 'Bandana Options', 'bandana' ) ),	/** Menu item name. */
				$this->settings_page_capability(),				/** Required capability */
				'bandana-options', 								/** Screen name */
				array( &$this, 'settings_page' )				/** Callback function */
			);
			
			/* Check if the settings page is being shown before running any functions for it. */
			if ( !empty( $bandana->settings_page ) ) {
				
				/** Add contextual help to the theme settings page. */
				add_action( 'load-'. $bandana->settings_page, array( &$this, 'settings_page_contextual_help' ) );
				
				/* Load the JavaScript and stylesheets needed for the theme settings screen. */
				add_action( 'admin_enqueue_scripts', array( &$this, 'settings_page_enqueue_scripts' ) );
				
				/** Configure settings Sections and Fileds. */
				$this->settings_sections();
				
				/** Configure default settings. */
				$this->settings_default();				
				
			}
			
		}
		
		/** Returns the required capability for viewing and saving theme settings. */
		function settings_page_capability() {
			return 'edit_theme_options';
		}
		
		/** Displays the theme settings page. */
		function settings_page() {
			require( BANDANA_ADMIN_DIR . 'page.php' );
		}
		
		/** Text for the contextual help for the theme settings page in the admin. */
		function settings_page_contextual_help() {
			
			/** Get the parent theme data. */
			$theme = bandana_theme_data();
			$AuthorURI = $theme['AuthorURI'];
			$ThemeURI = $theme['ThemeURI'];
		
			/** Get the current screen */
			$screen = get_current_screen();
			
			/** Add theme reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-theme',
				'title' => __( 'Theme Support', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/support.html' ) ),				
				
				)
			);
			
			/** Add license reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-license',
				'title' => __( 'License', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/license.html' ) ),				
				
				)
			);
			
			/** Add changelog reference help screen tab. */
			$screen->add_help_tab( array(
				
				'id' => 'bandana-changelog',
				'title' => __( 'Changelog', 'bandana' ),
				'content' => implode( '', file( BANDANA_ADMIN_DIR . 'help/changelog.html' ) ),				
				
				)
			);
			
			/** Help Sidebar */
			$sidebar = '<p><strong>' . __( 'For more information:', 'bandana' ) . '</strong></p>';
			if ( !empty( $AuthorURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $AuthorURI ) . '" target="_blank">' . __( 'Bandana Project', 'bandana' ) . '</a></p>';
			}
			if ( !empty( $ThemeURI ) ) {
				$sidebar .= '<p><a href="' . esc_url( $ThemeURI ) . '" target="_blank">' . __( 'Bandana Official Page', 'bandana' ) . '</a></p>';
			}			
			$screen->set_help_sidebar( $sidebar );
			
		}
		
		/** Loads admin JavaScript and Stylesheet files for displaying the theme settings page in the WordPress admin. */
		function settings_page_enqueue_scripts( $hook ) {
			
			/** Load Scripts For Bandana Options Page */
			if( $hook === 'appearance_page_bandana-options' ) {
				
				/** Load Admin Stylesheet */
				wp_enqueue_style( 'bandana-admin-css-style' );
				
				/** Load Admin Scripts */
				wp_enqueue_script( 'bandana-admin-js-bandana' );
				wp_enqueue_script( 'bandana-admin-js-jquery-cookie' );
				
			}
				
		}
		
		/** Configure settings Sections and Fileds */		
		function settings_sections() {
		
			/** Blog Section */
			add_settings_section( 'bandana_section_blog', 'Blog Options', array( &$this, 'bandana_section_blog_fn' ), 'bandana_section_blog_page' );			
			
			add_settings_field( 'bandana_field_nav_style', __( 'Navigation Style', 'bandana' ), array( &$this, 'bandana_field_nav_style_fn' ), 'bandana_section_blog_page', 'bandana_section_blog' );
			
			/** Post Section */
			add_settings_section( 'bandana_section_post', 'Post Options', array( &$this, 'bandana_section_post_fn' ), 'bandana_section_post_page' );
			
			add_settings_field( 'bandana_field_post_style', __( 'Post Style', 'bandana' ), array( &$this, 'bandana_field_post_style_fn' ), 'bandana_section_post_page', 'bandana_section_post' );
			add_settings_field( 'bandana_field_featured_image_control', __( 'Post Featured Image', 'bandana' ), array( &$this, 'bandana_field_featured_image_control_fn' ), 'bandana_section_post_page', 'bandana_section_post' );
			
			/** Footer Section */
			add_settings_section( 'bandana_section_footer', 'Footer Options', array( &$this, 'bandana_section_footer_fn' ), 'bandana_section_footer_page' );
			
			add_settings_field( 'bandana_field_copyright_control', __( 'Use Copyright', 'bandana' ), array( &$this, 'bandana_field_copyright_control_fn' ), 'bandana_section_footer_page', 'bandana_section_footer' );
			add_settings_field( 'bandana_field_copyright', __( 'Enter Copyright Text', 'bandana' ), array( &$this, 'bandana_field_copyright_fn' ), 'bandana_section_footer_page', 'bandana_section_footer' );
			
			/** General Section */
			add_settings_section( 'bandana_section_general', 'General Options', array( &$this, 'bandana_section_general_fn' ), 'bandana_section_general_page' );
			
			add_settings_field( 'bandana_field_reset_control', __( 'Reset Theme Options', 'bandana' ), array( &$this, 'bandana_field_reset_control_fn' ), 'bandana_section_general_page', 'bandana_section_general' );
		
		}
		
		/** Configure Settings */
		function settings_default() {

			$bandana_options = get_option( 'bandana_options' );
			if( !is_array( $bandana_options ) ) {
				update_option( 'bandana_options', bandana_settings_default() );
			}
		
		}
		
		/** Bandana Pre-defined Range */
		
		/* Boolean Yes | No */		
		function bandana_boolean_pd() {			
			return array( 1 => __( 'yes', 'bandana' ), 0 => __( 'no', 'bandana' ) );		
		}
		
		/* Nav Style Range */		
		function bandana_nav_style_pd() {			
			return array( 'numeric' => __( 'Numeric', 'bandana' ), 'older-newer' => __( 'Older / Newer', 'bandana' ) );			
		}
		
		/* Post Style Range */		
		function bandana_post_style_pd() {			
			return array( 'content' => __( 'Content', 'bandana' ), 'excerpt' => __( 'Excerpt', 'bandana' ) );			
		}
		
		/* Featured Image Range */		
		function bandana_featured_image_pd() {			
			return array( 'manual' => __( 'Use Featured Image', 'bandana' ), 'auto' => __( 'Use Featured Image Automatically', 'bandana' ), 'no' => __( 'No Featured Image', 'bandana' ) );			
		}		
		
		/** Bandana Options Validation */				
		function bandana_options_validate( $input ) {
			
			/** Default */
			$default = bandana_settings_default();

			/** Bandana Predefined */
			$bandana_boolean_pd = $this->bandana_boolean_pd();
			$bandana_nav_style_pd = $this->bandana_nav_style_pd();
			$bandana_post_style_pd = $this->bandana_post_style_pd();
			$bandana_featured_image_pd = $this->bandana_featured_image_pd();						
			
			/* Validation: bandana_nav_style */
			if ( ! array_key_exists( $input['bandana_nav_style'], $bandana_nav_style_pd ) ) {
				 $input['bandana_nav_style'] = $default['bandana_nav_style'];
			}
			
			/* Validation: bandana_post_style */			
			if ( ! array_key_exists( $input['bandana_post_style'], $bandana_post_style_pd ) ) {
				 $input['bandana_post_style'] = $default['bandana_post_style'];
			}
			
			/* Validation: bandana_featured_image_control */			
			if ( ! array_key_exists( $input['bandana_featured_image_control'], $bandana_featured_image_pd ) ) {
				 $input['bandana_featured_image_control'] = $default['bandana_featured_image_control'];
			}										
			
			/* Validation: bandana_copyright_control */			
			if ( ! array_key_exists( $input['bandana_copyright_control'], $bandana_boolean_pd ) ) {
				 $input['bandana_copyright_control'] = $default['bandana_copyright_control'];
			}
			
			/* Validation: bandana_copyright */
			if( !empty( $input['bandana_copyright'] ) ) {
				$input['bandana_copyright'] = htmlspecialchars ( $input['bandana_copyright'] );
			}
			
			/* Validation: bandana_reset_control */
			if ( ! array_key_exists( $input['bandana_reset_control'], $bandana_boolean_pd ) ) {
				 $input['bandana_reset_control'] = $default['bandana_reset_control'];
			}

			/** Reset Logic */
			if( $input['bandana_reset_control'] == 1 ) {
				$input = $default;
			}			
			
			return $input;
		
		}
		
		/** Blog Section Callback */				
		function bandana_section_blog_fn() {
			echo '<div class="bandana-section-desc">
			  <p class="description">'. __( 'Customize your blog by using the following settings.', 'bandana' ) .'</p>
			</div>';
		}
		
		/* Nav Style Callback */		
		function bandana_field_nav_style_fn() {
			
			$bandana_options = bandana_get_settings();
			$items = $this->bandana_nav_style_pd();
			
			echo '<select id="bandana_nav_style" name="bandana_options[bandana_nav_style]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_nav_style'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select navigation style.', 'bandana' ) .'</small></div>';
		
		}

		/** Post Section Callback */				
		function bandana_section_post_fn() {
			echo '<div class="bandana-section-desc">
			  <p class="description">'. __( 'Customize your posts by using the following settings.', 'bandana' ) .'</p>
			</div>';
		}
		
		/* Post Style Callback */		
		function bandana_field_post_style_fn() {
			
			$bandana_options = bandana_get_settings();
			$items = $this->bandana_post_style_pd();
			
			echo '<select id="bandana_post_style" name="bandana_options[bandana_post_style]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_post_style'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select post style.', 'bandana' ) .'</small></div>';
		
		}
		
		/* Featured Image Callback */		
		function bandana_field_featured_image_control_fn() {
			
			$bandana_options = bandana_get_settings();
			$items = $this->bandana_featured_image_pd();
			
			echo '<select id="bandana_featured_image_control" name="bandana_options[bandana_featured_image_control]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_featured_image_control'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( '<strong>Use Featured Image:</strong> which is set in the post.', 'bandana' ) .'</small></div>';
			echo '<div><small>'. __( '<strong>Use Featured Image Automatically:</strong> from the images uploaded to the post.', 'bandana' ) .'</small></div>';
			echo '<div><small>'. __( '<strong>No Featured Image:</strong> for the post.', 'bandana' ) .'</small></div>';
		
		}
		
		/** Footer Section Callback */				
		function bandana_section_footer_fn() {
			echo '<div class="bandana-section-desc">
			  <p class="description">'. __( 'Customize your footer by using the following settings.', 'bandana' ) .'</p>
			</div>';
		}
		
		/* Copyright Control Callback */		
		function  bandana_field_copyright_control_fn() {
			
			$bandana_options = bandana_get_settings();
			$items = $this->bandana_boolean_pd();
			
			echo '<select id="bandana_copyright_control" name="bandana_options[bandana_copyright_control]">';
			foreach( $items as $key => $val ) {
			?>
            <option value="<?php echo $key; ?>" <?php selected( $key, $bandana_options['bandana_copyright_control'] ); ?>><?php echo $val; ?></option>
            <?php
			}
			echo '</select>';
			echo '<div><small>'. __( 'Select yes to override default copyright text.', 'bandana' ) .'</small></div>';
		
		}
		
		/* Copyright Callback */
		function bandana_field_copyright_fn() {
			
			$bandana_options = bandana_get_settings();
			echo '<textarea type="textarea" id="bandana_copyright" name="bandana_options[bandana_copyright]" rows="7" cols="50">'. esc_html ( $bandana_options['bandana_copyright'] ) .'</textarea>';
			echo '<div><small>'. __( 'Enter the copyright text.', 'bandana' ) .'</small></div>';
			echo '<div><small>Example: <strong>&amp;copy; Copyright '.date('Y').' - &lt;a href="'. esc_url( home_url( '/' ) ) .'"&gt;'. get_bloginfo('name') .'&lt;/a&gt;</strong></small></div>';
		
		}
		
		/** General Section Callback */				
		function bandana_section_general_fn() {
			echo '<div class="bandana-section-desc">
			  <p class="description">'. __( 'Here are the general settings to customize your blog.', 'bandana' ) .'</p>
			</div>';
		}
		
		/* Reset Congrol Callback */		
		function bandana_field_reset_control_fn() {
			
			$bandana_options = bandana_get_settings();			
			$items = $this->bandana_boolean_pd();			
			echo '<label><input type="checkbox" id="bandana_reset_control" name="bandana_options[bandana_reset_control]" value="1" /> '. __( 'Reset Theme Options.', 'bandana' ) .'</label>';
		
		}
}

/** Initiate Admin */
new BandanaAdmin();