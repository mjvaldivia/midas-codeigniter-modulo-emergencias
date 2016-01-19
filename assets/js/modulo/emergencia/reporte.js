/**
 * Inicio front-end
 */
$(document).ready(function() {
    
    var id = $("#id").val();
    
    var visor = new Visor("mapa");

    visor.seteaHeight(300);
    visor.seteaEmergencia(id);
    
    //custom
    var custom = new MapaElementoCustom();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, null);
    
    //marcadores
    var lugar_alarma = new MapaMarcadorLugarAlarma();
    visor.addOnReadyFunction("marcador del lugar de la alarma", lugar_alarma.marcador, null);
    
     //marcadores
    var lugar_emergencia = new  MapaMarcadorLugarEmergencia();
    visor.addOnReadyFunction("marcador del lugar de la emergencia", lugar_emergencia.marcador, null);
    
    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);
    
    //inicia mapa
    visor.bindMapa();
});


