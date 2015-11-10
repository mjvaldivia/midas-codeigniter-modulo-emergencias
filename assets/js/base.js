



$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

$(document).ready(function() {
    
    $(".text-more").livequery(function(){
        $(this).click(function(){
            if($(this).html() == "[Ocultar]"){
                $(this).html("[Ver mas]");   
                $(this).parent().find(".teaser").show();
                $(this).prev(".text-complete").hide();
            } else {
                $(this).html("[Ocultar]");
                $(this).parent().find(".teaser").hide();
                $(this).prev(".text-complete").show();
            }
        });  
    });
    
    $("#sidebar-toggle").click(function(e) {
        e.preventDefault();
        $(".navbar-side").toggleClass("collapsed");
        $("#page-wrapper").toggleClass("collapsed");
        
        if($(".navbar-side").hasClass("collapsed")){
            $(this).qtip('option', 'content.text', 'Mostrar menu'); 
        } else {
            $(this).qtip('option', 'content.text', 'Ocultar menu'); 
        }
    });
    
    
    /**
     * configuracion tooltip
     */
    $("[data-toggle='tooltip']").livequery(function(){
        var my = "bottom center";
        var at = "top center";
        
        var direccion = "arriba";
        if($(this).attr("data-toogle-param") != "" && $(this).attr("data-toogle-param") != "undefined"){
            direccion = $(this).attr("data-toogle-param");
        }
        
        if(direccion == "abajo"){
            my = "top center";
            at = "bottom center";
        }
        
        $(this).qtip({ 
            position: {
                my: my,
                at: at
            },
            show: {

            }
        });
    });
});