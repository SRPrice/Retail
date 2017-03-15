$(document).ready(function(){
	
	$('.date-selector').bind('keyup',function(){
    var strokes = $(this).val().length;
    if(strokes === 2 || strokes === 5){
        var thisVal = $(this).val();
        thisVal += '/';
        $(this).val(thisVal);
    }
	});

	$(".hidden-image").removeClass("hidden-image");

	var headerHeight = $("header").outerHeight();
	$("body").css({"padding-top" : headerHeight});
	
	var slideshow = function(){
			
			$("#slideshow li:last").find(".hiding-text h4").css({"opacity" : 1, "left" : 0});
			setTimeout(function(){
				$("#slideshow li:last").find(".hiding-text .button").css({"opacity" : 1, "left" : 0});
			}, 400);
			
			setTimeout(function(){
				
				$("#slideshow li:last").find(".hiding-text .button").css({"opacity" : 0, "left" : -25});
				setTimeout(function(){
					$("#slideshow li:last").find(".hiding-text h4").css({"opacity" : 0, "left" : -25});
				}, 400);
				setTimeout(function(){
					
					$("#slideshow li:last").fadeOut(500, function(){
					$(this).detach().prependTo("#slideshow").show();
						slideshow();
					});
					
				}, 900);
				
			}, 1000*9);
	};

	if ($("#slideshow").length > 0){
		
		setTimeout(function(){
			slideshow();
		}, 750);		
	}
	

});

$(window).resize(function(){
	var headerHeight = $("header").outerHeight();
	$("body").css({"padding-top" : headerHeight});
});

$(document).foundation();