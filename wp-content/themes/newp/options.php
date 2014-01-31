<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'newp'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$options = array();
	
	//Basic Settings
	
	$options[] = array(
		'name' => __('Basic Settings', 'newp'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Logo', 'newp'),
		'desc' => __('A Logo of Maximum Dimension 350px by 50px to be show instead of default title and desc.', 'newp'),
		'id' => 'logo1',
		'class' => '',
		'type' => 'upload');	

	$options[] = array(
		'desc' => __('To have more customization options including Favicon, Responsive Design, etc. <a href="http://rohitink.com/product/newp-pro/" target="_blank">Upgrade to Pro</a> at Just $12.95. Pro Version also allows you to choose from over 640 fonts for this site.'),
		'std' => '',
		'type' => 'info');	

	$options[] = array(
		'name' => __('Custom Code in Header', 'newp'),
		'desc' => __('Insert scripts or code before the closing &lt;/head&gt; tag in the document source:', 'newp'),
		'id' => 'headcode1',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Custom Code in Footer', 'newp'),
		'desc' => __('Insert scripts or code before the closing &lt;/body&gt; tag in the document source:', 'newp'),
		'id' => 'footercode1',
		'std' => '',
		'type' => 'textarea');	
		
	$options[] = array(
		'name' => __('Copyright Text', 'newp'),
		'desc' => __('Some Text regarding copyright of your site, you would like to display in the footer.', 'newp'),
		'id' => 'footertext2',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Custom CSS', 'newp'),
		'desc' => __('Some Custom Styling for your site. Place any css codes here instead of the style.css file.', 'newp'),
		'id' => 'style2',
		'std' => '',
		'type' => 'textarea');	
	
	
	//SLIDER SETTINGS

	$options[] = array(
		'name' => __('Slider Settings', 'newp'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'newp'),
		'desc' => __('Check this to Enable Slider.', 'newp'),
		'id' => 'slider_enabled',
		'type' => 'checkbox',
		'std' => '0' );
		
	$options[] = array(
		'name' => __('Using the Slider', 'newp'),
		'desc' => __('This Slider supports upto 5 Images. To show only 3 Slides in the slider, upload only 3 images. Leave the rest Blank. For best results, upload images of size 1180x500 px.', 'newp'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Slider Image 1', 'newp'),
		'desc' => __('First Slide', 'newp'),
		'id' => 'slide1',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'newp'),
		'id' => 'slidetitle1',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url', 'newp'),
		'id' => 'slideurl1',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 2', 'newp'),
		'desc' => __('Second Slide', 'newp'),
		'class' => '',
		'id' => 'slide2',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'newp'),
		'id' => 'slidetitle2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url', 'newp'),
		'id' => 'slideurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 3', 'newp'),
		'desc' => __('Third Slide', 'newp'),
		'id' => 'slide3',
		'class' => '',
		'type' => 'upload');	
	
	$options[] = array(
		'desc' => __('Title', 'newp'),
		'id' => 'slidetitle3',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url', 'newp'),
		'id' => 'slideurl3',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 4', 'newp'),
		'desc' => __('Fourth Slide', 'newp'),
		'id' => 'slide4',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'newp'),
		'id' => 'slidetitle4',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url', 'newp'),
		'id' => 'slideurl4',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 5', 'newp'),
		'desc' => __('Fifth Slide', 'newp'),
		'id' => 'slide5',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'newp'),
		'id' => 'slidetitle5',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url', 'newp'),
		'id' => 'slideurl5',
		'std' => '',
		'type' => 'text');	
			
	//Social Settings
	
	$options[] = array(
	'name' => __('Social Settings', 'newp'),
	'type' => 'heading');
	
	$options[] = array(
		'desc' => __('With Newp Pro, you can add any icon of your choice. And Plus there are inbuilt support for 10 popular social networks. <a href="http://rohitink.com/product/newp-pro/" target="_blank">Upgrade to Pro</a> at Just $12.95.'),
		'std' => '',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Facebook', 'newp'),
		'desc' => __('Facebook Profile or Page URL i.e. http://facebook.com/username/ ', 'newp'),
		'id' => 'facebook',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter', 'newp'),
		'desc' => __('Twitter Username', 'newp'),
		'id' => 'twitter',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus', 'newp'),
		'desc' => __('Google Plus profile url, including "http://"', 'newp'),
		'id' => 'google',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Feeburner', 'newp'),
		'desc' => __('URL for your RSS Feeds', 'newp'),
		'id' => 'feedburner',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Flickr', 'newp'),
		'desc' => __('URL for your Flickr Profile', 'newp'),
		'id' => 'flickr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
			
	$options[] = array(
		'name' => __('Instagram', 'newp'),
		'desc' => __('URL for your Instagram Profile', 'newp'),
		'id' => 'instagram',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
	'name' => __('Support', 'newp'),
	'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Newp WordPress theme has been Designed and Created by <a href="http://rohitink.com" target="_blank">Rohit Tripathi</a>. For any Queries or help regarding this theme, <a href="http://rohitink.com/2013/09/09/newp-wordpress-theme/" target="_blank">comment on this page.</a> You can also ask questions about this theme on WordPress.org Support Forums. I will answer your queries there too.', 'newp'),
		'type' => 'info');	
		
	 $options[] = array(
		'desc' => __('<a href="http://twitter.com/rohitinked" target="_blank">Follow Me on Twitter</a> to know about my upcoming themes.', 'newp'),
		'type' => 'info');	
	
	$options[] = array(
		'desc' => __('Newp Pro comes with Personal e-mail Support. Check out All Features. <a href="http://rohitink.com/product/newp-pro/" target="_blank">Upgrade to Pro</a> at Just $12.95.'),
		'std' => '',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Regenerating Post Thumbnails', 'newp'),
		'desc' => __('If you are using Newp Theme on a New Wordpress Installation, then you can skip this section.<br />But if you have just switched to this theme from some other theme, or just updated to the current version of newp, then you are requested regenerate all the post thumbnails. It will fix all the isses you are facing with distorted & ugly homepage thumbnail Images. ', 'newp'),
		'type' => 'info');	
		
	$options[] = array(
		'desc' => __('To Regenerate all Thumbnail images, Install and Activate the <a href="http://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> WP Pugin. Then from <strong>Tools &gt; Regen. Thumbnails</strong>, re-create thumbnails for all your existing images. And your blog will look even more stylish with Newp theme.<br /> ', 'newp'),
		'type' => 'info');	
		
			
	$options[] = array(
		'desc' => __('<strong>Note:</strong> Regenerating the thumbnails, will not affect your original images. It will just generate a separate image file for those images.', 'newp'),
		'type' => 'info');	
		
	
	$options[] = array(
		'name' => __('Theme Credits', 'newp'),
		'desc' => __('Check this if you want to you do not want to give us credit in your site footer.', 'newp'),
		'id' => 'credit1',
		'std' => '0',
		'type' => 'checkbox');
	
	

	return $options;
}