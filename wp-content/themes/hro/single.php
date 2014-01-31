<?php get_header(); ?>

<?php loopIt('post'); ?>
<?php comments_template(); ?>

		<nav class="pagination">
			<?php previous_post_link('<span class="nav-left"><span class="pagination-arrow">&larr;</span> %link</span>'); ?>   
			<?php next_post_link('<span class="nav-right">%link <span class="pagination-arrow">&rarr;</span></span>'); ?>
		</nav>	

<?php get_sidebar(); ?>
<?php get_footer(); ?>