<?php
/**
 * @package Newp
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
    	<?php if (has_post_thumbnail()) : ?>
    	<a href="<?php the_permalink(); ?>" rel="bookmark">
    	<?php
			the_post_thumbnail('homepage-thumb'); ?>
		</a>
		<?php	
			endif;
			?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

	</header><!-- .entry-header -->
	<div class="entry-content">
    <?php if (has_post_thumbnail()) 
		{
			if(strlen(get_the_title()) >= 108)
				echo " ";
			else if(strlen(get_the_title()) >= 75)
				echo substr(get_the_excerpt(), 0,40)."....";		
			else if(strlen(get_the_title()) >= 50)
				echo substr(get_the_excerpt(), 0,80)."....";	
			else	
				echo substr(get_the_excerpt(),0,110)."..."; 
		}
		 	else 
		 		the_excerpt();
		 ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
