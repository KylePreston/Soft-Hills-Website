/**
 * Functionality specific to Trvl.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	/**
	 * Arranges footer widgets vertically.
	 */
	$( '#secondary' ).masonry( {
		itemSelector: '.widget',
		columnWidth: 300,
		gutterWidth: 25,
		isRTL: $( 'body' ).is( '.rtl' )
	} );
	setInterval( function() {
		$( '#secondary' ).masonry( 'reload' );
	}, 300 );
} )( jQuery );
