<?php
/**
 * Template Name: Page with About Section
 * The template file for displaying pages with About boxes.
 * @package TimeTurner
 * @since TimeTurner 1.0.2
*/
get_header(); ?>

<div id="wrapper-about">
<div class="wrapper-bottom-line">
<div class="wrapper-top-line">
  <div class="container">
    <div class="headline-wrapper">
      <div class="description-hatching"></div>
      <div class="description-box">
        <h2 class="about-headline"><?php echo $timeturner_about_headline; ?></h2>
        <div class="top-left-radius dark-radius"></div>
        <div class="top-right-radius dark-radius"></div>
        <div class="bottom-left-radius dark-radius"></div>
        <div class="bottom-right-radius dark-radius"></div>
      </div>
    </div>
    
    <div class="about-boxes-wrapper">
<?php if ( dynamic_sidebar( 'sidebar-8' ) ) : else : ?>
      <div class="about-box">
      <div class="about-box-inner">
      <div class="about-box-content">
        <h3><?php _e( 'How to edit these boxes?' , 'timeturner' ); ?></h3>
        <img src="<?php echo get_template_directory_uri(); ?>/images/image-1.jpg" alt="image" />
        <p><?php _e( 'For editing these boxes, go to the Appearance > Widgets menu and insert as many Text widgets as you like into "About Section boxes on homepage" widget area.' , 'timeturner' ); ?></p>
        <a class="read-more-button" href="#nogo"><?php _e( 'READ MORE' , 'timeturner' ); ?></a>
      </div>
      </div>
        <div class="about-top-left-radius about-radius"></div>
        <div class="about-top-right-radius about-radius"></div>
        <div class="about-bottom-left-radius about-radius"></div>
        <div class="about-bottom-right-radius about-radius"></div>
      </div>
      
      <div class="about-box">
      <div class="about-box-inner">
      <div class="about-box-content">
        <h3><?php _e( 'Useful shortcodes' , 'timeturner' ); ?></h3>
        <img src="<?php echo get_template_directory_uri(); ?>/images/image-1.jpg" alt="image" />
        <p><?php _e( 'To insert a picture or "Read more" button, you can use these shortcodes:<br />[image src="<em>image URL</em>"]<br />[more-button link="<em>URL address</em>"]<em>READ MORE</em>[/more-button]' , 'timeturner' ); ?></p>
        <a class="read-more-button" href="#nogo"><?php _e( 'READ MORE' , 'timeturner' ); ?></a>
      </div>
      </div>
        <div class="about-top-left-radius about-radius"></div>
        <div class="about-top-right-radius about-radius"></div>
        <div class="about-bottom-left-radius about-radius"></div>
        <div class="about-bottom-right-radius about-radius"></div>
      </div>
      
      <div class="about-box">
      <div class="about-box-inner">
      <div class="about-box-content">
        <h3><?php _e( 'How to remove this area?' , 'timeturner' ); ?></h3>
        <img src="<?php echo get_template_directory_uri(); ?>/images/image-1.jpg" alt="image" />
        <p><?php _e( 'If you do not want to display this area, go to the "Theme Options" panel. In "Homepage Settings", you can hide this area. Same way you can rename or hide the other areas, too.' , 'timeturner' ); ?></p>
        <a class="read-more-button" href="#nogo"><?php _e( 'READ MORE' , 'timeturner' ); ?></a>
      </div>
      </div>
        <div class="about-top-left-radius about-radius"></div>
        <div class="about-top-right-radius about-radius"></div>
        <div class="about-bottom-left-radius about-radius"></div>
        <div class="about-bottom-right-radius about-radius"></div>
      </div>
<?php endif; ?>      
    </div>
    
    </div>
</div>
</div>
</div>     <!-- end of wrapper-about -->

<div id="wrapper-content">
<div class="wrapper-bottom-line">
<div class="wrapper-top-line">
  <div class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="headline-wrapper">
      <div class="description-hatching"></div>
      <div class="description-box">
        <h1 class="content-headline"><?php the_title(); ?></h1>
        <div class="top-left-radius dark-radius"></div>
        <div class="top-right-radius dark-radius"></div>
        <div class="bottom-left-radius dark-radius"></div>
        <div class="bottom-right-radius dark-radius"></div>
      </div>
    </div>
    <div id="content">
<?php timeturner_get_display_image_page(); ?>
<?php the_content( 'Continue reading' ); ?>
<?php endwhile; endif; ?>

<?php comments_template( '', true ); ?>
    </div> <!-- end of content -->
<?php get_sidebar(); ?>
  </div>
</div>
</div>
</div>     <!-- end of wrapper-blog -->
<?php get_footer(); ?>