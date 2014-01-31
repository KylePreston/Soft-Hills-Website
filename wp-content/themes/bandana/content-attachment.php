<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta">    
	<?php echo bandana_post_date() . bandana_post_comments() . bandana_post_author() . bandana_post_sticky() . bandana_post_edit_link(); ?>
  </div><!-- .entry-meta -->
  
  <?php bandana_loop_nav_singular(); ?>
  
  <div class="entry-content entry-attachment clearfix">
  	<p><a href="<?php echo wp_get_attachment_url( $post->ID ); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></p>
    <?php the_excerpt(); ?>
  </div> <!-- end .entry-content -->
  
</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php bandana_loop_nav_singular_attachment(); ?>

<?php comments_template( '', true ); ?>