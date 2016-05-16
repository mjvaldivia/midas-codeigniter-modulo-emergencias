

/**
 * Inicio front-end
 */
$(document).ready(function() {
    

    
    var id = $("#id").val();
    
    var visor = new Visor("mapa");
    
    var height = $(window).height();
    visor.seteaHeight(height - 60);
    visor.seteaEmergencia(id);

    var tareas = new MapaLoading();
    visor.addOnReadyFunction("visor de tareas", tareas.iniciarLoading, true);
    
     //custom
    var custom = new MapaElementos();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, true);
    
    var archivos = new MapaArchivos();
    archivos.seteaEmergencia(id);
    visor.addOnReadyFunction("Carga kml", archivos.loadArchivos, true);

    // menu superior derecho
    visor.addOnReadyFunction("menu derecho",function(map){
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('menu-derecho'));
        
        var menu = new MapaLayoutCapas();
        menu.seteaMapa(map);
        menu.seteaEmergencia(id);
        menu.render();
        
        $("#menu-derecho").removeClass("hidden");
        
        $(".menu-capa-checkbox").livequery(function(){
            $(this).click(function(){
                var id = $(this).val();
                if($(this).is(":checked")){
                    capas.addCapa(id);
                } else {
                    capas.removeCapa(id);
                }
            });
        });
    });


    //capas
    var capas = new MapaCapa();
    capas.emergencia(id);
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.capasPorEmergencia, null);
    
    //editor
    var editor = new MapaEditor();
    editor.seteaEmergencia(id);
    editor.seteaClaseCapa(capas);
    visor.addOnReadyFunction("editor", editor.iniciarEditor, null);
    visor.addOnReadyFunction("instalaciones", editor.controlInstalaciones, null);
    visor.addOnReadyFunction("boton ubicacion emergencia", editor.controlEditar, null);
    visor.addOnReadyFunction("boton para guardar", editor.controlSave, null);
    visor.addOnReadyFunction("boton para importar", editor.controlImportar, null);
    visor.addOnReadyFunction("boton para capas", editor.controlCapas, null);
    
    // menu inferior para elementos cargados
    visor.addOnReadyFunction(
            "menu inferior", 
            function(map){
                $(".top-menu").parent().removeClass("hidden");
                $(".top-menu").slideupmenu({slideUpSpeed: 150, slideDownSpeed: 200, ease: "easeOutQuad", stopQueue: true});  
                map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(document.getElementById('slideup-menu'));  
            }
            , null
    );
    
    
    
    // input de busqueda de direcciones
    var buscador = new MapaLayoutInputBusqueda("busqueda");
    visor.addOnReadyFunction("buscador de direcciones", buscador.addToMap);
    visor.addOnReadyFunction("centrar mapa", visor.centrarLugarEmergencia);
    
    var formulario = new MapaLayoutFormCasosFebrilesFecha();
    visor.addOnReadyFunction("buscador", formulario.addToMap);
    
    var formulario = new MapaLayoutFormMareaRoja();
    visor.addOnReadyFunction("buscador marea roja", formulario.addToMap);
    
    var formulario = new MapaLayoutFormVectores();
    visor.addOnReadyFunction("buscador vectores", formulario.addToMap);
    
    //inicia mapa
    visor.bindMapa();
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
    /*
    window.onbeforeunload = function confirmExit() {
        return "Se han efectuado cambios en el mapa. <br> ¿Desea guardar estos cambios antes de salir?";
    };
    */
});


