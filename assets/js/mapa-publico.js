/**
 * Inicio front-end
 */
$(document).ready(function() {

    var id = $("#id").val();
    
    var visor = new Visor("mapa");
    
    var height = $(window).height();
    visor.seteaHeight(height);
    visor.seteaEmergencia(id);

    var tareas = new MapaLoading();
    visor.addOnReadyFunction("visor de tareas", tareas.iniciarLoading, true);
    
     //custom
    var custom = new MapaElementos();
    custom.seteaPopupPoligono(false);
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, true);
    
    var archivos = new MapaArchivos();
    archivos.seteaEmergencia(id);
    visor.addOnReadyFunction("Carga kml", archivos.loadArchivos, true);

    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);

    // menu inferior para elementos cargados
    /*visor.addOnReadyFunction(
        "menu inferior", 
        function(map){
            $(".top-menu").parent().removeClass("hidden");
            $(".top-menu").slideupmenu({slideUpSpeed: 150, slideDownSpeed: 200, ease: "easeOutQuad", stopQueue: true});  
            map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(document.getElementById('slideup-menu'));  
        }
        , null
    );*/

   
    visor.addOnReadyFunction("centrar mapa", visor.centrarLugarEmergencia);
    
    /*
    var formulario = new MapaLayoutFormCasosFebrilesFecha();
    visor.addOnReadyFunction("buscador", formulario.addToMap);
    */
    
    //visor.addOnReadyFunction("buscador marea roja", formularioMareaRoja);
    
    /*
    var formulario = new MapaLayoutFormVectores();
    visor.addOnReadyFunction("buscador vectores", formulario.addToMap);
    */
    
    //inicia mapa
    visor.bindMapa();
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });

});

/**
 * Carga formulario con filtros de marea roja
 * @param {googleMap} mapa
 * @returns {undefined}
 */
function formularioMareaRoja(mapa){
    var formulario = new MapaLayoutFormMareaRoja();
    formulario.seteaPosicion("TOP_LEFT");
    formulario.addToMap(mapa);
    
    
    $("#marea-roja-pm-contenedor-filtro-colores").waitUntilExists(function(){
        
        $("#marea-roja-pm-contenedor-filtro-colores").addClass("hidden");
        
        $("#marea-roja-pm-contenedor-filtro-colores").find(".marea-roja-color").each(function(){
            $(this).prop("checked", false); 
        });
    });
}
