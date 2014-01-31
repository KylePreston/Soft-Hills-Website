<div class="wrap bandana-settings">
  
  <?php 
  /** Get the parent theme data. */
  $bandana_theme_data = bandana_theme_data();
  screen_icon();
  ?>
  
  <h2><?php echo sprintf( __( '%1$s Theme Settings', 'bandana' ), $bandana_theme_data['Name'] ); ?></h2>    
  
  <?php settings_errors(); ?>
  
  <div id="bandana-pro-wrapper">
    <a href="http://designorbital.com/" class="button button-primary button-hero" target="_blank"><?php _e( 'Our Premium Themes', 'bandana' ); ?></a>
    <a href="http://designorbital.com/free-wordpress-themes/" class="button button-hero" target="_blank"><?php _e( 'Our Free Themes', 'bandana' ); ?></a>
  </div>
  
  <form action="options.php" method="post" id="bandana-form-wrapper">
    
    <div id="bandana-form-header" class="bandana-clearfix">
      <input type="submit" name="" id="" class="button button-primary" value="<?php _e( 'Save Changes', 'bandana' ); ?>">      
    </div>
  
  <?php settings_fields('bandana_options_group'); ?>
    
    <div id="bandana-sidebar">
      
      <ul id="bandana-group-menu">
        <li id="0_section_group_li" class="bandana-group-tab-link-li active"><a href="javascript:void(0);" id="0_section_group_li_a" class="bandana-group-tab-link-a" data-rel="0"><span><?php _e( 'Blog Settings', 'bandana' ); ?></span></a></li>
        <li id="1_section_group_li" class="bandana-group-tab-link-li"><a href="javascript:void(0);" id="1_section_group_li_a" class="bandana-group-tab-link-a" data-rel="1"><span><?php _e( 'Post Settings', 'bandana' ); ?></span></a></li>
        <li id="2_section_group_li" class="bandana-group-tab-link-li"><a href="javascript:void(0);" id="2_section_group_li_a" class="bandana-group-tab-link-a" data-rel="2"><span><?php _e( 'Footer Settings', 'bandana' ); ?></span></a></li>
        <li id="3_section_group_li" class="bandana-group-tab-link-li"><a href="javascript:void(0);" id="3_section_group_li_a" class="bandana-group-tab-link-a" data-rel="3"><span><?php _e( 'General Settings', 'bandana' ); ?></span></a></li>
      </ul>
    
    </div>
    
    <div id="bandana-main">
    
      <div id="0_section_group" class="bandana-group-tab">
        <?php do_settings_sections( 'bandana_section_blog_page' ); ?>
      </div>
      
      <div id="1_section_group" class="bandana-group-tab">
        <?php do_settings_sections( 'bandana_section_post_page' ); ?>
      </div>
      
      <div id="2_section_group" class="bandana-group-tab">
        <?php do_settings_sections( 'bandana_section_footer_page' ); ?>
      </div>
      
      <div id="3_section_group" class="bandana-group-tab">
        <?php do_settings_sections( 'bandana_section_general_page' ); ?>
      </div>
      
    </div>
    
    <div class="clear"></div>
    
    <div id="bandana-form-footer" class="bandana-clearfix">
      <input type="submit" name="" id="" class="button button-primary" value="<?php _e( 'Save Changes', 'bandana' ); ?>">
    </div>
    
  </form>

</div>