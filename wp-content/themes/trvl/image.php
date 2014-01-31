<?php
/**
 * The template for displaying image attachments.
 *
 * @package Trvl
 */

get_header();
?>

<div id="primary" class="content-area image-attachment">
	<div id="content" class="site-content" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="entry-meta">
					<?php
						$metadata = wp_get_attachment_metadata();
						printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>',
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() )
						);

						printf( __( 'Published in <a href="%1$s" title="Return to %2$s" rel="gallery">%3$s</a>', 'trvl' ),
							esc_url( get_permalink( $post->post_parent ) ),
							esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
							get_the_title( $post->post_parent )
						);

						printf( '<span><a href="%1$s" title="%2$s">%3$s &times; %4$s</a></span>',
							esc_url( wp_get_attachment_url() ),
							esc_attr__( 'Link to full-size image', 'trvl' ),
							$metadata['width'],
							$metadata['height']
						);
					?>
					<?php edit_post_link( __( 'Edit', 'trvl' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->

				<nav role="navigation" id="image-navigation" class="navigation-image">
					<div class="nav-previous"><?php previous_image_link( false, __( '<span class="meta-nav">&laquo;</span> Previous', 'trvl' ) ); ?></div>
					<div class="nav-next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&raquo;</span>', 'trvl' ) ); ?></div>
				</nav><!-- #image-navigation -->
			</header><!-- .entry-header -->

			<div class="entry-content">
				<div class="entry-attachment">
					<div class="attachment">
						<?php trvl_the_attached_image(); ?>
					</div><!-- .attachment -->

					<?php if ( has_excerpt() ) : ?>
					<div class="entry-caption">
						<?php the_excerpt(); ?>
					</div><!-- .entry-caption -->
					<?php endif; ?>
				</div><!-- .entry-attachment -->

				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'trvl' ), 'after' => '</div>' ) ); ?>

			</div><!-- .entry-content -->

			<footer class="entry-meta">
				<?php
					if ( comments_open() && pings_open() ) : // Comments and trackbacks open
						printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'trvl' ), get_trackback_url() );
					elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open
						printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'trvl' ), get_trackback_url() );
					elseif ( comments_open() && ! pings_open() ) : // Only comments open
						 _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'trvl' );
					elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed
						_e( 'Both comments and trackbacks are currently closed.', 'trvl' );
					endif;
				?>
			</footer><!-- .entry-meta -->
		</article><!-- #post-## -->

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();
