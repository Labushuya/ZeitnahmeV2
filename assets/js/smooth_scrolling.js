//	INDEX: INTRO > ADVERTISE
$("#intro").click(function() {
	$('html, body').animate({
		scrollTop: $("#ad").offset().top
	}, 1000);
});