/*-----------------------------
* Build Your Plugin JS / jQuery
-----------------------------*/
/*
Jquery Ready!
*/
jQuery(document).ready(function($){
    "use strict";
    $( "#samplib-price-slider" ).slider({
    	range: "max",
    	min: 0,
    	max: 1000,
    	value: 200,
    	slide: function( event, ui ) {
    	  $( 'input[name="samplib[price]"]' ).val( ui.value );
    	  $( '#samplib-price-label' ).text('$'+$("#samplib-price-slider").slider("value"));
    	  $( 'input[name="samplib[price]"]' ).val($("#samplib-price-slider").slider("value"));
    	}
    });
});