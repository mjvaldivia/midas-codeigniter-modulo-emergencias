var MapaMarcadorMoveListener = Class({  
    
   /**
     * 
     * @param {google.maps.Marker} marker
     * @mapa {google.maps}
     * @returns {void}
     */
    addMoveListener : function(marker, mapa){
        var yo = this;

        google.maps.event.addListener(marker, 'dragend', function() {
            
            console.log("Comenzando dragend");
            
            var marcadores = jQuery.grep(lista_poligonos, function( a ) {
                if(a["clave"] == marker.clave){
                    return true;
                }
            });
            
            console.log(marcadores);
            
            $.each(marcadores, function(i, elemento){
                if(elemento.tipo == "CIRCULO" || elemento.tipo == "CIRCULO LUGAR EMERGENCIA"){
                    elemento.setCenter(marker.getPosition());
                }
            });
        } );
        
    } 

});


