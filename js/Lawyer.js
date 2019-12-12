 
$(document).ready(function(){
    $("body").niceScroll({
             cursorcolor:"#31b0d5",
             cursorwidth:"7px"
    });
    $(".view-button").click(function(){
       var div=document.getElementsByClassName("show-details"); 
        $(div).css('display','block');
    });
    $('#btn-addNewLawyer').click(function(){
       var div=document.getElementById('addLawyer');
        $(div).css('display','block');
    });
});