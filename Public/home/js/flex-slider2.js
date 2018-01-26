var $ = jQuery.noConflict();
//SLIDER

$(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
		pauseOnAction: true,
		pauseOnaHover: true,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });

    });