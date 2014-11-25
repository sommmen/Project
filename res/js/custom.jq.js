$(document).ready(function(){
	
	$("#mobileMenu").click(function(){
		$("nav").slideToggle();
	});


    if($(window).width < 749) {
        $(".main").click(function () {
            $("nav").slideUp();
        });
    }
	
	$(window).resize(function(){
		if($(this).width() > 749){
			$("nav").show();
		}
	});

});
