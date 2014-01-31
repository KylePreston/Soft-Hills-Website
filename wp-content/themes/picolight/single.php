<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			 <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="title">
					<h1><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				</div>
					<div class="meta"><a href="<?php the_permalink() ?>"><?php the_time('d. F Y') ?></a> &middot; <?php comments_popup_link(__('Write a comment', 'picolight'), __('1 comment', 'picolight'), __('% comments', 'picolight')); ?>
					<?php
						picolight_show_categories();
						picolight_show_tags();
					?>
					<?php edit_post_link( __('(Edit)', 'picolight'), '<span class="edit-link">', '</span>' ); ?></div>					
				<div class="entry">
					<?php the_content(__('More &raquo;', 'picolight')); ?>
					<div class="pagelinks">
						<?php wp_link_pages(); ?>
					</div>
				</div>			
			</div>
			
			<?php global $picolight_options;
			$picolight_settings = get_option( 'picolight_options', $picolight_options ); ?>		
			
			<?php if ($picolight_settings['show_about_the_author']) { ?>
				<div id="author-box">
					<div id="author-gravatar"><?php echo get_avatar(get_the_author_meta('user_email'), '40');?></div>
					<div id="author-box-content">
						<h3 id="author-box-title"><?php _e('About the author', 'picolight'); ?>: <?php the_author_link(); ?></h3>
						<p id="author-box-text"><?php the_author_meta('description');?></p>
					</div>
				</div>
			<?php } ?>		
		
			<?php comments_template('', true); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no article found', 'picolight'); ?>.</p>

<?php endif; ?>

	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
