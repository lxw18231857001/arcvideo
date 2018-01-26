
jQuery(document).ready(function() {

// ******************************************************************************************
// Contact Form Start
// ******************************************************************************************
		$(document).ready(function(){
		  
		 $("#form").validate({
			debug: false,
			rules: {
				name: "required",
				phone:"digits",
				message: "required",
			email: {
					required: true,
					email: true
				   }
			},
			messages: {
				name: "Please let us know who you are.",
				email: "A valid email will help us get in touch with you."
				
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('email_process.php', $("#form").serialize(), function(data) {
				$('#post_message').html(data);
				});
			}
		});

//Contact Form END	

	
/* Twitter Start */

	$(function() {

	$("#tweets").tweet({
	count: 1,
	username: "envato"

	});

	});
/* Twitter End */
	



/***************************************************
		  		   // Portfolio on mouseover opactiy
***************************************************/	

if( jQuery.hasOwnProperty("prettyPhoto") ){

$(".lightbox").prettyPhoto({
animation_speed	: 'normal',
theme			: 'pp_default',
social_tools	: ''
});

}

});

//prettyPhoto END	




	
/***************************************************
		  			Isotope Portfolio
***************************************************/
jQuery(document).ready(function(){ 

// Needed variables
	var $container	 	= $('#portfolio_list');
	var $filter 		= $('#portfolio_filter');
		
// Run Isotope  
	$container.isotope({
		filter				: '*',
		layoutMode   		: 'masonry',
		animationOptions	: {
		duration			: 750,
		easing				: 'linear'
	   }
	});	
	
// Isotope Filter 
	$filter.find('a').click(function(){
	  var selector = $(this).attr('data-filter');
		$container.isotope({ 
		filter				: selector,
		animationOptions	: {
		duration			: 750,
		easing				: 'linear',
		queue				: false,
	   }
	  });
	  return false;
	});	

// Adding Class to current selected items
$filter.find('a').click(function() {
		var currentOption = $(this).attr('data-filter');
		$filter.find('a').removeClass('current');
		$(this).addClass('current');
	});	



});	
// Isotope Portfolio END


/***************************************************
		  		//	Parallex start
***************************************************/
	
$(window).load(function() {
$('#menu').localScroll({offset:-50,duration:2000});
$('.logo').localScroll({offset:-50,duration:1000});
$('.more_bg').localScroll({offset:-50,duration:1000});
$('.circle_uparrow').localScroll({offset:-50,duration:1000});
$('.circle_downarrow').localScroll({offset:-50,duration:1000});
$('#right_nav').localScroll({offset:-50,duration:1500});
	
	//.parallax(xPosition, speedFactor, outerHeight) options:
	//xPosition - Horizontal position of the element
	//inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
	//outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
	
	$('#home').parallax("50%", 0.3); // Backgrounds
	$('#home_superslide').parallax("50%", 0.3); // Backgrounds
	$('#home_static').parallax("50%", 0.3); // Backgrounds
	$('#home_sequence').parallax("50%", 0.3); // Backgrounds
	$('#services').parallax("50%", 0.3); // Backgrounds	
	$('#about').parallax("50%", 0.3);  // Backgrounds
	$('#about_me').parallax("50%", 0.3) // Backgrounds
	$('#team').parallax("50%",0.3); // Backgrounds
	$('#news').parallax("50%", 0.3); // Backgrounds
	$('#media').parallax("50%", 0.3); // Backgrounds
	$('#pricing').parallax("50%", 0.3); // Backgrounds
	$('#portfolio').parallax("50%", 0.3);  // Backgrounds
	$('#contact').parallax("50%", 0.3); // Backgrounds
	
	
	// for services section
	$('.service_circle1').parallax("50%",1.2);	
	$('.service_circle2').parallax("50%",2.3);	
	$('.service_circle3').parallax("50%",0.5);	
	$('.service_circle4').parallax("50%",0.1);	
	$('.service_circle5').parallax("50%",0.5);	
	$('.service_circle6').parallax("50%",0.4);	
	$('.service_circle7').parallax("50%",0.9);	
	
	
	// for about_me section	
	$('.html_circle').parallax("110%",0.4);		
	$('.cms_circle').parallax("60%",0.9);	
	$('.flash_circle').parallax("100%",0.2);			
	
	
		
})

<!-- Parallex end -->


/***************************************************
		  		//	Preloader Script
***************************************************/

$(window).load(function() {
  $('#preloader').fadeOut(300, function() {
    $('body').css('overflow','visible');
    $(this).remove();
  });
});


/***************************************************
		  		//	Carousels Section
***************************************************/
	(function() {

		var itemscroll = jQuery('.clientslide_carousel');
		if( itemscroll.length ) {

			var howmany;
			function gettheWidth() {

				if( jQuery(window).width() < 480 ) {howmany = 1;
				} else if( jQuery(window).width() < 768 ) {howmany = 2;
				} else if( jQuery(window).width() < 960 ) {howmany = 3;
				} else {howmany = 4;}

			}

			function initscrollitems( carousels ) {

				carousels.each(function() {

					var thisvar  = jQuery(this);

					thisvar.jcarousel({
						scroll              : howmany,
						itemVisibleInCallback : function() {
							onBeforeAnimation : resescrollitems( thisvar );
							onAfterAnimation : resescrollitems( thisvar );
						},
						auto                : ( thisvar.data('auto') ? parseInt( thisvar.data('auto') ) : 0 ),
						wrap                : ( thisvar.data('auto') ? 'both' : null )
					});

				});

			}

			function adjustscrollitems() {

				itemscroll.each(function() {

					var thisvar    = jQuery(this),
						lilists     = thisvar.children('li')
						newWidth = lilists.length * lilists.first().outerWidth( true ) + 100;

					gettheWidth();
					if( thisvar.width() !== newWidth) {thisvar.css('width',newWidth).data('resize','true');initscrollitems( thisvar );thisvar.jcarousel('scroll', 1);
						var timer = window.setTimeout( function() {window.clearTimeout( timer );thisvar.data('resize', null);}, 600 );
					}

				});

			}

			function resescrollitems( elem, resizeEvent ) {if( elem.data('resize') ){elem.css('left', '0');}}

			gettheWidth();
			initscrollitems( itemscroll );
			jQuery(window).on('resize', function() {var timer = window.setTimeout( function() {window.clearTimeout( timer );adjustscrollitems();}, 30 );});

		}

	})();
	
<!-- Carousels Section end -->


/* Drop down menu start */
 jQuery(document).ready(function($){

	/* prepend menu icon */
	$('#nav_wrap').prepend('<div id="menu_icon">Menu</div>');
	
	/* toggle nav */
	$("#menu_icon").on("click", function(){
		$("#nav").slideToggle();
		$(this).toggleClass("active");
	});

});
/* Drop down menu end */

/***************************************************
		  		//	(Rightside Bullet Navigation)
***************************************************/
	$(function() {
			// placement examples
			$('.west').powerTip({placement: 'w'});
		});
	
	/* // Rightside Bullet Navigation */



/***************************************************
		  		//	(Back to Top)
***************************************************/

	(function() {

		var settings = {
				button      : '#back_to_top',
				text        : 'Back to Top',
				min         : 200,
				fadeIn      : 400,
				fadeOut     : 400,
				scrollSpeed : 800,
				easingType  : 'easeInOutExpo'
			},
			oldiOS     = false,
			oldAndroid = false;

		// Detect if older iOS device, which doesn't support fixed position
		if( /(iPhone|iPod|iPad)\sOS\s[0-4][_\d]+/i.test(navigator.userAgent) )
			oldiOS = true;

		// Detect if older Android device, which doesn't support fixed position
		if( /Android\s+([0-2][\.\d]+)/i.test(navigator.userAgent) )
			oldAndroid = true;
	
		$('body').append('<a href="#" id="' + settings.button.substring(1) + '" title="' + settings.text + '">' + settings.text + '</a>');

		$( settings.button ).click(function( e ){
				$('html, body').animate({ scrollTop : 0 }, settings.scrollSpeed, settings.easingType );

				e.preventDefault();
			});

		$(window).scroll(function() {
			var position = $(window).scrollTop();

			if( oldiOS || oldAndroid ) {
				$( settings.button ).css({
					'position' : 'absolute',
					'top'      : position + $(window).height()
				});
			}

			if ( position > settings.min ) 
				$( settings.button ).fadeIn( settings.fadeIn );
			else 
				$( settings.button ).fadeOut( settings.fadeOut );
		});

	})();

	
<!--  (Back to Top)-->

});