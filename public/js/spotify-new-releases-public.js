(function ($) {
	'use strict';

	$(document).ready(function () {
		// Hitta klassen '.widget_spotify-new-releases' i DOM
		// .each om det finns flera '.widget_spotify-new-releases' (flera widget)
		// skicka med (index, parameter)
		$('.widget_spotify-new-releases').each(function (i, widget) {

			// Vi ska posta NÅGONSTANS, skicka med någon typ av data i brevet som vi skickar till NÅGONSTANS
			$.post(
				spotify_dog_ajax_obj.ajax_url, // URL to POST to // mottagare på ett brev // michal@gmail.com
				{
					action: 'spotify_dog__get'
				} // DATA to send to the URL // innehållet i brevet // Hej du är bäst
			).done(function (response) {
				// Om det gick bra kör denna funktionen
				// Hitta content klassen
				var content = $(widget).find('.content');
				// Hitta data
				var data = response.data;
				// skapa ett tomt output
				var output = "";
				// kolla om is_video är true
				if (response.data.is_video) {
					// bilda html
					output += "<video autoplay loop width='320' height='240'>";
					output += "<source src='" + data.src + "' type='" + data.type + "'>";
					output += "</video>";
				} else {
					// bilda html
					output += "<img src=" + data.src + ">";
				}
				// skriv ut output i DOM
				$(content).html(output);
			}).fail(function (error) {
				// Om det gick fel kör denna funktionen
				console.log("Something went wrong", error);
			});
		});
	});

})(jQuery);