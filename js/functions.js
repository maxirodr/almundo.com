(function($) {
	"use strict";
	$(document).ready(function() {
		ui__onlyonenav();
		ui__tooltip();
	});
})(jQuery);


function ui__onlyonenav(){
	$('.navbar').on('show.bs.collapse', function () {
		var actives = $(this).find('.collapse.in'),
			hasData;
		
		if (actives && actives.length) {
			hasData = actives.data('collapse')
			if (hasData && hasData.transitioning) return
			actives.collapse('hide')
			hasData || actives.data('collapse', null)
		}
	});
}

function ui__tooltip(){
	$('[data-toggle="tooltip"]').tooltip({html: true}); 
}