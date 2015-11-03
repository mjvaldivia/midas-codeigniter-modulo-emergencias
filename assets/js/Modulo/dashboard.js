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
    reload();
});


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
    });

    $("#rango-fechas").on('cancel.daterangepicker', function(ev, picker) {
        $("#" + fc_desde).val("");
        $("#" + fc_hasta).val("");
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
            errorAjax();
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
            errorAjax();
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
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },

        events: [{
            title: 'All Day Event',
            start: new Date(y, m, 1),
            className: 'fc-green'
        }, {
            title: 'Long Event',
            start: new Date(y, m, d - 5),
            end: new Date(y, m, d - 2),
            className: 'fc-orange'
        }, {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d - 3, 16, 0),
            allDay: false,
            className: 'fc-blue'
        }, {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d + 4, 16, 0),
            allDay: false,
            className: 'fc-red'
        }, {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false,
            className: 'fc-purple'
        }, {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            className: 'fc-default'
        }, {
            title: 'Birthday Party',
            start: new Date(y, m, d + 1, 19, 0),
            end: new Date(y, m, d + 1, 22, 30),
            allDay: false,
            className: 'fc-white'
        }]
    });

}