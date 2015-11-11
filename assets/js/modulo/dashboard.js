var content;

$(document).ready(function() {

    load();

    $("#btnCancelar").livequery(function(){
        $(this).click(function(){
            $("#contenedor-home").fadeOut(function(){
                $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
                    $(this).html(content);
                    load();
                });
            });
        });
    });
});

function formEditarAlarma(ala_ia_id){  
    limpiaVista();
    
    content = $("#contenedor-home").html();
    $("#contenedor-home").fadeOut(function(){
            $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
            $(this).load(siteUrl + 'alarma/editar/id/' + ala_ia_id);
        });
    });
}

function formEditarEmergencia(eme_ia_id){  
    limpiaVista();
    
    content = $("#contenedor-home").html();
    $("#contenedor-home").fadeOut(function(){
            $(this).html('<div class="text-center"><i class="fa fa-spin fa-spinner fa-5x"></i></div>').fadeIn(function(){
            $(this).load(siteUrl + 'emergencia/editar/id/' + eme_ia_id);
        });
    });
}

/**
 * Carga datos y grafico de emergencias por tipo
 * @returns void
 */
function setGraficoEmergenciasTipo(){
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: "",
        type: "post",
        url: siteUrl + "home/json_cantidad_emergencia_por_tipo", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(retorno){
            if(retorno.correcto){
                var data = retorno.data;
	
                var plotObj = $.plot($("#flot-chart-pie"), data, {
                    series: {
                        pie: {
                                show: true
                        }
                    },
                    grid: {
                        hoverable: true 
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                            x: 20,
                            y: 0
                        },
                        defaultTheme: false
                    }
                });  
                
                
            }
        }
    }); 
}

/**
 * Carga datos y grafico para emergencias por mes
 * @returns void
 */
function setGraficoEmergenciasMes(){
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: "",
        type: "post",
        url: siteUrl + "home/json_cantidad_emergencia_mes", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(data){
            if(data.correcto){
                var months = ['En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                Morris.Line({
                    element: 'morris-chart-line',
                    data: data.data,
                    xkey: 'm',
                    hideHover: true,
                    ykeys: data.ykeys,
                    labels: data.labels,
                    xLabelFormat: function (x) {
                        return months[x.getMonth()]; 
                    },
                    smooth: false,
                    resize: false
                });
            }
        }
    });
}

function load(){
    setCalendario();
    setGraficoEmergenciasMes();
    setGraficoEmergenciasTipo();
    reloadGrillas();
}

/**
 * Recarga las grillas de emergencias y alertas
 * @returns void
 */
function reloadGrillas(){
    reloadGrillaEmergencias();
    reloadGrillaAlarmas();
}

/**
 * Carga grilla de alarmas
 * @returns void
 */
function reloadGrillaAlarmas(){
    var params = {"desde" : $("#fecha_desde").val(),
                  "hasta" : $("#fecha_hasta").val()};
    
    $.ajax({         
        dataType: "html",
        cache: false,
        async: true,
        data: params,
        type: "post",
        url: siteUrl + "home/ajax_grilla_alarmas", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(html){
            $("#contendor-grilla-alarma").html(html);
        }
    });
}

/**
 * Carga grilla de emergencias
 * @returns void
 */
function reloadGrillaEmergencias(){
    var params = {"desde" : $("#fecha_desde").val(),
                  "hasta" : $("#fecha_hasta").val()};
    
    $.ajax({         
        dataType: "html",
        cache: false,
        async: true,
        data: params,
        type: "post",
        url: siteUrl + "home/ajax_grilla_emergencias", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(html){
            $("#contendor-grilla-emergencia").html(html);
        }
    });
}

/**
 * Carga datos y genera el calendario
 * @returns void
 */
function setCalendario(){
    
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        lang: "es",
        editable: false,
        droppable: false, 
        eventSources: [
            {
                url: siteUrl + 'home/json_eventos_calendario_alertas',
                type: 'POST',
                error: function() {
                    alert('Ha ocurrido un error al cargar las alarmas al calendario!');
                },
                color: 'orange',  
                textColor: 'black'
            },
            {
                url: siteUrl + 'home/json_eventos_calendario_emergencias',
                type: 'POST',
                error: function() {
                    alert('Ha ocurrido un error al cargar las emergencias al calendario!');
                },
                color: 'red',   
                textColor: 'white' 
            }
        ]
    });

}

function limpiaVista(){
    $("#calendar").html("");
    $("#morris-chart-line").html("");
    $("#contendor-grilla-alarma").html("");
    $("#contendor-grilla-emergencia").html(""); 
}