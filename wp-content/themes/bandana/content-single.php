<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  <h1 class="entry-title entry-title-single"><?php the_title(); ?></h1>
  
  <div class="entry-meta">    
	<?php echo bandana_post_date() . bandana_post_comments() . bandana_post_author() . bandana_post_sticky() . bandana_post_edit_link(); ?>
  </div><!-- .entry-meta -->
  
  <div class="entry-content clearfix">
  	<?php the_content(); ?>
  </div> <!-- end .entry-content -->
  
  <?php echo bandana_link_pages(); ?>
  
  <div class="entry-meta-bottom">
  <?php echo bandana_post_category() . bandana_post_tags(); ?>
  </div><!-- .entry-meta -->

</div> <!-- end #post-<?php the_ID(); ?> .post_class -->

<?php bandana_author(); ?> 

<?php comments_template( '', true ); ?>