$("#modal_trigger").leanModal({
	top: 200, 
	overlay: 0.5, 
	closeButton: ".modal_close" 
});

$(function(){
	// Calling Register Form
	$("#register_form").click(function(){
		/* Effects
		$(".social_login").hide("slide", { direction: "left" }, 0);
		$(".user_register").delay(125).show("slide", { direction: "left" }, 0);
		*/
		$(".social_login").hide();
		$(".user_register").show();
		$(".header_title").text('Register');
		return false;
	});
	
	// Calling Auswerter Login Form
	$("#login_aw").click(function(){
		$(".social_login").hide();
		$("#user_login_aw").show();
		$(".header_title").text('Als Auswerter einloggen');
		return false;
	});
	
	// Going back to Social Forms from Auswerter
	$("#back_btn_aw").click(function(){
		$("#user_login_aw").hide();
		$(".user_register").hide();
		$(".social_login").show();
		$(".header_title").text('Hallo Gast!');
		return false;
	});
	
	// Calling Zeitnehmer Login Form
	$("#login_ft").click(function(){
		$(".social_login").hide();
		$("#user_login_ft").show();
		$(".header_title").text('Als Zeitnehmer einloggen');
		return false;
	});
	
	// Going back to Social Forms from Zeitnehmer
	$("#back_btn_ft").click(function(){
		$("#user_login_ft").hide();
		$(".user_register").hide();
		$(".social_login").show();
		$(".header_title").text('Hallo Gast!');
		return false;
	});
	
	// Calling Teilnehmer Login Form
	$("#login_mt").click(function(){
		$(".social_login").hide();
		$("#user_login_mt").show();
		$(".header_title").text('Als Teilnehmer einloggen');
		return false;
	});
	
	// Going back to Social Forms from Zeitnehmer
	$("#back_btn_mt").click(function(){
		$("#user_login_mt").hide();
		$(".user_register").hide();
		$(".social_login").show();
		$(".header_title").text('Hallo Gast!');
		return false;
	});
})