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
    
    /**
     * 
     * @returns {Array}
     */
    retornaFormas : function(){
        return this.formas;
    },
    
    /**
     * Retorna coordenadas del contorno de un circulo
     * @param {google.maps.LatLng} center
     * @param {int} rad
     * @returns {Array}
     */
    coordenadasCirculo : function(center, rad) { // radius of the circle
        rad = (rad/1600);
        var d2r = Math.PI / 180;
        var circleLatLngs = new Array(); // latLngs of circle
        var circleLat = (rad /3987) / d2r; // miles
        var circleLng = circleLat / Math.cos(center.lat() * d2r);
        // Create polygon points (extra point to close polygon)
        for (var i = 0; i < 361; i++) {
            // Convert degrees to radians
            var theta = i * d2r;
            var vertexLat = center.lat() + (circleLat * Math.sin(theta));
            var vertexLng = center.lng() + (circleLng * Math.cos(theta));
            var vertextLatLng = new google.maps.LatLng(
            parseFloat(vertexLat), parseFloat(vertexLng));
            circleLatLngs.push(vertextLatLng);
        }
        return circleLatLngs;
    },
    
    /**
     * Recupera las formas que se encuentran dentro del elemento
     * @param {type} elemento
     * @returns {undefined}
     */
    procesaFormas : function(elemento, mapa){
        var yo = this;
        
        $.each(lista_poligonos, function(i, forma){
            if(forma.clave != elemento.clave){
                var existe = jQuery.grep(yo.formas, function( a ) {
                    if(a["clave"] == forma.clave && a.nombre == forma.nombre){
                        return true;
                    }
                });
                
                if(existe.length == 0){
                
                    var bo_forma_dentro_de_poligono = yo.elementoContainsElemento(elemento, forma, true);

                    if(bo_forma_dentro_de_poligono){
                        var data = {"clave" : forma.clave,
                                    "nombre" : forma.nombre,
                                    "informacion" : forma.informacion};
                        if(forma.capa != null){
                            data["CAPA"] = forma.capa;
                        }

                        yo.formas.push(data);
                    }
                }
            }
        });
    },
    
    /**
     * Ve si un elemento se intersecta con otro
     * @param {object} elemento
     * @param {object} forma
     * @param {boolean} repetir repite el proceso de forma inversa
     * @returns {contenidoAnonym$0.elementoContainsElemento@call;elementoContainsElemento|Boolean}
     */
    elementoContainsElemento : function(elemento, forma, repetir){
        
        var bo_forma_dentro_de_poligono = false;
        
        if(this.checkBounds(elemento, forma)){
        
            var yo = this;
           
            switch(forma.tipo){
                case "POLIGONO":
                    $.each(forma.getPath().getArray(), function(m, val){
                        if(!bo_forma_dentro_de_poligono){
                            var posicion = new google.maps.LatLng(parseFloat(val.lat()), parseFloat(val.lng()));
                            bo_forma_dentro_de_poligono = yo.elementoContainsPoint(elemento, posicion);
                        } else {
                            return false
                        }
                    });
                    break;
                case "RECTANGULO":
                    var bounds = forma.getBounds();
                    var NE = bounds.getNorthEast();
                    var SW = bounds.getSouthWest();
                    var NW = new google.maps.LatLng(NE.lat(),SW.lng());
                    var SE = new google.maps.LatLng(SW.lat(),NE.lng());

                    bo_forma_dentro_de_poligono = yo.elementoContainsPoint(elemento, NE);
                    bo_forma_dentro_de_poligono = bo_forma_dentro_de_poligono || yo.elementoContainsPoint(elemento, SW);
                    bo_forma_dentro_de_poligono = bo_forma_dentro_de_poligono || yo.elementoContainsPoint(elemento, NW);
                    bo_forma_dentro_de_poligono = bo_forma_dentro_de_poligono || yo.elementoContainsPoint(elemento, SE);

                    break;
                case "CIRCULO":
                case "CIRCULO LUGAR EMERGENCIA":
                    var puntos_circulo = yo.coordenadasCirculo(forma.getCenter(), forma.getRadius());
                    $.each(puntos_circulo, function(j, punto){
                        if(!bo_forma_dentro_de_poligono){
                            bo_forma_dentro_de_poligono = yo.elementoContainsPoint(elemento, punto);
                        } else {
                            return false
                        }
                    });
                    break;
            }

            //repite la operacion de forma inversa
            if(!bo_forma_dentro_de_poligono && repetir){
               bo_forma_dentro_de_poligono = this.elementoContainsElemento(forma, elemento, false);
            }
        }
        
        return bo_forma_dentro_de_poligono;
    },
    
    /**
     * Ve si un elemento contiene un punto
     * @param {object} elemento
     * @param {object} posicion
     * @returns {Boolean}
     */
    elementoContainsPoint : function(elemento, posicion){
        var bo_dentro = false;
        switch(elemento.tipo){
            case "RECTANGULO":
                bo_dentro = elemento.getBounds().contains(posicion);
                break;
            //se debe considerar solo la forma de dona o la zona principal
            case "CIRCULO LUGAR EMERGENCIA":
                bo_dentro = (google.maps.geometry.spherical.computeDistanceBetween(posicion, elemento.getCenter()) <= elemento.getRadius());
                if(bo_dentro){

                    //se buscan hermanas menores, que contengan el marcador
                    var zonas = jQuery.grep(lista_poligonos, function( a ) {
                        if(a["tipo"] == "CIRCULO LUGAR EMERGENCIA" && a["identificador"] != elemento.identificador){
                            if(a.getRadius() < elemento.getRadius()){
                                if((google.maps.geometry.spherical.computeDistanceBetween(posicion, a.getCenter()) <= a.getRadius())){
                                    return true;
                                }
                            }
                        }
                    });

                    //si una hermana menor tiene el marcador, se quita el marcador
                    if(zonas.length > 0){
                       bo_dentro = false;
                    }
                }
                break;

            case "CIRCULO":
                bo_dentro = (google.maps.geometry.spherical.computeDistanceBetween(posicion, elemento.getCenter()) <= elemento.getRadius());
                break;
            case "POLIGONO":
            default:
                bo_dentro  = elemento.containsLatLng(posicion); 
                break;
        }
        
        return bo_dentro;
    },
    
    /**
     * Filtra elementos por los que estan cerca
     * @param {type} elemento
     * @param {type} forma
     * @returns {unresolved}
     */
    checkBounds : function(elemento, forma){
        if(elemento.tipo == "LINEA" || forma.tipo == "LINEA"){
            return false;
        } else {
            var elemento_bound = new google.maps.LatLngBounds(elemento.getBounds().getSouthWest(),elemento.getBounds().getNorthEast());
            var forma_bound = new google.maps.LatLngBounds(forma.getBounds().getSouthWest(), forma.getBounds().getNorthEast());
            return elemento_bound.intersects(forma_bound);       
        }
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
            if(marker.getVisible()){
                var bo_marcador_dentro_de_poligono = yo.elementoContainsPoint(elemento, marker.getPosition());

                if(bo_marcador_dentro_de_poligono){
                    var data = {"informacion" : marker.informacion};

                    //el marcador pertenece a una capa
                    if(marker.capa != null){
                        data["CAPA"] = marker.capa;
                    }

                    yo.marcadores.push(data);
                }
            }
        });
    }
});

