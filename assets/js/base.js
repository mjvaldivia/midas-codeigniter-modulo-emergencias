$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};

$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

$(document).ready(function() {
    
    $(".datatable.paginada").livequery(function(){
        if($(this).parent().hasAttr('data-row')) {
            var filas = parseInt($(this).parent().attr("data-row"));
        } else {
            var filas = 10;
        }
        
        var id = $(this).attr("id");
        $(this).dataTable({
            "lengthMenu": [[5,10, 25, 50], [5,10, 25, 50]],
            "pageLength": filas,
            "destroy" : true,
            "aaSorting": [],
            language: 
                {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
            "fnDrawCallback": function( oSettings ) {
                $("#" + id).removeClass("hidden");
             }
        });
    });
    
    
    $(".form-busqueda").livequery(function(){
        
       var button = $(this).find(".btn-buscar"); 
        
       $(this).find("input").keypress(function (evt) {
            var charCode = evt.charCode || evt.keyCode;
            if (charCode  == 13) {
                $(button).trigger("click");
                return false;
            }
       });
       
       /*$(this).find("select").change(function(){
           $(button).trigger("click");
       });*/
    });
    
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