$(document).ready(function() {
    $('html, body').animate({scrollTop:720}, 1300);
   $(window).on("scroll", function() {
       var scrollHeight = $(document).height();
       var scrollPosition = $(window).height() + $(window).scrollTop();
       var nav=document.getElementById("the-sticky-div");
       console.log(nav);
       if (scrollPosition>=1066) {
           jQuery('#the-sticky-div').addClass('sticky');
       }else if(jQuery('#the-sticky-div').hasClass('sticky') && scrollPosition <1066){                                        
           jQuery('#the-sticky-div').removeClass('sticky');
       }
   });
});