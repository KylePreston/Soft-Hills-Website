<?php get_header(); ?>

<?php loopIt('post',hro_option('hro_content')); ?>

		<nav class="pagination">
			<?php next_posts_link(__('<span class="nav-left"><span class="pagination-arrow">&larr;</span> Older</span>', 'hro')) ?>
			<?php previous_posts_link(__('<span class="nav-right">Newer <span class="pagination-arrow">&rarr;</span></span>', 'hro')) ?>
		</nav>

<?php get_sidebar(); ?>
<?php get_footer(); ?>