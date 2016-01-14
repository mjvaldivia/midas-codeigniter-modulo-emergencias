var MapaElementoEliminar = Class({  
    eliminar : function(elemento, mapa){
        var overlay = new google.maps.OverlayView();
        overlay.draw = function() {};
        overlay.setMap(mapa);

        google.maps.event.addListener(elemento, 'rightclick', function(event) {
            var pos = overlay.getProjection().fromLatLngToDivPixel(event.latLng);
            $('#menu-contexto').show();
            $('#menu-contexto').css("left", pos.x);
            $('#menu-contexto').css("top", pos.y);
            
            $("#eliminar-elemento").unbind("click");
            $("#eliminar-elemento").click(function(){
                elemento.setMap(null);
                
                lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
                    if(a.clave != elemento.clave){
                        return true;
                    }
                });

                $('#menu-contexto').hide();
            });
        });
    }
});
