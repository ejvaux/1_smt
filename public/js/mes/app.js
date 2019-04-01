var usrname = $("meta[name=username]").attr("content");

$body = $("body");
$(document).ready(function(){    
    $body.removeClass("loading");
    // Add active class to the current button (highlight it)
    /* var header = document.getElementById("tb");
    var btns = header.getElementsByClassName("tbl");
    for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
    });
    } */
    /* ----------- */
});

$('.navbar-nav>li>a').on('click', function(){
    $('.navbar-collapse').collapse('hide');
    
});
        
$(document).on({
    ajaxStart: function() { /* $body.addClass("loading"); */ $('.mdl').show();  },   
    ajaxStop: function() { /* $body.removeClass("loading"); */$('.mdl').fadeOut(700); }    
});