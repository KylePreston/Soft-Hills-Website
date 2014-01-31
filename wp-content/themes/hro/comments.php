<!-- comments begin here -->
<aside class="comments-aside">
<div id="comments">
	
	
<?php if ('open' == $post->comment_status) : ?>

	<!--<h2 class="comment-heading post-title"><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h2>
-->
	<div id="respond">

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

		<!--<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>-->

	<?php else : comment_form();  endif; // If registration required and not logged in ?>
	</div><!-- /respond -->

<?php else : ?>

<!-- If comments are closed. -->

<?php endif; // if you delete this the sky will fall on your head ?>





<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
	<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	</div><!-- /comments -->

	<!-- comments end here -->
<?php
	return;
}

if ( have_comments() ) : ?>

	<ol class="commentlist">
		<?php wp_list_comments('type=comment&order=DESC'); ?>
	</ol>

	<div class="navigation">
		<?php paginate_comments_links() ?>
	</div>

	<ol class="trackbacklist">
		<?php wp_list_comments('type=pingback'); ?>
	</ol>

<?php endif; ?>


</div><!-- /comments -->

</aside>

<!-- comments end here -->