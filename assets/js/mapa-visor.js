/**
 * Inicio front-end
 */
$(document).ready(function() {
    
    var id = $("#id").val();
    
    var visor = new Visor("mapa");
    
    var height = $(window).height();
    visor.seteaHeight(height - 50);
    visor.seteaEmergencia(id);

     //custom
    var custom = new MapaElementoCustom();
    custom.emergencia(id);
    visor.addOnReadyFunction("elementos personalizados", custom.loadCustomElements, true);
    
    var kml = new MapaKml();
    kml.seteaEmergencia(id);
    visor.addOnReadyFunction("Carga kml", kml.loadKml, true);

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
    
    // menu superior derecho
    visor.addOnReadyFunction("menu derecho",function(map){
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('menu-derecho'));
        
        $("#menu-derecho").removeClass("hidden");
        
        $(".menu-capa-checkbox").click(function(){
            var id = $(this).val();
            if($(this).is(":checked")){
                capas.addCapa(id);
            } else {
                capas.removeCapa(id);
            }
        });
        
        /*
        $(".capas-seleccionar-todo").click(function(e){
            var padre = $(this).parents().get(6);
            if($(this).is(":checked")){
                $(padre).find(".capas-borrar-todo").prop( "checked", false );
                $(padre).find(".menu-capa-checkbox").prop( "checked", true );
            } else {
                $(padre).find(".menu-capa-checkbox").prop( "checked", false);
            }
        });*/
    });
    
    // input de busqueda de direcciones
    visor.addOnReadyFunction("buscador de direcciones",
        function(map){
           $("#busqueda").parent().removeClass("hidden");
           var input = document.getElementById('pac-input');

           ac = new google.maps.places.Autocomplete(input, {
               componentRestrictions: {country: 'cl'}
           });

           ac.addListener('place_changed', function () {
               var place = ac.getPlace();
               if (place.length === 0) {
                   return;
               }

               map.setCenter(place.geometry.location);

               //se borra marcador de busqueda si ya existia
               if(!(marker_search == null)){
                   marker_search.setMap(null);
                   marker_search = null;
               }

               //se agrega marcador
               var marker = new google.maps.Marker({
                   position: place.geometry.location,
                   icon: {
                     path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                     scale: 3
                   },
                   draggable: true,
                   map: map
               });

               marker.setAnimation(google.maps.Animation.BOUNCE);

               marker_search = marker;

               map.addListener('center_changed', function(event) {
                   marker_search.setMap(null);
                   marker_search = null;
                   google.maps.event.clearInstanceListeners(this);
               });

           });
           map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById('busqueda'));
        }
    );


    //inicia mapa
    visor.bindMapa();
    
    //recargar mapa al abrir o cerrar menu
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
});


