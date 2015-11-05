



$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

$(document).ready(function() {
    
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