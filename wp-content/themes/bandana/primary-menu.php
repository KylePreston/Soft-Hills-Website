<?php
/** Primary Menu Callback */
function bandana_primary_menu_cb() {
	wp_page_menu();		 
}
?>
<div class="menu1">
  <div class="menu1-data">
    <?php
    if ( has_nav_menu( 'bandana-primary-menu' ) ):
  
      $args = array(
      
          'container' => 'div', 
          'container_class' => 'primary-container', 
          'theme_location' => 'bandana-primary-menu',
          'menu_class' => 'sf-menu1',
          'depth' => 5,
          'fallback_cb' => 'bandana_primary_menu_cb'
                  
      );
  
      wp_nav_menu( $args );
  
    else:
  
      bandana_primary_menu_cb();	

    endif;
    ?>
  </div>
</div>