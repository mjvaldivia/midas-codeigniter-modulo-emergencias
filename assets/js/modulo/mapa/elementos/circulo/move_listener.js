var MapaCirculoMoveListener = Class({  
   /**
     * 
     * @param {google.maps.Cyrcle} poligono
     * @returns {void}
     */
    addMoveListener : function(circulo, mapa){
        var yo = this;

        circulo.addListener('center_changed', function(event) {         
            var marcadores = jQuery.grep(lista_markers, function( a ) {
                if(a["clave"] == circulo.clave){
                    return true;
                }
            });
            
            $.each(marcadores, function(i, marker){
                marker.setPosition(circulo.getCenter()); 
            });
        });
        
    }, 

});



