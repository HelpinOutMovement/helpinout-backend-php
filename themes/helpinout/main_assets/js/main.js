	$(function () {
	    'use strict';


	    // //-------- Navigation on scroll----// 
	    function navScroll() {
	        var nav = $(".start-style");
	        var pos = nav.position();
	        var windowpos = $(window).scrollTop();

	        if (windowpos > pos.top) {
	            nav.addClass('scroll-on');
	        } else {
	            nav.removeClass('scroll-on');
	        }

	    }

	    $(window).scroll(function () {
	        navScroll();
	    });



	    


	    navScroll();

        
        
        

	});