/* ==================== JSN TENDO CUSTOM JS ==================== */
(function($) {


$(document).ready( function() 
	{
	/* Add class 'fullwidth' to element if in #jsn-master.jsn-demo-page */
		if ($( "#jsn-master" ).hasClass( "jsn-demo-page" ))
		{
			$( '#jsn-content' ).addClass( 'fullwidth' )
		};


	});
})(jQuery);
    