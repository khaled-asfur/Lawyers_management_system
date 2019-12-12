(function($){
	var as_niceoptions = {
		// you can declare a default color here,
		// or in the data-default-color attribute on the input
		defaultColor: false,
		// a callback to fire whenever the color changes to a valid color
		change: function(event, ui){},
		// a callback to fire when the input is emptied or an invalid color
		clear: function() {},
		// hide the color picker controls on load
		hide: true,
		// show a group of common colors beneath the square
		// or, supply an array of colors to customize further
		palettes: true
	};
	$('.as_color_option').wpColorPicker(as_niceoptions);
	//as demo
	$('.as_click_show').click(function(){
	    $( ".my_status_main" ).animate({
	        right: "+=300"
	        }, 600, function() {
	        // Animation complete.
	    });
	    $(this).hide(0);
	    $('.as_click_hide').show(0);
	});

	$('.as_click_hide').click(function(){
	    $( ".my_status_main" ).animate({
	        right: "-=300"
	        }, 600, function() {
	        // Animation complete.
	    });
	    $(this).hide(0);
	    $('.as_click_show').show(0);
	});
})(jQuery)