<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">

 	<title><?php bloginfo('name'); ?> &mdash; <?php bloginfo('description'); ?></title>

 	<meta name="description" content="<?php bloginfo('description'); ?>">
 	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

 	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
 	<link href="<?php echo hro_option('hro_favicon'); ?>" rel="icon" type="image/x-icon" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php if(get_option('page_on_front')): ?>id="home-is-page"<?php endif; ?>>
	<header class="site-header">
		<?php hro_pic(); ?>
		<h1 class="site-title"><?php bloginfo('name'); ?></h1>
		<h2 class="site-description"><?php bloginfo('description'); ?></h2>
		<div class="nav-click-panel"></div>
		<div class="nav-panel">
			<nav class="site-pages-nav">
				<ul class="site-pages">
					<li class="home-link"><a href="<?php bloginfo('url'); ?>/"><?php _e('Home'); ?></a></li>

					<?php wp_list_pages('title_li=&depth=1'); ?>

					<!-- credit and old browsers -->
					<div class="abouthro">
						<span class="copyright">&copy;<strong><?php bloginfo('name'); ?></strong> &mdash; </span><a href="<?php echo hro_data('ThemeURI'); ?>" target="_blank">Hro <?php echo hro_data('Version'); ?></a> 
						<div class="ie7notify"><?php _e("Please consider updating your browser."); ?></div>
					</div>

					<!-- search -->
					<div class="search-form"><?php get_search_form( true ); ?></div>
				</ul>
			</nav>
		</div>
	</header>