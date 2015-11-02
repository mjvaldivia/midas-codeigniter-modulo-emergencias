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
});

//Custom jQuery - Changes background on time tile based on the time of day.
$(document).ready(function() {
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
   
});

