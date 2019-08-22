(function ($) {
	'use strict';

	$(document).ready(function () {

		console.log(spotify_dog_ajax_obj);

		// Hitta klassen '.widget_spotify-new-releases' i DOM
		// .each om det finns flera '.widget_spotify-new-releases' (flera widget)
		// skicka med (index, parameter)
		$('.widget_spotify-new-releases').each(function (i, widget) {
			console.log("Widget" + i + ":", widget);

			// Vi ska posta NÅGONSTANS, skicka med någon typ av data i brevet som vi skickar till NÅGONSTANS
			$.post(
				spotify_dog_ajax_obj.ajax_url, // URL to POST to // mottagare på ett brev // michal@gmail.com
				{
					action: 'spotify_dog__get'
				} // DATA to send to the URL // innehållet i brevet // Hej du är bäst
			).done(function (response) {
				// Om det gick bra kör denna funktionen
				console.log("Got response", response);
			}).fail(function (error) {
				// Om det gick fel kör denna funktionen
				console.log("Something went wrong", error);
			});
		});
	});

})(jQuery);