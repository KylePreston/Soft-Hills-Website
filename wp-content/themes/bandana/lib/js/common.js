/** JS Logics */
(function($){
	
	/** Drop Downs */
	function bandanaMenu() {
		
		/** Superfish Menu */
		$( '.menu1 ul' ).supersubs({ 
			minWidth: 16, 
			maxWidth: 27, 
			extraWidth: 0
		}).superfish({ 
			delay: 1200,
			autoArrows: true, 
			speed: 'fast', 
			dropShadows: false, 
			animation: { opacity:'show', height:'show' }
		});
		$( '.menu1 ul' ).prepend( '<li class="menu-pld">&nbsp;</li>' ).append( '<li class="menu-ald">&nbsp;</li>' );
		
	}
	
	/** jQuery Document Ready */
	$(document).ready(function(){
		bandanaMenu();
	});

})(jQuery);