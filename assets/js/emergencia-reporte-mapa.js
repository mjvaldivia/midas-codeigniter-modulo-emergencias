/**
 * Inicio front-end
 */
$(document).ready(function() {
    
    var id = $("#id").val();
    var lat = $("#lat").val();
    var lon = $("#lon").val();
    
    var visor = new Visor("mapa");

    visor.seteaHeight(500);
    visor.seteaEmergencia(id);
    visor.setCenter(parseFloat(lat),parseFloat(lon));
    
    var tareas = new MapaLoading();
    visor.addOnReadyFunction("visor de tareas", tareas.iniciarLoading, true);
    
    //custom
    var custom = new MapaElementos();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, null);
    
     var archivos = new MapaArchivos();
    archivos.seteaEmergencia(id);
    visor.addOnReadyFunction("Carga kml", archivos.loadArchivos, true);
    
    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);
    visor.addOnReadyFunction("centrar mapa", visor.centrarLugarEmergencia);
    //inicia mapa
    visor.bindMapa();
});


