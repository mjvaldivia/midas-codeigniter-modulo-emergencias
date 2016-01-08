/**
 * Inicio front-end
 */
$(document).ready(function() {
    
    var visor = new Visor("mapa");
    
    //marcadores
    var lugar_emergencia = new MapaMarcadorLugarEmergencia();
    visor.addOnReadyFunction("marcador del lugar de la alarma", lugar_emergencia.marcador);
    
    //capas
    var capas = new MapaCapa();
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capas);
    
    
    //poligonos
    
    visor.bindMapa();
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
});


