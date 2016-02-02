var MapaMarcadorMoveListener = Class({  
    
   /**
     * 
     * @param {google.maps.Marker} marker
     * @mapa {google.maps}
     * @returns {void}
     */
    addMoveListener : function(marker, mapa){
        var yo = this;
        console.log(marker);
        marker.addListener('dragend', function(event) {    
            
            var marcadores = jQuery.grep(lista_poligonos, function( a ) {
                if(a["clave"] == lista_poligonos.clave){
                    return true;
                }
            });
            
            $.each(marcadores, function(i, elemento){
                if(elemento.tipo == "CIRCULO"){
                    console.log(elemento);
                }
            });
        });
        
    } 

});


