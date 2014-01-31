<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <?php $entry_title = ( 'page' == get_post_type() && bandana_post_edit_link() == "" )? 'entry-title entry-title-page' : 'entry-title'; ?>
  <h2 class="<?php echo $entry_title; ?>"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
  
  <?php if ( 'post' == get_post_type() ) : ?>
  
  <div class="entry-meta">    
	<?php echo bandana_post_date() . bandana_post_comments() . bandana_post_author() . bandana_post_sticky() . bandana_post_edit_link(); ?>
  </div><!-- .entry-meta -->
  
  <?php elseif ( 'page' == get_post_type() && bandana_post_edit_link() != "" ) : ?>
  
  <div class="entry-meta"> 
    <?php echo bandana_post_edit_link(); ?> 
  </div>
  
  <?php endif;?>  
  
  <div class="entry-content clearfix">
	<?php bandana_featured_image(); ?>
	<?php bandana_post_style(); ?>
  </div> <!-- end .entry-content -->
  
  <?php echo bandana_link_pages(); ?>
  
  <?php if ( 'post' == get_post_type() ) : ?>
  <div class="entry-meta-bottom">    
  <?php echo bandana_post_category() . bandana_post_tags(); ?>    
  </div><!-- .entry-meta-bottom -->
  <?php endif; ?>

</div> <!-- end #post-<?php the_ID(); ?> .post_class -->