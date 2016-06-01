/**
 * Inicio front-end
 */
$(document).ready(function() {

    var id = $("#id").val();
    
    var visor = new Visor("mapa");
    
    var height = $(window).height();
    visor.seteaHeight(height);
    visor.seteaEmergencia(id);

    // modifica tamaño de visor cuando cambia tamaño ventana
    $(window).resize(function() {
        var height = $(window).height();
        visor.seteaHeight(height);
        visor.resize();
    });


    var tareas = new MapaLoading();
    visor.addOnReadyFunction("visor de tareas", tareas.iniciarLoading, true);
    
     //custom
    var custom = new MapaElementos();
    custom.seteaPopupPoligono(false);
    custom.emergencia(id);
    
    custom.addOnLoadFunction("Datos externos" , function(data, mapa){
        if(parseInt(data.resultado.marea_roja) == 1 || parseInt(data.resultado.marea_roja_pm) == 1){
            var formulario = new MapaLayoutFormMareaRoja();
            formulario.seteaEmergencia(id);
            formulario.addExcelToMap(mapa);
        }
    });
    
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, true);
    
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
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
});
