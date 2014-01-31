<?php 

/**
 * Saves the options from the options form, when submitted.
 */
function hro_update_option_from_post($key){
	if(isset($_POST[$key])) 
		update_option($key,$_POST[$key]);
			else delete_option($key);	
}

/**
 * Save function for saving each setting in the theme options form. For each added element to the Hro theme options form, add it below.
 */
function hro_save_options(){
	if( isset( $_POST['save_action'] ) ){
		hro_update_option_from_post('hro_favicon');
		hro_update_option_from_post('hro_hide_menu_home_on');
		hro_update_option_from_post('hro_cats');
		hro_update_option_from_post('hro_pic');
		hro_update_option_from_post('hro_tag_sep');

		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
}

/**
 * Hro theme options page.
 */
function hro_options(){ ?>
	<style>
		.text-label label{
			display: block;
			color:#9B9898;
			margin-bottom:2px;
		}
	</style>
	<form class="wrap" action="" method="post">
		<h2><?php _e('Hro Options'); ?></h2>

		<p class="text-label"><label for="hro_favicon"><?php _e('Favicon URL:'); ?></label> <input type="text" name="hro_favicon" value="<?php echo hro_option('hro_favicon'); ?>" style="width:300px"></p>
		<p class="text-label"><label for="hro_pic"><?php _e('Photo URL:'); ?></label> <input type="text" name="hro_pic" value="<?php echo hro_option('hro_pic'); ?>" style="width:300px"></p>
		<p class="text-label"><label for="hro_tag_sep"><?php _e('Show In Front of Tags (I.E. #):'); ?></label> <input type="text" name="hro_tag_sep" value="<?php echo hro_option('hro_tag_sep'); ?>" style="width:300px"></p>

		<p>
			<label for="hro_hide_menu_home_on">
				<input type="checkbox" name="hro_hide_menu_home_on" <?php if(hro_option('hro_hide_menu_home_on')): ?>checked="checked"<?php endif; ?>> <?php _e('Show the navigation open on the home page'); ?>
			</label>
		</p>

		<p>
			<label for="hro_content">
				<input type="checkbox" name="hro_cats" <?php if(hro_option('hro_cats')): ?>checked="checked"<?php endif; ?>> <?php _e("Hide categories, I don't use them"); ?>
			</label>
		</p>

		<p><input type="submit" value="Save Options" class="button primary"></p>
		<input type="hidden" name="save_action" value="on">
	</form> <?php
} ?>