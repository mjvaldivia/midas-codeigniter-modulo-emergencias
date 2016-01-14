var MapaRectanguloClickListener = Class({  
   /**
     * 
     * @param {google.maps.Cyrcle} poligono
     * @returns {void}
     */
    addClickListener : function(rectangulo){
        var yo = this;
        rectangulo.addListener('click', function(event) {
                        
            var marcadores = {};
            //se recorren marcadores, y se buscan los dentro del poligono
            $.each(lista_markers, function(i, marker){
                
                var bo_marcador_dentro_de_poligono = yo.pointInCircle(marker.getPosition(), circulo.getRadius(), circulo.getCenter())
                
                if(bo_marcador_dentro_de_poligono){
                    marcadores[i] = marker.informacion;
                    
                    if(marker.capa != null){
                        marcadores[i]["CAPA"] = marker.capa;
                     }
                }
              
            });
           
            var popup = new MapaInformacionElemento();
            popup.popupInformacion(marcadores, rectangulo);
        });
    }
});

