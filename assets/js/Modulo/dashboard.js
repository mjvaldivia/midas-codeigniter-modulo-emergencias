//Moment.js Time Display
var datetime = null,
    date = null;

var update = function() {
    date = moment(new Date())
    datetime.html(date.format('dddd<br>MMMM Do, YYYY<br>h:mm:ss A'));
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
});

function setGrafico(){
    
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    
    //Morris Line Chart
    Morris.Line({
    // ID of the element in which to draw the chart.
    element: 'morris-chart-line',
    // Chart data records -- each entry in this array corresponds to a point on
    // the chart.
    data: [
          { m: '01', a: 0, b: 270 },
          { m: '02', a: 54, b: 256 },
          { m: '03', a: 243, b: 334 },
          { m: '04', a: 206, b: 282 },
          { m: '05', a: 161, b: 58 },
          { m: '06', a: 187, b: 0 },
          { m: '07', a: 210, b: 0 },
          { m: '08', a: 204, b: 0 },
          { m: '09', a: 224, b: 0 },
          { m: '10', a: 301, b: 0 },
          { m: '11', a: 262, b: 0 },
          { m: '12', a: 199, b: 0 },
        ],
  xkey: 'm',
  ykeys: ['a', 'b'],
  labels: ['2014', '2015'],
  xLabelFormat: function (x) { return months[x.getMonth()]; },
    // Disables line smoothing
    smooth: false,
    resize: true
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