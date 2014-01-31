<?php
/** Register nav menus. */
add_action( 'init', 'bandana_register_menus' );

/** Registers the the core menus */
function bandana_register_menus() {

	/* Register the 'primary' menu. */
	register_nav_menu( 'bandana-primary-menu', __( 'Bandana Primary Menu', 'bandana' ) );
	
}