<?php
/**
 * @package Trvl
 */
$format      = get_post_format();
$format_text = $format ? sprintf( '<a href="%1$s">%2$s</a>', get_post_format_link( $format ), get_post_format_string( $format ) ) : __( 'entry', 'trvl' );

/* translators: used between list items, there is a space after the comma */
$cat_list = get_the_category_list( __( ', ', 'trvl' ) );

/* translators: used between list items, there is a space after the comma */
$tag_list = get_the_tag_list( '', __( ', ', 'trvl' ) );

if ( ! trvl_categorized_blog() ) {
	// This blog only has 1 category so we just need to worry about tags in the meta text
	if ( '' != $tag_list ) {
		$meta_text = __( 'This %1$s was tagged %3$s. Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'trvl' );
	} else {
		$meta_text = __( 'Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'trvl' );
	}

} else {
	// But this blog has loads of categories so we should probably display them here
	if ( '' != $tag_list ) {
		$meta_text = __( 'This %1$s was posted in %2$s and tagged %3$s. Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'trvl' );
	} else {
		$meta_text = __( 'This %1$s was posted in %2$s. Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'trvl' );
	}

} // end check for categories on this blog
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php trvl_posted_on(); ?>
			<?php edit_post_link( __( 'Edit', 'trvl' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'trvl' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			printf(
				$meta_text,
				$format_text,
				$cat_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
