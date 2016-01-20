/**
 * Inicio front-end
 */
$(document).ready(function() {
    
    var id = $("#id").val();
    
    var visor = new Visor("mapa");
    
    var height = $(window).height();
    visor.seteaHeight(height - 65);
    visor.seteaEmergencia(id);

    //custom
    var custom = new MapaElementoCustom();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, null);
    
    //marcadores
    var lugar_alarma = new MapaMarcadorLugarAlarma();
    lugar_alarma.seteaEmergencia(id);
    visor.addOnReadyFunction("marcador del lugar de la alarma", lugar_alarma.marcador, null);
    
     //marcadores
   /* var lugar_emergencia = new  MapaMarcadorLugarEmergencia();
    lugar_emergencia.seteaEmergencia(id);
    visor.addOnReadyFunction("marcador del lugar de la emergencia", lugar_emergencia.marcador, null);*/
    
    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);
    
    //editor
    var editor = new MapaEditor();
    editor.seteaEmergencia(id);
    editor.seteaClaseCapa(capas);
    visor.addOnReadyFunction("editor", editor.iniciarEditor, null);
    
    visor.addOnReadyFunction("boton ubicacion emergencia", editor.controlEditar, null);
    visor.addOnReadyFunction("boton popup capas", editor.controlCapas, null);
    visor.addOnReadyFunction("boton para guardar", editor.controlSave, null);
    //visor.addOnReadyFunction("boton para cargar instalaciones", editor.controlInstalaciones, null);

    //inicia mapa
    visor.bindMapa();
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
});


