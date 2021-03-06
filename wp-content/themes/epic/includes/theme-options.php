<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * SDS Theme Options
 *
 * Description: This Class instantiates the SDS Options Panel providing themes with various options to use.
 *
 * @version 1.2
 */
if ( ! class_exists( 'SDS_Theme_Options' ) ) {
	global $sds_theme_options;

	class SDS_Theme_Options {
		const VERSION = '1.2';

		// Private Variables
		private static $instance; // Keep track of the instance
		private static $options_page_description = 'Customize your theme to the fullest extent by using the options below.'; // Options Page description shown below title

		// Public Variables
		public $option_defaults;
		public $theme;
		public $child_theme;
		public $child_themes;

		/*
		 * Function used to create instance of class.
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) )
				self::$instance = new SDS_Theme_Options;

			return self::$instance;
		}

		/**
		 * These functions calls and hooks are added on new instance.
		 */
		function __construct() {
			$this->option_defaults = $this->get_sds_theme_option_defaults();
			$this->theme = $this->get_parent_theme();
			$this->child_theme = $this->get_child_theme();
			$this->child_themes = $this->get_child_themes();

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) ); // Enqueue Theme Options Stylesheet
			add_action( 'admin_menu', array( $this, 'admin_menu' ) ); // Register Appearance Menu Item
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ),999 ); // Add Theme Options Menu to Toolbar
			add_action( 'admin_init', array( $this, 'admin_init' ) ); // Register Settings, Settings Sections, and Settings Fields
			add_filter( 'wp_redirect', array( $this, 'wp_redirect' ) ); // Add "hash" (tab) to URL before re-direct
		}


		/**
		 * This function enqueues our theme options stylesheet, WordPress media upload scripts, and our custom upload script only on our options page in admin.
		 */
		function admin_enqueue_scripts( $hook ) {
			if ( $hook === 'appearance_page_sds-theme-options' ) {
				$protocol = is_ssl() ? 'https' : 'http';

				wp_enqueue_style( 'sds-theme-options', get_template_directory_uri() . '/includes/css/sds-theme-options.css', false, self::VERSION );

				wp_enqueue_media(); // Enqueue media scripts
				wp_enqueue_script( 'sds-theme-options', get_template_directory_uri() . '/includes/js/sds-theme-options.js', array( 'jquery' ), self::VERSION );

				// Web Fonts
				if ( function_exists( 'sds_web_fonts' ) ) {
					$google_families = $this->get_google_font_families_list();

					wp_enqueue_style( 'google-web-fonts', $protocol . '://fonts.googleapis.com/css?family=' . $google_families, false, self::VERSION );
				}
			}
		}

		/**
		 * This function adds a menu item under "Appearance" in the Dashboard.
		 */
		function admin_menu() {
			add_theme_page( __( 'Theme Options', 'epic' ), __( 'Theme Options', 'epic' ), 'edit_theme_options', 'sds-theme-options', array( $this, 'sds_theme_options_page' ) );
		}

		/**
		 * This function adds a new menu to the Toolbar under the appearance parent group on the front-end.
		 */
		function admin_bar_menu( $wp_admin_bar ) {
			// Make sure we're on the front end and that the current user can either switch_themes or edit_theme_options
			if ( ! is_admin() && ( current_user_can( 'switch_themes' ) || current_user_can( 'edit_theme_options' ) ) ) 
				$wp_admin_bar->add_menu( array(
					'parent' => 'appearance',
					'id'  => 'sds-theme-options',
					'title' => __( 'Theme Options', 'epic' ),
					'href' => admin_url( 'themes.php?page=sds-theme-options' ),
					'meta' => array(
						'class' => 'sds-theme-options'
					)
				) );
		}

		/**
		 * This function registers our setting, settings sections, and settings fields.
		 */
		function admin_init() {
			//Register Setting
			register_setting( 'sds_theme_options', 'sds_theme_options', array( $this, 'sds_theme_options_sanitize' ) );


			/*
			 * General Settings (belong to the sds-theme-options[general] "page", used during page render to display section in tab format)
			 */

			// Logo
			add_settings_section( 'sds_theme_options_logo_section', __( 'Upload A Logo', 'epic'), array( $this, 'sds_theme_options_logo_section' ), 'sds-theme-options[general]' );
			add_settings_field( 'sds_theme_options_logo_field', __( 'Logo:', 'epic'), array( $this, 'sds_theme_options_logo_field' ), 'sds-theme-options[general]', 'sds_theme_options_logo_section' );
			
			// Hide Tagline
			add_settings_section( 'sds_theme_options_hide_tagline_section', __( 'Show/Hide Site Tagline', 'epic'), array( $this, 'sds_theme_options_hide_tagline_section' ), 'sds-theme-options[general]' );
			add_settings_field( 'sds_theme_options_hide_tagline_field', __( 'Show or Hide Site Tagline:', 'epic'), array( $this, 'sds_theme_options_hide_tagline_field' ), 'sds-theme-options[general]', 'sds_theme_options_hide_tagline_section' );

			// Color Schemes (if specified by theme)
			if ( function_exists( 'sds_color_schemes' ) ) {
				add_settings_section( 'sds_theme_options_color_schemes_section', __( 'Color Scheme', 'epic'), array( $this, 'sds_theme_options_color_schemes_section' ), 'sds-theme-options[general]' );
				add_settings_field( 'sds_theme_options_color_schemes_field', __( 'Select A Color Scheme:', 'epic'), array( $this, 'sds_theme_options_color_schemes_field' ), 'sds-theme-options[general]', 'sds_theme_options_color_schemes_section' );
			}

			// Google Web Fonts (if specified by theme)
			if ( function_exists( 'sds_web_fonts' ) ) {
				add_settings_section( 'sds_theme_options_web_fonts_section', __( 'Web Fonts', 'epic'), array( $this, 'sds_theme_options_web_fonts_section' ), 'sds-theme-options[general]' );
				add_settings_field( 'sds_theme_options_web_fonts_field', __( 'Select A Web Font:', 'epic'), array( $this, 'sds_theme_options_web_fonts_field' ), 'sds-theme-options[general]', 'sds_theme_options_web_fonts_section' );
			}


			/*
			 * Social Media Settings (belong to the sds-theme-options[social-media] "page", used during page render to display section in tab format)
			 */

 			add_settings_section( 'sds_theme_options_social_media_section', __( 'Social Media', 'epic'), array( $this, 'sds_theme_options_social_media_section' ), 'sds-theme-options[social-media]' );
			add_settings_field( 'sds_theme_options_social_media_facebook_url_field', __( 'Facebook:', 'epic'), array( $this, 'sds_theme_options_social_media_facebook_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_twitter_url_field', __( 'Twitter:', 'epic'), array( $this, 'sds_theme_options_social_media_twitter_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_linkedin_url_field', __( 'LinkedIn:', 'epic'), array( $this, 'sds_theme_options_social_media_linkedin_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_google_plus_url_field', __( 'Google+:', 'epic'), array( $this, 'sds_theme_options_social_media_google_plus_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_youtube_url_field', __( 'YouTube:', 'epic'), array( $this, 'sds_theme_options_social_media_youtube_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_vimeo_url_field', __( 'Vimeo:', 'epic'), array( $this, 'sds_theme_options_social_media_vimeo_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_instagram_url_field', __( 'Instagram:', 'epic'), array( $this, 'sds_theme_options_social_media_instagram_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_pinterest_url_field', __( 'Pinterest:', 'epic'), array( $this, 'sds_theme_options_social_media_pinterest_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_flickr_url_field', __( 'Flickr:', 'epic'), array( $this, 'sds_theme_options_social_media_flickr_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			//add_settings_field( 'sds_theme_options_social_media_yelp_url_field', __( 'Yelp:', 'epic'), array( $this, 'sds_theme_options_social_media_yelp_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_foursquare_url_field', __( 'Foursquare:', 'epic'), array( $this, 'sds_theme_options_social_media_foursquare_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
			add_settings_field( 'sds_theme_options_social_media_rss_url_field', __( 'RSS:', 'epic'), array( $this, 'sds_theme_options_social_media_rss_url_field' ), 'sds-theme-options[social-media]', 'sds_theme_options_social_media_section' );
		}

		/**
		 * This function is the callback for the logo settings section.
		 */
		function sds_theme_options_logo_section() {
		?>
			<p>
				<?php
					$sds_logo_dimensions = apply_filters( 'sds_theme_options_logo_dimensions', '300x100' );
					printf( __( 'Upload a logo to to replace the site name. Recommended dimensions: %1$s.', 'epic' ), $sds_logo_dimensions );
				?>
			</p>
		<?php
		}

		/**
		 * This function is the callback for the logo settings field.
		 */
		function sds_theme_options_logo_field() {
			global $sds_theme_options;
		?>
			<strong><?php _e( 'Current Logo:', 'epic' ); ?></strong>
			<div class="sds-theme-options-preview sds-theme-options-logo-preview">
				<?php
					if ( isset( $sds_theme_options['logo_attachment_id'] ) && $sds_theme_options['logo_attachment_id'] ) :
						echo wp_get_attachment_image( $sds_theme_options['logo_attachment_id'], 'full' );
					else :
				?>
						<div class="description"><?php _e( 'No logo selected.', 'epic' ); ?></div>
				<?php endif; ?>
			</div>

			<input type="hidden" id="sds_theme_options_logo" class="sds-theme-options-upload-value" name="sds_theme_options[logo_attachment_id]"  value="<?php echo ( isset( $sds_theme_options['logo_attachment_id'] ) && ! empty( $sds_theme_options['logo_attachment_id'] ) ) ? esc_attr( $sds_theme_options['logo_attachment_id'] ) : false; ?>" />
			<input id="sds_theme_options_logo_attach" class="button-primary sds-theme-options-upload" name="sds_theme_options_logo_attach"  value="<?php esc_attr_e( 'Select or Upload Logo', 'epic' ); ?>" data-media-title="Choose A Logo" data-media-button-text="Use As Logo" />
			<?php submit_button( __( 'Remove Logo', 'epic' ), array( 'secondary', 'button-remove-logo' ), 'sds_theme_options[remove-logo]', false, ( ! isset( $sds_theme_options['logo_attachment_id'] ) || empty( $sds_theme_options['logo_attachment_id'] ) ) ? array( 'disabled' => 'disabled', 'data-init-empty' => 'true' ) : false ); ?>
		<?php
		}

		
		/**
		 * This function is the callback for the show/hide tagline settings section.
		 */
		function sds_theme_options_hide_tagline_section() {
		?>
			<p><?php _e( 'Use this option to show or hide the site tagline.', 'epic' ); ?></p>
		<?php
		}

		/**
		 * This function is the callback for the show/hide tagline settings field.
		 */
		function sds_theme_options_hide_tagline_field() {
			global $sds_theme_options;
		?>
			<div class="checkbox sds-theme-options-checkbox checkbox-show-hide-tagline" data-label-left="<?php esc_attr_e( 'Show', 'epic' ); ?>" data-label-right="<?php esc_attr_e( 'Hide', 'epic' ); ?>">
				<input type="checkbox" id="sds_theme_options_hide_tagline" name="sds_theme_options[hide_tagline]" <?php ( isset( $sds_theme_options['hide_tagline'] ) ) ? checked( $sds_theme_options['hide_tagline'] ) : checked( false ); ?> />
				<label for="sds_theme_options_hide_tagline">| | |</label>
			</div>
			<span class="description"><?php _e( 'When "show" is displayed, the tagline will be displayed on your site and vise-versa.', 'epic' ); ?></span>
		<?php
		}

		
		/**
		 * This function is the callback for the color schemes settings section.
		 */
		function sds_theme_options_color_schemes_section() {
		?>
			<p><?php _e( 'Select a color scheme to use on your site.', 'epic' ); ?></p>
		<?php
		}

		/**
		 * This function is the callback for the color schemes settings field.
		 */
		function sds_theme_options_color_schemes_field() {
			global $sds_theme_options;

			$color_schemes = sds_color_schemes();

			if ( ! empty( $color_schemes ) ) :
		?>
			<div class="sbt-theme-options-color-schemes-wrap">
				<?php foreach( $color_schemes as $name => $atts ) :	?>
					<div class="sbt-theme-options-color-scheme sbt-theme-options-color-scheme-<?php echo $name; ?>">
						<label>
							<?php if ( ( ! isset( $sds_theme_options['color_scheme'] ) || empty( $sds_theme_options['color_scheme'] ) ) && isset( $atts['default'] ) && $atts['default'] ) : // No color scheme selected, use default ?>
								<input type="radio" id="sds_theme_options_color_scheme_<?php echo $name; ?>" name="sds_theme_options[color_scheme]" <?php checked( true ); ?> value="<?php echo $name; ?>" />
							<?php else: ?>
								<input type="radio" id="sds_theme_options_color_scheme_<?php echo $name; ?>" name="sds_theme_options[color_scheme]" <?php ( isset( $sds_theme_options['color_scheme'] ) ) ? checked( $sds_theme_options['color_scheme'], $name ) : checked( false ); ?> value="<?php echo $name; ?>" />
							<?php endif;?>

							<?php if ( isset( $atts['preview'] ) && ! empty( $atts['preview'] ) ) : ?>
								<div class="sbt-theme-options-color-scheme-preview" style="background: <?php echo $atts['preview']; ?>">&nbsp;</div>
							<?php endif; ?>

							<?php echo ( isset( $atts['label'] ) ) ? $atts['label'] : false; ?>
						</label>
					</div>
				<?php endforeach; ?>

				<?php do_action( 'sds_theme_options_upgrade_cta', 'color-schemes' ); ?>
			</div>
		<?php
			endif;
		}

		
		/**
		 * This function is the callback for the web fonts settings section.
		 */
		function sds_theme_options_web_fonts_section() {
		?>
			<p><?php _e( 'Select a Google Web Font to use on your site.', 'epic' ); ?></p>
		<?php
		}

		/**
		 * This function is the callback for the web fonts settings field.
		 */
		function sds_theme_options_web_fonts_field() {
			global $sds_theme_options;

			$web_fonts = sds_web_fonts();

			if ( ! empty( $web_fonts ) ) :
		?>
			<div class="sbt-theme-options-web-fonts-wrap">
				<div class="sbt-theme-options-web-font sbt-theme-options-web-font-none">
						<label>
							<input type="radio" id="sds_theme_options_web_font_none" name="sds_theme_options[web_font]" <?php ( ! isset( $sds_theme_options['web_font'] ) || empty( $sds_theme_options['web_font'] ) || $sds_theme_options['web_font'] === 'none' ) ? checked( true ) : checked( false ); ?> value="none" />
							<div class="sbt-theme-options-web-font-selected">&#10004;</div>
						</label>
						<span class="sds-theme-options-web-font-label-none"><?php _e( 'None', 'epic' ); ?></span>
				</div>

				<?php
					foreach( $web_fonts as $name => $atts ) :
						$css_name = strtolower( str_replace( array( '+'. ':' ), '-', $name) );
				?>
						<div class="sbt-theme-options-web-font sbt-theme-options-web-font-<?php echo $css_name; ?>" style="<?php echo ( isset( $atts['css'] ) && ! empty( $atts['css'] ) ) ? $atts['css'] : false; ?>">
							<label>
								<input type="radio" id="sds_theme_options_web_font_name_<?php echo $css_name; ?>" name="sds_theme_options[web_font]" <?php ( isset( $sds_theme_options['web_font'] ) ) ? checked( $sds_theme_options['web_font'], $name ) : checked( false ); ?> value="<?php echo $name; ?>" />
								<div class="sbt-theme-options-web-font-selected">&#10004;</div>
							</label>
							<span class="sds-theme-options-web-font-label"><?php echo ( isset( $atts['label'] ) ) ? $atts['label'] : false; ?></span>
							<span class="sds-theme-options-web-font-preview"><?php _e( 'Grumpy wizards make toxic brew for the evil Queen and Jack.', 'epic' ); ?></span>
						</div>
				<?php
					endforeach;
				?>

				<?php do_action( 'sds_theme_options_upgrade_cta', 'web-fonts' ); ?>
			</div>
		<?php
			endif;
		}

		
		/**
		 * This function is the callback for the social media settings section.
		 */
		function sds_theme_options_social_media_section() { ?>
			<p><?php _e( 'Enter your social media links here. This section is used throughout the site to display social media links to visitors. Some themes display social media links automatically, and some only display them within the Social Media widget.', 'epic' ); ?></p>
		<?php
		}
		
		/**
		 * This function is the callback for the facebook url settings field.
		 */
		function sds_theme_options_social_media_facebook_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_facebook_url" name="sds_theme_options[social_media][facebook_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['facebook_url'] ) && ! empty( $sds_theme_options['social_media']['facebook_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['facebook_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the twitter url settings field.
		 */
		function sds_theme_options_social_media_twitter_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_twitter_url" name="sds_theme_options[social_media][twitter_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['twitter_url'] ) && ! empty( $sds_theme_options['social_media']['twitter_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['twitter_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the linkedin url settings field.
		 */
		function sds_theme_options_social_media_linkedin_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_linkedin_url" name="sds_theme_options[social_media][linkedin_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['linkedin_url'] ) && ! empty( $sds_theme_options['social_media']['linkedin_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['linkedin_url'] ) ) : false; ?>" />
		<?php
		}

		/**
		 * This function is the callback for the google_plus url settings field.
		 */
		function sds_theme_options_social_media_google_plus_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_google_plus_url" name="sds_theme_options[social_media][google_plus_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['google_plus_url'] ) && ! empty( $sds_theme_options['social_media']['google_plus_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['google_plus_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the youtube url settings field.
		 */
		function sds_theme_options_social_media_youtube_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_youtube_url" name="sds_theme_options[social_media][youtube_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['youtube_url'] ) && ! empty( $sds_theme_options['social_media']['youtube_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['youtube_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the vimeo url settings field.
		 */
		function sds_theme_options_social_media_vimeo_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_vimeo_url" name="sds_theme_options[social_media][vimeo_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['vimeo_url'] ) && ! empty( $sds_theme_options['social_media']['vimeo_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['vimeo_url'] ) ) : false; ?>" />
		<?php
		}

		/**
		 * This function is the callback for the instagram url settings field.
		 */
		function sds_theme_options_social_media_instagram_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_instagram_url" name="sds_theme_options[social_media][instagram_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['instagram_url'] ) && ! empty( $sds_theme_options['social_media']['instagram_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['instagram_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the pinterest url settings field.
		 */
		function sds_theme_options_social_media_pinterest_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_pinterest_url" name="sds_theme_options[social_media][pinterest_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['pinterest_url'] ) && ! empty( $sds_theme_options['social_media']['pinterest_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['pinterest_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the flickr url settings field.
		 */
		function sds_theme_options_social_media_flickr_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_flickr_url" name="sds_theme_options[social_media][flickr_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['flickr_url'] ) && ! empty( $sds_theme_options['social_media']['flickr_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['flickr_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the yelp url settings field.
		 */
		function sds_theme_options_social_media_yelp_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_yelp_url" name="sds_theme_options[social_media][yelp_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['yelp_url'] ) && ! empty( $sds_theme_options['social_media']['yelp_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['yelp_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the foursquare url settings field.
		 */
		function sds_theme_options_social_media_foursquare_url_field() {
			global $sds_theme_options;
		?>
			<input type="text" id="sds_theme_options_social_media_foursquare_url" name="sds_theme_options[social_media][foursquare_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['foursquare_url'] ) && ! empty( $sds_theme_options['social_media']['foursquare_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['foursquare_url'] ) ) : false; ?>" />
		<?php
		}
		
		/**
		 * This function is the callback for the rss url settings field.
		 */
		function sds_theme_options_social_media_rss_url_field() {
			global $sds_theme_options;
		?>
			<strong><?php _e( 'Use Site RSS Feed:', 'epic' ); ?></strong>
			<div class="checkbox sds-theme-options-checkbox checkbox-social_media-rss_url-use-site-feed" data-label-left="<?php esc_attr_e( 'Yes', 'epic' ); ?>" data-label-right="<?php esc_attr_e( 'No', 'epic' ); ?>">
				<input type="checkbox" id="sds_theme_options_social_media_rss_url_use_site_feed" name="sds_theme_options[social_media][rss_url_use_site_feed]" <?php ( isset( $sds_theme_options['social_media']['rss_url_use_site_feed'] ) ) ? checked( $sds_theme_options['social_media']['rss_url_use_site_feed'] ) : checked( false ); ?> />
				<label for="sds_theme_options_social_media_rss_url_use_site_feed">| | |</label>
			</div>
			<span class="description"><?php _e( 'When "yes" is displayed, the RSS feed for your site will be used.', 'epic' ); ?></span>

			<div id="sds_theme_options_social_media_rss_url_custom">
				<strong><?php _e( 'Custom RSS Feed:', 'epic' ); ?></strong>
				<input type="text" id="sds_theme_options_social_media_rss_url" name="sds_theme_options[social_media][rss_url]" class="large-text" value="<?php echo ( isset( $sds_theme_options['social_media']['rss_url'] ) && ! empty( $sds_theme_options['social_media']['rss_url'] ) ) ? esc_attr( esc_url( $sds_theme_options['social_media']['rss_url'] ) ) : false; ?>" />
			</div>
		<?php
		}


		/**
		 * This function sanitizes input from the user when saving options.
		 */
		function sds_theme_options_sanitize( $input ) {
			// Reset to Defaults
			if ( isset( $input['reset'] ) )
				$input = $this->get_sds_theme_option_defaults();

			// Remove Logo
			if ( isset( $input['remove-logo'] ) )
				$input['logo_attachment_id'] = false;

			// Parse arguments, replacing defaults with user input
			$input = wp_parse_args( $input, $this->get_sds_theme_option_defaults() );

			// General
			$input['logo_attachment_id'] = ( ! empty( $input['logo_attachment_id'] ) ) ? ( int ) $input['logo_attachment_id'] : '';
			$input['color_scheme'] = sanitize_text_field( $input['color_scheme'] );
			$input['web_font'] = ( ! empty( $input['web_font'] ) && $input['web_font'] !== 'none' ) ? sanitize_text_field( $input['web_font'] ) : false;
			$input['hide_tagline'] = ( $input['hide_tagline'] ) ? true : false;

			// Social media
			foreach ( $input['social_media'] as $key => &$value ) {
				// RSS Feed (use site feed)
				if ( $key === 'rss_url_use_site_feed' && $value ) {
					$value = true;

					$input['social_media']['rss_url'] = '';
				}
				else
					$value = esc_url( $value );
			}

			// Ensure the 'rss_url_use_site_feed' key is set in social media
			if ( ! isset( $input['social_media']['rss_url_use_site_feed'] ) )
				$input['social_media']['rss_url_use_site_feed'] = false;

			/**
			 * "One-Click" Child Themes
			 */

			// Create child theme
			if ( isset( $input['create_child_theme'] ) ) {
				$theme_root = trailingslashit( get_theme_root() );
				$child_theme_name = ( isset( $input['child_theme']['name'] ) ) ? sanitize_title( $input['child_theme']['name'] ) : false;
				$child_theme_directory = trailingslashit( $theme_root . $child_theme_name );
				$child_theme_stylesheet_header = $this->create_stylesheet_header( sanitize_text_field( $input['child_theme']['name'] ) );

				// Make sure we have a valid theme name
				if ( empty( $child_theme_name ) ) {
					add_settings_error( 'sds_theme_options', 'child-theme-name-invalid', __( 'Please enter a valid child theme name.', 'epic' ) );

					return $input;
				}
				// Make sure the requested child theme does not already exist
				else if ( file_exists( $theme_root . $child_theme_name ) ) {
					add_settings_error( 'sds_theme_options', 'child-theme-exists', __( 'It appears that a child theme with that name already exists. Please try again with a different child theme name.', 'epic' ) );

					return $input;
				}
				// Make sure child theme creation didn't fail
				else if ( ! $this->create_child_theme( $child_theme_directory, $child_theme_stylesheet_header, $theme_root ) ) {
					add_settings_error( 'sds_theme_options', 'child-theme-creation-failed', __( 'There was a problem creating the child theme. Please check your server permissions.', 'epic' ) );

					return $input;
				}
				// Child theme was created successfully
				else {
					// Activate the child theme
					if ( isset( $input['child_theme']['activate'] ) ) {
						// Store widgets and menus
						$sidebar_widgets = wp_get_sidebars_widgets();
						$menu_locations = get_nav_menu_locations();

						// Activate child theme (if requested)
						$this->activate_child_theme( $child_theme_name );

						// Carry over widgets and menus to child theme
						set_theme_mod( 'nav_menu_locations', $menu_locations );
						wp_set_sidebars_widgets( $sidebar_widgets );

						add_settings_error( 'sds_theme_options', 'child-theme-activation-success', sprintf( __( 'New theme activated. <a href="%s">Visit site</a> or <a href="%s">edit child theme</a>.', 'epic' ), home_url( '/' ), admin_url( 'theme-editor.php?theme=' . urlencode( $child_theme_name ) ) ), 'updated' );
					}
					else
						add_settings_error( 'sds_theme_options', 'child-theme-creation-success', sprintf( __( 'Child theme created successfully. <a href="%s">Activate</a> your child theme.', 'epic' ), wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $child_theme_name ) ), 'switch-theme_' . $child_theme_name ) ), 'updated' );
				}
			}


			return $input;
		}


		/**
		 * This function handles the rendering of the options page.
		 */
		function sds_theme_options_page() {
		?>
			<div class="wrap about-wrap">
				<h1><?php echo wp_get_theme(); ?> <?php _e( 'Theme Options', 'epic' ); ?></h1>
				<div class="about-text sds-about-text"><?php printf( _x( '%1$s', 'Theme options panel descripton', 'epic' ), self::$options_page_description ); ?></div>

				<?php do_action( 'sds_theme_options_notifications' ); ?>

				<?php settings_errors(); ?>

				<h2 class="nav-tab-wrapper sds-theme-options-tab-wrap">
					<a href="#general" id="general-tab" class="nav-tab sds-theme-options-tab nav-tab-active"><?php _e( 'General Options', 'epic' ); ?></a>
					<a href="#social-media" id="social-media-tab" class="nav-tab sds-theme-options-tab"><?php _e( 'Social Media', 'epic' ); ?></a>
					<a href="#one-click-child-themes" id="one-click-child-themes-tab" class="nav-tab sds-theme-options-tab"><?php _e( 'One-Click Child Themes', 'epic' ); ?></a>
					<?php do_action( 'sds_theme_options_navigation_tabs' ); // Hook for extending tabs ?>
					<a href="#help-support" id="help-support-tab" class="nav-tab sds-theme-options-tab"><?php _e( 'Help/Support', 'epic' ); ?></a>
				</h2>

				<form method="post" action="options.php" enctype="multipart/form-data" id="sds-theme-options-form">
					<?php settings_fields( 'sds_theme_options' ); ?>
					<input type="hidden" name="sds_theme_options_tab" id="sds_theme_options_tab" value="" />

					<?php
					/*
					 * General Settings
					 */
					?>
					<div id="general-tab-content" class="sds-theme-options-tab-content sds-theme-options-tab-content-active">
						<?php do_settings_sections( 'sds-theme-options[general]' ); ?>
					</div>

					<?php
					/*
					 * Social Media Settings
					 */
					?>
					<div id="social-media-tab-content" class="sds-theme-options-tab-content">
						<?php do_settings_sections( 'sds-theme-options[social-media]' ); ?>
					</div>

					<?php
					/*
					 * "One-Click" Child Themes
					 */
					?>
					<div id="one-click-child-themes-tab-content" class="sds-theme-options-tab-content">
						<h3><?php _e( '"One-Click" Child Themes', 'epic' ); ?></h3>

						<?php if ( ! $this->get_child_theme_activation_status() && is_child_theme() ) : // Child theme is currently active ?>
							<div class="message error sds-child-themes-message" style="border-left: 4px solid #ffba00; display: none !important;">
								<p><strong><?php _e( 'Please Note: It looks like you\'re already using a child theme.', 'epic' ); ?></strong></p>
							</div>
						<?php endif; ?>

						<div class="form-table">
							<p><?php printf( __( 'Child themes are an essential part to <a href="%1$s" target="_blank">WordPress theme modification</a>. If you\'re looking to enhance <strong>%2$s</strong> beyond the Theme Options we\'ve provided, you\'ll find the tools to easily create your very own child theme below. It couldn\'t be more simpler.', 'epic' ), 'http://slocumthemes.com/2013/12/how-to-create-a-child-theme/', $this->theme->get( 'Name' ) ); ?></p>

							<?php if ( ! empty( $this->child_themes ) ) : // Child themes exist ?>
								<h4><?php printf( __( 'The following %1$s child themes already exist', 'epic' ), $this->theme->get( 'Name' ) ); ?></h4>
								<ul class="sds-child-themes">
									<?php
										foreach( $this->child_themes as $child_theme ) :
											// Is this child theme currently active?
											if ( is_a( $this->child_theme, 'WP_Theme' ) && $this->child_theme->get_stylesheet() === $child_theme->get_stylesheet() ) :
									?>
												<li><?php printf( _x( '<strong>%1$s (Active)</strong> - <a href="%2$s">Edit</a>', 'Child theme name and edit link', 'epic' ), $child_theme->get( 'Name' ), admin_url( 'theme-editor.php?theme=' . urlencode( $child_theme->get_stylesheet() ) ) ); ?></li>
									<?php
											else:
									?>
												<li><?php printf( _x( '%1$s - <a href="%2$s">Activate</a>', 'Child theme name and activation link', 'epic' ), $child_theme->get( 'Name' ), wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $child_theme->get_stylesheet() ) ), 'switch-theme_' . $child_theme->get_stylesheet() ) ); ?></li>
									<?php
											endif;
										endforeach;
									?>
								</ul>
							<?php endif; ?>
						</div>

						<h3><?php _e( '1. Name Your Child Theme', 'epic' ); ?> <span class="description"><?php _ex( '(required)', 'This field is required', 'epic' ); ?></span></h3>

						<table class="form-table">
							<tr valign="top">
								<th scope="row"><?php _e( 'Child Theme Name:', 'epic' ); ?></th>
								<td>
									<input type="text" id="sds_theme_options_one_click_child_theme_name" name="sds_theme_options[child_theme][name]" class="large-text" value="" placeholder="e.g. <?php echo $this->theme->get( 'Name' ); ?> Child Theme" />
								</td>
							</tr>
						</table>

						<h3><?php _e( '2. Advanced Settings', 'epic' ); ?> <span class="description"><?php _ex( '(optional)', 'This field is optional', 'epic' ); ?></span></h3>

						<table class="form-table">
							<tr valign="top">
								<th scope="row"><?php _e( 'Activate Child Theme:', 'epic' ); ?></th>
								<td>
									<div class="checkbox sds-themes-child-themes-checkbox">
										<input type="checkbox" id="sds_theme_options_one_click_child_theme_activate" name="sds_theme_options[child_theme][activate]" />
										<label for="sds_theme_options_one_click_child_theme_activate"><?php _e( 'Activate child theme once it has been created', 'epic' ); ?></label>
									</div>
									<span class="description"><?php printf( __( 'This option will also keep navigation menus and widgets from %1$s.', 'epic' ), $this->theme->get( 'Name' ) ); ?></span>
								</td>
							</tr>
						</table>

						<p class="one-click-child-theme-submit">
							<?php submit_button( __( 'Create Child Theme', 'epic' ), 'primary', 'sds_theme_options[create_child_theme]', false ); ?>
						</p>
					</div>

					<?php
					/*
					 * Help/Support
					 */
					?>
					<div id="help-support-tab-content" class="sds-theme-options-tab-content">
						<h3><?php _e( 'Help/Support', 'epic' ); ?></h3>

						<?php do_action( 'sds_theme_options_help_support_tab_content' ); ?>
						<?php do_action( 'sds_theme_options_upgrade_cta', 'help-support' ); ?>
					</div>

					<?php do_action( 'sds_theme_options_settings' ); // Hook for extending settings ?>

					<p class="submit">
						<?php submit_button( __( 'Save Options', 'epic' ), 'primary', 'submit', false ); ?>
						<?php submit_button( __( 'Restore Defaults', 'epic' ), 'secondary', 'sds_theme_options[reset]', false ); ?>
					</p>
				</form>

				<div id="sds-theme-options-ads" class="sidebar">
					<div class="sds-theme-options-ad">
						<div class="yt-subscribe">
							<div class="g-ytsubscribe" data-channel="slocumstudio" data-layout="default"></div>
							<script src="https://apis.google.com/js/plusone.js"></script>
						</div>

						<a href="https://twitter.com/slocumstudio" class="twitter-follow-button" data-show-count="false" data-size="large" data-dnt="true">Follow @slocumstudio</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>

					<?php do_action( 'sds_theme_options_ads' ); ?>
				</div>
			</div>
			<?php
		}

		/*
		 * This function appends the hash for the current tab based on POST data.
		 */
		function wp_redirect( $location ) {
			// Append tab "hash" to end of URL
			if ( strpos( $location, 'sds-theme-options' ) !== false && isset( $_POST['sds_theme_options_tab'] ) && $_POST['sds_theme_options_tab'] )
				$location .= $_POST['sds_theme_options_tab'];

			return $location;
		}



		/**
		 * External Functions (functions that can be used outside of this class to retrieve data)
		 */

		/**
		 * This function returns the current option values.
		 */
		public static function get_sds_theme_options() {
			global $sds_theme_options;

			$sds_theme_options = wp_parse_args( get_option( 'sds_theme_options' ), SDS_Theme_Options::get_sds_theme_option_defaults() );

			return $sds_theme_options;
		}



		/**
		 * Internal Functions (functions used internally throughout this class)
		 */

		/**
		 * This function returns default values for SDS Theme Options
		 */
		public static function get_sds_theme_option_defaults() {
			$defaults = array(
				// General
				'logo_attachment_id' => false,
				'color_scheme' => false,
				'hide_tagline' => false,
				'web_font' => false,

				// Social Media
				'social_media' => array(
					'facebook_url' => '',
					'twitter_url' => '',
					'linkedin_url' => '',
					'google_plus_url' => '',
					'youtube_url' => '',
					'vimeo_url' => '',
					'instagram_url' => '',
					'pinterest_url' => '',
					'flickr_url' => '',
					//'yelp_url' => '',
					'foursquare_url' => '',
					'rss_url' => '',
					'rss_url_use_site_feed' => false
				)
			);

			return apply_filters( 'sds_theme_options_defaults', $defaults );
		}

		/**
		 * This function returns a formatted list of Google Web Font families for use when enqueuing styles.
		 */
		function get_google_font_families_list() {
			if ( function_exists( 'sds_web_fonts' ) ) {
				$web_fonts = sds_web_fonts();
				$web_fonts_count = count( $web_fonts );
				$google_families = '';

				if ( ! empty( $web_fonts ) && is_array( $web_fonts ) ) {
					foreach( $web_fonts as $name => $atts ) {
						// Google Font Name
						$google_families .= $name;

						if ( $web_fonts_count > 1 )
							$google_families .= '|';
					}

					// Trim last | when multiple fonts are set
					if ( $web_fonts_count > 1 )
						$google_families = substr( $google_families, 0, -1 );
				}

				return $google_families;
			}
		}

		/**
		 * This function returns the details of the current parent theme.
		 */
		function get_parent_theme() {
			if ( is_a( $this->theme, 'WP_Theme' ) )
				return $this->theme;

			return ( is_child_theme() ) ? wp_get_theme()->parent() : wp_get_theme();
		}

		/**
		 * This function returns the details of the current child theme activated.
		 */
		function get_child_theme() {
			if ( is_a( $this->child_theme, 'WP_Theme' ) )
				return $this->child_theme;

			return ( is_child_theme() ) ? wp_get_theme() : false;
		}

		/**
		 * This function returns an array of existing child themes for the current parent theme.
		 */
		function get_child_themes() {
			if( ! is_a( $this->theme, 'WP_Theme' ) )
				return false;

			$theme_template = $this->theme->get_stylesheet(); // Get current theme directory name
			$wp_themes = wp_get_themes(); // Get all installed themes
			$child_themes = array();

			// Check for child themes
			foreach ( $wp_themes as $theme ) {
				// Child theme of the current active theme and not the current theme
				if ( $theme->get_template() === $theme_template && $theme->get_template() !== $theme->get_stylesheet() )
					$child_themes[] = $theme;
			}

			return ( ! empty( $child_themes ) ) ? $child_themes : false;
		}

		/**
		 * This function creates a stylesheet header.
		 *
		 * @uses get_file_data()
		 */
		function create_stylesheet_header( $theme_name ) {
			// Stylesheet headers to fetch from current theme stylesheet
			$stylesheet_header_data = array(
				'name'        => 'Theme Name',
				'theme_uri'   => 'Theme URI',
				'description' => 'Description',
				'author'      => 'Author',
				'author_uri'  => 'Author URI',
				'version'     => 'Version',
				'license'     => 'License',
				'license_uri' => 'License URI',
				'template'    => 'Template',
			);

			// Fetch stylesheet header
			$stylesheet_header = get_file_data( trailingslashit( $this->theme->get_stylesheet_directory() ) . 'style.css', $stylesheet_header_data );

			// Adjust for child theme data
			$stylesheet_header['name'] = $theme_name;
			$stylesheet_header['description'] = sprintf( __( 'A "one-click" child theme created for %1$s - %2$s', 'epic' ), $this->theme->get( 'Name' ), $stylesheet_header['description'] );
			$stylesheet_header['version'] = '1.0';
			$stylesheet_header['template'] = $this->theme->get_stylesheet();

			// Create child theme stylesheet header
			$child_theme_stylesheet_header = "/**\n";

			foreach ( $stylesheet_header_data as $key => $header )
				$child_theme_stylesheet_header .= " * $header: {$stylesheet_header[$key]}\n";

			$child_theme_stylesheet_header .= " */\n";

			return $child_theme_stylesheet_header;
		}

		/**
		 * This function creates a child theme.
		 * - creates directory
		 * - creates style.css
		 * - creates blank functions.php
		 * - moves screenshot.png
		 *
		 * @uses WP_Filesystem
		 */
		function create_child_theme( $directory, $stylesheet_header, $theme_root ) {
			global $wp_filesystem;

			$parent_directory = trailingslashit( $theme_root . $this->theme->get_stylesheet() );

			// Set up the WordPress filesystem
			WP_Filesystem(); 

			// Create child theme style.css
			if ( $wp_filesystem->mkdir( $directory ) === false )
				return false;

			// Create child theme style.css
			if ( $wp_filesystem->put_contents( $directory . 'style.css', $stylesheet_header ) === false )
				return false;

			// Create blank functions.php
			$wp_filesystem->touch( $directory . 'functions.php' );

			// Move the screenshot from the parent theme
			if ( $wp_filesystem->exists( $parent_directory . 'screenshot.png' ) )
				$wp_filesystem->copy( $parent_directory . 'screenshot.png', $directory . 'screenshot.png' );

			return true;
		}

		/**
		 * This function activates a child theme.
		 *
		 * @uses switch_theme()
		 */
		function activate_child_theme( $theme ) {
			switch_theme( $theme );
		}

		/**
		 * This function checks to see if a child theme was just activated through the options panel.
		 *
		 * @uses get_settings_errors()
		 */
		function get_child_theme_activation_status() {
			$settings_errors = get_settings_errors();

			// If a settings error exists, child theme was just activated
			if ( ! empty( $settings_errors ) )
				foreach( $settings_errors as $error )
					if ( $error['code'] == 'child-theme-activation-success' )
						return true;

			return false;
		}
	}


	function SDS_Theme_Options_Instance() {
		return SDS_Theme_Options::instance();
	}

	// Instantiate SDS_Theme_Options
	SDS_Theme_Options_Instance();
}