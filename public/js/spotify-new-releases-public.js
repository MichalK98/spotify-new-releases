(function ($) {
	'use strict';

	$(document).ready(function () {
		// Hitta klassen '.widget_spotify-new-releases' i DOM
		// .each om det finns flera '.widget_spotify-new-releases' (flera widget)
		// skicka med (index, parameter)
		$('.widget_spotify-new-releases').each(function (i, widget) {
			console.log("Widget" + i + ":", widget);
		});
	});

})(jQuery);