$(document).ready(function(){
    var visor = new Visor("mapa");

    visor.setCenter($("#latitud").val(),$("#longitud").val());

    var capas = new MapaCapa();
    visor.addOnReadyFunction(
        "edicion", 
        function(mapa){
            //al cargar marcador, se seta como dragable
            google.maps.event.addListenerOnce(mapa, 'marcador_cargado', function(){
                $.each(lista_markers, function(i, marker){
                    marker.setDraggable(true); 
                    
                    google.maps.event.addListener(marker, 'dragend', function (){
                        var posicion = marker.getPosition();
                        $('#longitud').val(parseFloat(posicion.lng()));
                        $('#latitud').val(parseFloat(posicion.lat()));
                    });
                    
                    
                });
            });
            
        }
    );
    
    visor.addOnReadyFunction("capas asociadas a la emergencia", capas.addElemento, $("#id_item").val());
    

    visor.bindMapa();
}); 



