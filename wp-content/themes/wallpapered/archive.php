<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php if ( is_day() ) : ?>
							<?php printf( 'Daily Archives: %s', '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( 'Monthly Archives: %s', '<span>' . get_the_date( 'F Y', 'monthly archives date format' ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( 'Yearly Archives: %s', '<span>' . get_the_date( 'Y', 'yearly archives date format' ) . '</span>' ); ?>
						<?php else : ?>
							<?php echo 'Blog Archives'; ?>
						<?php endif; ?>
					</h1>
				</header>

				<?php sgwp_content_nav( 'nav-above' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php sgwp_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php echo 'Nothing Found'; ?></h1>
					</header>

					<div class="entry-content">
						<p><?php echo 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.'; ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>

			<?php endif; ?>

			</div>
		</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>