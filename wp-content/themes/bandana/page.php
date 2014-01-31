<?php get_header();	?>

<?php get_template_part( 'loop-meta' ); ?>
  
<div class="container_16 clearfix">
  
  <div class="grid_10">
    <div id="content">	  
	  
	  <?php if ( have_posts() ) : ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
        
          <?php get_template_part( 'content', 'page' ); ?>
        
        <?php endwhile; ?>
      
      <?php else : ?>
                  
        <?php get_template_part( 'loop-error' ); ?>
      
      <?php endif; ?>
      
      <?php get_template_part( 'loop-nav' ); ?>
    
    </div> <!-- end #content -->
  </div> <!-- end .grid_10 -->
  
  <?php get_sidebar(); ?>

</div> <!-- end .container_16 -->
  
<?php get_footer(); ?>