var MapaInformacionElementoContenido = Class({ 
    
    /**
     * Marcadores contenidos dentro del elemento
     */
    marcadores : [],
    formas: [],
    
    /**
     * 
     * @returns {yo.marcadores}
     */
    retornaMarcadores : function(){
        return this.marcadores;
    },
    
    retornaFormas : function(){
        return this.formas;
    },
    
    /**
     * Recupera las formas que se encuentran dentro del elemento
     * @param {type} elemento
     * @returns {undefined}
     */
    procesaFormas : function(elemento){
        var yo = this;
        
        $.each(lista_poligonos, function(i, forma){
            
            if(forma.clave != elemento.clave){
                var bo_forma_dentro_de_poligono = false;
                switch(forma.tipo){
                    case "POLIGONO":
                        $.each(forma.getPath().getArray(), function(i, val){
                            if(!bo_forma_dentro_de_poligono){
                                var posicion = new google.maps.LatLng(parseFloat(val.lat()), parseFloat(val.lng()));
                                bo_forma_dentro_de_poligono = elemento.getBounds().contains(posicion);
                            } else {
                                return false
                            }
                        });
                        break;
                }

                if(bo_forma_dentro_de_poligono){
                    
                    var data = {"informacion" : forma.informacion};

                    if(forma.capa != null){
                        data["CAPA"] = forma.capa;
                    }
                    
                    yo.formas.push(data);
                }
            }
        });
    },
    
    /**
     * Recupera los marcadores que se encuentren dentro del elemento
     * @param {object} elemento
     * @returns {undefined}
     */
    procesaMarcadores : function(elemento){
        var yo = this;
        
        //se recorren marcadores, y se busca los que estan dentro del elemento
        $.each(lista_markers, function(i, marker){
            var bo_marcador_dentro_de_poligono = false;
            switch(elemento.tipo){
                case "RECTANGULO":
                    bo_marcador_dentro_de_poligono = elemento.getBounds().contains(marker.getPosition());
                    break;
                //se debe considerar solo la forma de dona o la zona principal
                case "CIRCULO LUGAR EMERGENCIA":
                    bo_marcador_dentro_de_poligono = (google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), elemento.getCenter()) <= elemento.getRadius());
                    if(bo_marcador_dentro_de_poligono){

                        //se buscan hermanas menores, que contengan el marcador
                        var zonas = jQuery.grep(lista_poligonos, function( a ) {
                            if(a["tipo"] == "CIRCULO LUGAR EMERGENCIA" && a["identificador"] != elemento.identificador){
                                if(a.getRadius() < elemento.getRadius()){
                                    if((google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), a.getCenter()) <= a.getRadius())){
                                        return true;
                                    }
                                }
                            }
                        });

                        //si una hermana menor tiene el marcador, se quita el marcador
                        if(zonas.length > 0){
                           bo_marcador_dentro_de_poligono = false;
                        }
                    }
                    break;

                case "CIRCULO":
                    bo_marcador_dentro_de_poligono = (google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), elemento.getCenter()) <= elemento.getRadius());
                    break;
                case "POLIGONO":
                default:
                    bo_marcador_dentro_de_poligono  = elemento.containsLatLng(marker.getPosition()); 
                    break;
            }

            if(bo_marcador_dentro_de_poligono){
                var data = {"informacion" : marker.informacion};
                
                //el marcador pertenece a una capa
                if(marker.capa != null){
                    data["CAPA"] = marker.capa;
                }
                
                yo.marcadores.push(data);
            }
        });
    }
});

