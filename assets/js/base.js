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

function formatState (state) {
      if (!state.id) { return state.text; }
      var $state = $(
        '<span><img src="' + state.element.value.toLowerCase() + '" class="img-flag" /> ' + state.text + '</span>'
      );
      return $state;
};

$(document).ready(function() {
    
    $(".datepicker").livequery(function(){
        $(this).datetimepicker({
            format: "DD-MM-YYYY hh:mm"
        });
    });
    
    $(".select2-images").livequery(function(){ 
        $(this).select2({
            templateResult: formatState
        });
    });
    
    $(".select2-tags").livequery(function(){
        $(this).select2({
            width: '100%',
            tags: true,
            allowClear: true
        });
    });
    
    $(".colorpicker").livequery(function(){
        $(this).spectrum({
            allowEmpty:true,
            showInput: true,
            className: "full-spectrum",
            showPalette: true,
            showSelectionPalette: true,
            maxSelectionSize: 10,
            preferredFormat: "hex",
            localStorageKey: "spectrum.demo",
            move: function (color) {
                $(this).val(color.toHexString());
            },
            show: function () {

            },
            beforeShow: function () {

            },
            hide: function () {

            },
            change: function(color) {
               
            },
            palette: [
                ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
                "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
                ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
                ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
                "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
                "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
                "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
                "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
                "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
                "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
            ]
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
            "deferRender": true,
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

var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};
var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};

function notificacionSimulacion(){
    $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "session/ajax_simulacion", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.simulacion){
                    var opts = {
                                title: "El sistema está en modo simulación.",
                                type: 'error',
                                text: "<a href=\"" + siteUrl + "session/termina_simulacion\" class=\"btn btn-xs btn-primary\">SALIR DE MODO SIMULACIÓN</a>",
                                addclass: "stack-bar-bottom",
                                cornerclass: "",
                                hide: false,
                                width: "100%",
                                stack: stack_bar_bottom
                            };
                    new PNotify(opts);
                }
            }
        });
}

function notificacionCorrecto(titulo, texto){
    new PNotify({ title: titulo, text: texto, type: 'success',addclass: "stack-bottomright",
        stack: stack_bottomright});
}

function notificacionError(titulo, texto){
    new PNotify({ title: titulo, text: texto, type: 'danger',addclass: "stack-bottomright",
        stack: stack_bottomright });
}