/**
 * Launches and sets up the menu for hro.
 */
function hro_Menu(){
	hro_MenuEx();
	jQuery('.nav-click-panel').click(function(){
		hro_Menu();
	});
}

/**
 * Adjusts the styles of the menu.
 */
function hro_MenuEx(){
	jQuery('.site-pages-nav').toggleClass('nav_menu_on');
	jQuery('.site-title').toggleClass('arrow_off');
	jQuery('.nav-click-panel').toggleClass('nav-click-panel-on');
}