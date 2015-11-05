//Moment.js Time Display
var datetime = null,
    date = null;

var update = function() {
    date = moment(new Date());
    datetime.html(date.lang("es").format('dddd<br>MMMM D, YYYY<br>h:mm:ss A'));
};

$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};

$(document).ready(function() {
    
    datetime = $('#datetime')
    update();
    setInterval(update, 1000);

    datetoday = new Date(); // create new Date()
    timenow = datetoday.getTime(); // grabbing the time it is now
    datetoday.setTime(timenow); // setting the time now to datetoday variable
    hournow = datetoday.getHours(); //the hour it is

    if (hournow >= 18) // if it is after 6pm
        $('div.tile-img').addClass('evening');
    else if (hournow >= 12) // if it is after 12pm
        $('div.tile-img').addClass('afternoon');
    else if (hournow >= 6) // if it is after 6am
        $('div.tile-img').addClass('morning');
    else if (hournow >= 0) // if it is after midnight
        $('div.tile-img').addClass('midnight');

    setRangoFechas();
    setCalendario();
    setGrafico();
    reload();
    
    
    $(".datatable.paginada").livequery(function(){
        if($(this).parent().hasAttr('data-row')) {
            var filas = parseInt($(this).parent().attr("data-row"));
        } else {
            var filas = 10;
        }
        
        var id = $(this).attr("id");
        $(this).dataTable({
            "pageLength": filas,
            "aaSorting": [],
            language: {
                        url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
                    },
            "fnDrawCallback": function( oSettings ) {
                $("#" + id).removeClass("hidden");
             }
        });
    });
});

function setGrafico(){
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
                    resize: true
                });
            }
        }
    });
}


function setRangoFechas(){
    var fc_desde = $("#rango-fechas").next("input").attr("id");
    var fc_hasta = $("#rango-fechas").next("input").next().attr("id");
    var fecha = $("#rango-fechas");

    $("#rango-fechas").daterangepicker({ 
        format: 'DD/MM/YYYY',
        showDropdowns: true,
        showWeekNumbers: true,
        locale: {
            applyLabel: 'Seleccionar',
            cancelLabel: 'Cancelar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Cambiar fechas',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mie', 'Jue', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 1
        }
    },
    function(start, end, label) {
        $(fecha).find("span").html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#" + fc_desde).val(start.format('DD/MM/YYYY'));
        $("#" + fc_hasta).val(end.format('DD/MM/YYYY'));
        $(fecha).addClass("btn-success");
        reload();
    });
   
    var fecha_desde = moment($("#fecha_desde").val(), "DD/MM/YYYY"); 
    var fecha_hasta = moment($("#fecha_hasta").val(), "DD/MM/YYYY");  
    $(fecha).find("span").html(fecha_desde.format('MMM D, YYYY') + ' - ' + fecha_hasta.format('MMM D, YYYY'));
}



function reload(){
    reloadCantidadAlertas();
    reloadCantidadEmergencias();
    reloadGrillaEmergencias();
    reloadGrillaAlarmas();
}

function reloadCantidadAlertas(){
    var params = {"desde" : $("#fecha_desde").val(),
                  "hasta" : $("#fecha_hasta").val()};
    
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: params,
        type: "post",
        url: siteUrl + "home/json_cantidad_alarmas", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(data){
            if(data.correcto){
                $("#alarmas-cantidad").html(data.cantidad);
            }
        }
    });
}

function reloadCantidadEmergencias(){
    var params = {"desde" : $("#fecha_desde").val(),
                  "hasta" : $("#fecha_hasta").val()};
    
    $.ajax({         
        dataType: "json",
        cache: false,
        async: true,
        data: params,
        type: "post",
        url: siteUrl + "home/json_cantidad_emergencia", 
        error: function(xhr, textStatus, errorThrown){
            
        },
        success:function(data){
            if(data.correcto){
                $("#emergencias-cantidad").html(data.cantidad);
            }
        }
    });
}

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

function setCalendario(){
    
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    /* initialize the calendar
        -----------------------------------------------------------------*/

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
                    alert('there was an error while fetching events!');
                },
                color: 'orange',   // a non-ajax option
                textColor: 'black' // a non-ajax option
            },
            {
                url: siteUrl + 'home/json_eventos_calendario_emergencias',
                type: 'POST',
                error: function() {
                    alert('there was an error while fetching events!');
                },
                color: 'red',   // a non-ajax option
                textColor: 'white' // a non-ajax option
            }
        ]
    });

}