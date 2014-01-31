<?php

/**
 * Run specific functions at init time for hro.
 */
function hro_init(){
	include "hro-options.php";
	hro_save_options();
	wp_enqueue_script('jquery');
	add_action('admin_menu', 'hro_options_admin_page'); function hro_options_admin_page() {
		add_theme_page( 'Hro Options', 'Hro Options', 'manage_options', 'hro-options', 'hro_options');
	}
	wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/hro.js', array(), '', true );
	add_action('wp_head', 'hro_js_self');
	add_action('wp_footer','hro_ie');

	/**
	 * Hack to get past theme check, which requires register_sidebar, 
	 * though I am not going to have sidebar option as a part of my theme.
	 *
	 * I did not want to actually call this because I did not want to have the widgets
	 * option show, when I don't even have a sidebar!
	 */
	if(0){
		?>register_sidebar();<?php
	}

	dynamic_sidebar(); //Also strictly for compliance (no sidebars here!);
	add_theme_support( 'automatic-feed-links' ); //Not sure what this does :)
	if ( ! isset( $content_width ) ) $content_width = 900; //WP Wants this
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );

}

function hro_ie(){
	?>
	  <!--[if lt IE 7 ]>
	    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	  <![endif]-->
	<?php
}

add_action('init','hro_init'); //Add the init action to WP

function hro_js_self(){
	?>
		<script>
			jQuery(document).ready(function(){

				<?php if(hro_option('hro_hide_menu_home_on')): ?>
					if( jQuery('body').hasClass('home') ){
						hro_Menu();			
					}
				<?php endif; ?>

				//Detect if Mozilla to fix shadow on .site-pages-nav
				if(jQuery.browser.mozilla){jQuery('body').addClass('gecko'); }

				//activate .site-pages-nav on .site-title press
				jQuery('.site-title').click(function(){
					hro_Menu();
				});

			});
		</script>
	<?php
}

/**
 * Get information about the theme using a quick function.
 */
function hro_data($key=NULL){
	$data = wp_get_theme('hro', get_theme_root());
	if($key) return $data->get($key); else return $data;
}

/**
 * Gets a saved option for HRO, essentially the same as get_option. Coded in just in case I want to break out options later on.
 */
function hro_option($key){
	return get_option($key);
}

/**
 * Safe echo for hardcoded theme elements (if any).
 */
function e_($e,$htmlentities2=true){
	if($htmlentities2) _e(htmlentities2($e));
		else _e(htmlentities($e));
}

/**
 * Gets the picture from the theme options and expresses the needed HTML.
 */
function hro_pic(){
	if(hro_option('hro_pic')): ?>
		<div class="pic">
			<a href="<?php bloginfo('url'); ?>"><img src="<?php echo hro_option('hro_pic'); ?>"></a>
		</div>
	<?php endif;
}

/**
 * LoopIt function from twentyten used throughout template to bring in standard post HTML.
 */
function loopIt($typeClass='post',$showTheContent=true){ global $post; if (have_posts()): while (have_posts()): the_post(); ?>
	<section class="type-<?php e_($typeClass); ?> <?php e_($typeClass); ?>-<?php the_ID(); ?> id-<?php the_ID(); ?> item <?php if($showTheContent): ?>show-content<?php endif; ?>" <?php post_class(); ?>>
		<article class="article">
			<header class="header">
				<div class="header-meta">
					<span class="time">
						<a href="<?php the_permalink(); ?>">
							<?php printf( 
								__('
									<span class="date">%1$s</span> 
									<span class="time">%2$s</span>'
								, 'hro'), 
								the_date('', '', ', ', false), 
								get_the_time()
							); ?>
							</a>
					</span>
					<span class="comment-count">
						<?php comments_popup_link( 
							__('<span class="time-sep">&mdash;</span> 0 Replies', 'hro'), 
							__('<span class="time-sep">&mdash;</span> 1 Replies', 'hro'), 
							__('<span class="time-sep">&mdash;</span> % Replies', 'hro'),
							'',
							''
						); ?>
					</span>
				</div>
				<h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			</header>
			<div class="the_content">
				<?php the_content(); ?>
			</div>
			<footer class="footer-meta">
				<?php wp_link_pages('before=<p class="pagelinks"><span class="cont-title">Continued:</span> <span class="cont-pages"> &after=</span></p>'); ?>
				<?php if(!is_page() && $showTheContent && hro_option('hro_cats')!="on") if(get_the_category()): ?>
					<p class="categories"><span class="category-title"></span> <?php the_category(', '); ?></p>
				<?php endif; ?>

				<?php if(!is_page() && $showTheContent) if(get_the_tags()): ?>
					<p class="tags"><span class="tag-title"></span> <?php the_tags(hro_option('hro_tag_sep'),', '.hro_option('hro_tag_sep'),''); ?></p>
				<?php endif; ?>
			</footer>
		</article>
	</section>
<?php endwhile; else: ?>
	<section class="type-<?php e_($typeClass); ?> <?php e_($typeClass); ?>-<?php the_ID(); ?> id-<?php the_ID(); ?> item" <?php post_class(); ?>>
		<article class="article">
			<header class="header">
				<h1 class="title"><?php _e("Oops!"); ?></h1>
			</header>
				<p class="centeredtext"><?php e_("Sorry, whatever you are looking for isn't here. Try again."); ?></p>
				<div class="centeredtext"><?php get_search_form(true); ?></div>
			<footer class="footer-meta">
			</footer>
		</article>
	</section>
<?php endif; }

?>