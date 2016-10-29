(function($) {
	$(document).ready(function() {
		//add swipebox class to image links
		$('a[href*=".png"], a[href*=".gif"], a[href*=".jpg"], a[href*=".JPG"]').addClass('swipebox');
		//add swipebox to images with swipebox class
		$( '.swipebox' ).swipebox( {
		useCSS : true, // false will force the use of jQuery for animations
		useSVG : true, // false to force the use of png for buttons
		initialIndexOnArray : 0, // which image index to init when a array is passed
		hideCloseButtonOnMobile : SWIPE_CONTROLS.hide_close, // true will hide the close button on mobile devices
		removeBarsOnMobile : SWIPE_CONTROLS.top_bar, // false will show top bar on mobile devices
		hideBarsDelay : SWIPE_CONTROLS.delay_time, // delay before hiding bars on desktop
		videoMaxWidth : SWIPE_CONTROLS.video_max_width, // videos max width
		beforeOpen: function() {}, // called before opening
		afterOpen: null, // called after opening
		afterClose: function() {}, // called after closing
		loopAtEnd: true // true will return to the first image after the last image is reached
		});

	});

})(jQuery);