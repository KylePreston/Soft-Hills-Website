<div class="grid_6">
  <div id="sidebar">
  
	<?php 
    if ( ! dynamic_sidebar( 'bandana-primary-sidebar' ) ):
    $bandana_theme_data = bandana_theme_data();
    ?>
    
    <div class="widget widget_search widget-widget_search">
      <div class="widget-wrap widget-inside">
        <?php get_search_form(); ?>
      </div>
    </div>
    
    <div class="widget widget_pages widget-widget_pages">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Pages', 'bandana' ); ?></h3>
          <ul><?php wp_list_pages( 'title_li=' ); ?></ul>
      </div>
    </div>
    
    <div class="widget widget_categories widget-widget_categories">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Categories', 'bandana' ); ?></h3>
          <ul><?php wp_list_categories('title_li='); ?></ul>
      </div>
    </div>
    
    <div class="widget widget_archive widget-widget_archive">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Archives', 'bandana' ); ?></h3>
          <ul><?php wp_get_archives( 'type=monthly' ); ?></ul>
      </div>
    </div>
    
    <div class="widget widget_calendar widget-widget_calendar">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Calendar', 'bandana' ); ?></h3>
        <?php get_calendar(); ?>
      </div>
    </div>
    
    <div class="widget widget_recent_entries widget-widget_recent_entries">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Recent Posts', 'bandana' ); ?></h3>
          <ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
      </div>
    </div>
    
    <div class="widget widget_tag_cloud widget-widget_tag_cloud">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Tag Cloud', 'bandana' ); ?></h3>
        <?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?>
      </div>
    </div>
    
    <div class="widget widget_text widget-widget_text">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'About Bandana', 'bandana' ); ?></h3>
        <div class="textwidget"><?php printf( __( '%s', 'bandana' ), $bandana_theme_data['Description'] ); ?></div>
      </div>
    </div>
    
    <div class="widget widget_meta widget-widget_meta">
      <div class="widget-wrap widget-inside">
        <h3 class="widget-title"><?php _e( 'Meta', 'bandana' ); ?></h3>
          <ul>
            <?php wp_register(); ?>
            <li><?php wp_loginout(); ?></li>
            <li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="Syndicate this site using RSS 2.0">Entries <abbr title="Really Simple Syndication">RSS</abbr></a></li>
            <li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="The latest comments to all posts in RSS">Comments <abbr title="Really Simple Syndication">RSS</abbr></a></li>
            <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress.org</a></li>
            <?php wp_meta(); ?>
          </ul>
      </div>
    </div>
    
    <?php endif; ?>
  
  </div> <!-- end #sidebar -->
</div>  <!-- end .grid_5 -->