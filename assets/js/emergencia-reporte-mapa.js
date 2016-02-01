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
    
    //custom
    var custom = new MapaElementoCustom();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, null);
    
    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);
    
    //inicia mapa
    visor.bindMapa();
});


