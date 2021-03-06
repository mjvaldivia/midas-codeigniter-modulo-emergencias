//Sidebar Toggle
$("#sidebar-toggle").click(function(e) {
    e.preventDefault();
    $(".navbar-side").toggleClass("collapsed");
    $("#page-wrapper").toggleClass("collapsed");
    
    if($("#navbar-menu").hasClass("collapsed")){
        $("#sidebar-toggle").children("i").html(" Mostrar menu");
    } else {
        $("#sidebar-toggle").children("i").html(" Ocultar menu");
    }
});

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
    
    //boton para exportar tabla a excel
    $(".buttons-excel").livequery(function(){
       $(this).html("<i class=\"fa fa-download\"></i> Exportar tabla a excel");
       $(this).removeClass("dt-button");
       $(this).addClass("btn btn-primary btn-xs");
    });
    
    $('.numero:input').livequery(function(){
        $(this).numeric();
    });
    
    $(".rut:input").mask('0000000000-A', {reverse: true});
    
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    };
    
    $(".datepicker:input").livequery(function(){
        $(this).datetimepicker({
            format: "DD-MM-YYYY HH:mm",
            locale: "es"
        });
    });
    
    $(".datepicker-date:input").livequery(function(){
        $(this).datetimepicker({
            format: "DD/MM/YYYY",
            locale: "es"
        });
    });
    
    $(".select2-images").livequery(function(){ 
        $(this).select2({
            templateResult: formatState
        });
    });
    
    $(".select2-tags").livequery(function(){
        $(this).chosen({
            placeholder_text_multiple: "Seleccione un valor",
            no_results_text: "No se encontraron resultados",
            width: '100%',
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
        
        var buttons = [];
        if($(this).data("export")){
            buttons = [
                'excel'
            ];
        }
        
        var tb = $(this).dataTable({
            "lengthMenu": [[5,10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],
            "pageLength": filas,
            "destroy" : true,
            "aaSorting": [],
            "deferRender": true,
            dom: 'Bfrtip',
            buttons: buttons,
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
    
    
    $(".region").livequery(function(){
        var $this = this;
        if($($this).data("rel")){
           $($this).change(function(){
               if($(this).val()!=""){
                   $("#" + $($this).data("rel")).prop("disabled", true);
                    $.ajax({         
                        dataType: "json",
                        cache: false,
                        async: false,
                        data: {"id" : $(this).val()},
                        type: "post",
                        url: siteUrl + "comuna/json_comunas_region", 
                        error: function(xhr, textStatus, errorThrown){

                        },
                        success:function(data){
                            $("#" + $($this).data("rel")).html("");
                            $("#" + $($this).data("rel")).prop("disabled", false);
                            $("#" + $($this).data("rel")).append("<option value=\"\"> -- Todas -- </option>");
                            $.each(data.comunas, function(i, val){
                                $("#" + $($this).data("rel")).append("<option value=\"" + val.com_ia_id + "\">" + val.com_c_nombre + "</option>");
                            });
                        }
                    }); 
                } else {
                    $("#" + $($this).data("rel")).html("");
                    $("#" + $($this).data("rel")).prop("disabled", true);
                    $("#" + $($this).data("rel")).append("<option value=\"\"> -- Seleccione la region -- </option>");
                }
            });
           
           $($this).trigger("change");
        } 
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

    Messenger().post({
        message:"<strong>" + titulo + "</strong> <br> " + texto,
        type: 'success',
        showCloseButton: true
    });
}

function notificacionError(titulo, texto){

    Messenger().post({
        message:"<strong>" + titulo + "</strong> <br> " + texto,
        type: 'error',
        showCloseButton: true
    });
}

function notificacionEspera(titulo){

    Messenger().post({
        message: titulo,
        type: 'info',
        showCloseButton: true
    });
}

function getController(){
    var str = window.location.href;
    var path = str.replace(baseUrl, "").split('/');
    return path[0];
}

/**
 * Boquea el boton despues de hacer click
 * @param {type} boton
 * @param {type} e
 * @returns {buttonStartProcess.retorno}
 */
function buttonStartProcess(boton, e){
    e.preventDefault();
    $(boton).prop('disabled', true);
    
    var clase_boton = $(boton).children("i").attr("class");
    $(boton).children("i").attr("class","fa fa-refresh fa-spin"); 
    
    var retorno = {"boton" : boton, "clase" : clase_boton};
    return retorno;
}

/**
 * Desbloquea el boton
 * @param {type} retorno
 * @returns {undefined}
 */
function buttonEndProcess(retorno){
    $(retorno.boton).prop('disabled', false);
    $(retorno.boton).children("i").attr("class", retorno.clase);
}


function setInputCorreos(id_input, id_emergencia){
    
    var parametros = {"id" : id_emergencia};
    
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: parametros,
        type: "post",
        url: siteUrl + "usuario/emails_emergencia", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(data){
            inputCorreos(id_input, data);
        }
    });
   
}

function inputCorreos(id_input, options){
    var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

    $('#' + id_input).selectize({
        persist: false,
        maxItems: null,
        create: true,
        valueField: 'email',
        labelField: 'name',
        searchField: ['name', 'email'],
        options: options,
        render: {
            item: function(item, escape) {
                return '<div>' +
                    (item.name ? ' <span class="name">' + escape(item.name) + '</span> ' : '') +
                    (item.email ? '<span><i class="fa fa-chevron-left"></i>' + escape(item.email) + '<i class="fa fa-chevron-right"></i></span>' : '') +
                '</div>';
            },
            option: function(item, escape) {
                var label = item.name || item.email;
                var caption = item.name ? item.email : null;
                return '<div>' +
                    ' <span class="label">' + escape(label) + '</span> ' +
                    (caption ? '<span class="caption"><i class="fa fa-chevron-left"></i>' + escape(caption) + '<i class="fa fa-chevron-right"></i></span>' : '') +
                '</div>';
            }
        },

        createFilter: function(input) {
            var match, regex;

            // email@address.com
            regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
            match = input.match(regex);
            if (match) return !this.options.hasOwnProperty(match[0]);

            // name <email@address.com>
            regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
            match = input.match(regex);
            if (match) return !this.options.hasOwnProperty(match[2]);

            return false;
        },
        create: function(input) {
            if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
                return {email: input};
            }
            var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
            if (match) {
                return {
                    email : match[2],
                    name  : $.trim(match[1])
                };
            }
            alert('El email ingresado no es válido.');
            return false;
        }
    });
}