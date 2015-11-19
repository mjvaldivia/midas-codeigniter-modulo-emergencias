$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};

jQuery.loadCSS = function(url){
    if(!$("link[href = '" + url + "']").length){
        $("head").append('<link rel="stylesheet" type="text/css" href="' + url + '">')
    }
}

$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

$(document).ready(function() {
    
    
    
    $(".datepicker").livequery(function(){
        $(this).datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });
    });
    
    
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
    
    $(".more-less").livequery(function(){
        $(this).unbind( "click" );
        $(this).click(function(){
            var texto = $(this).parent().find(".text-more");
            if($(texto).html() == "[Ocultar]"){
                $(texto).html("[Ver mas]");   
                $(this).parent().find(".teaser").show();
                $(this).parent().find(".text-complete").hide();
            } else {
                $(texto).html("[Ocultar]");
                $(this).parent().find(".teaser").hide();
                $(this).parent().find(".text-complete").show();
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
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "home/ajax_menu_collapse", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(json){

            }
        });
        
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


/**
 * Procesa los errores en la validacion de formularios
 * Ilumina los input con error
 * @param {type} errores
 * @returns {undefined}
 */
function procesaErrores(errores){
    $.each(errores, function(i, valor){
        var parent = getFormParent($("#" + i).parent(), 1);
        
        if(parent!=null){
            if(valor!=""){
                $(parent).addClass("has-error");
                $(parent).children(".help-block").removeClass("hidden");
                $(parent).children(".help-block").html("<i class=\"glyphicon glyphicon-warning-sign\"></i> " + valor);
            } else {
                $(parent).removeClass("has-error");
                $(parent).children(".help-block").addClass("hidden");
            }
        }
    });
}

function getFormParent(parent, intento){
    if(intento > 4){
        return null;
    } else {
        if($(parent).hasClass("form-group")){
            return parent;
        } else {
            return getFormParent($(parent).parent(), intento +1);
        }
    }
}

var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};

function notificacionCorrecto(titulo, texto){
    new PNotify({ title: titulo, text: texto, type: 'success',addclass: "stack-bottomright",
        stack: stack_bottomright});
}

function notificacionError(titulo, texto){
    new PNotify({ title: titulo, text: texto, type: 'danger',addclass: "stack-bottomright",
        stack: stack_bottomright });
}