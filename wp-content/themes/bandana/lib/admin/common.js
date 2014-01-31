(function($){
	
	/** Options Tabs */
	function bandanaOptionsTabs() {
		
		var relid = $.cookie( 'bandana_tab_relid' );
		
		if( relid >= 1  ) {
			bandanaOptionsTabControl( relid );
		} else {
			bandanaOptionsTabControl( 0 );
		}
		
		$( '.bandana-group-tab-link-a' ).click( function() {
			
			relid = $(this).attr( 'data-rel' );
			$.cookie( 'bandana_tab_relid', relid );
			bandanaOptionsTabControl( relid );		
			
		});
		
	}
	
	function bandanaOptionsTabControl( relid ) {
		
		$( '.bandana-group-tab' ).each( function() {
				
			if( $(this).attr( 'id' ) == relid + '_section_group' ) {					
				$(this).delay( 400 ).fadeIn( 1200 );				
			} else{					
				$(this).fadeOut( 'fast' );
			}
			
		});
		
		$( '.bandana-group-tab-link-li' ).each( function() {
			
			if( $(this).attr('id') != relid + '_section_group_li' && $(this).hasClass( 'active' ) ) {					
				$(this).removeClass( 'active' );				
			}
			
			if( $(this).attr('id') == relid + '_section_group_li' ) {					 
				 $(this).addClass('active');				
			}
		
		});
		
	}
	
	/** jQuery Document Ready */
	$(document).ready(function(){		
		bandanaOptionsTabs();		
	});

})(jQuery);