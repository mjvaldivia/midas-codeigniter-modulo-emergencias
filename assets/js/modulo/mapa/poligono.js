var lista_poligonos = [];


var MapaPoligono = Class({
    
    /**
     * Google map
     */
    mapa : null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Quita el poligono del mapa
     * @param {string} atributo
     * @param {string} valor
     * @returns {void}
     */
    removerPoligono : function(atributo, valor){
        var arr = jQuery.grep(lista_poligonos, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });
        
        $.each(arr, function(i, poligono){
           poligono.setMap(null); 
        });
        
        //se quita el poligono de la lista
        lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });
    },
    
    /**
     * Dubuja poligono en el mapa
     * @param {mixed} capa si es null el poligono no pertenece a capa
     * @param {object} geometry
     * @param {string} zona
     * @param {string} color
     * @returns {void}
     */
    dibujarPoligono : function(id, capa, geometry, propiedades, zona, color){

        var yo = this;
        
        var poligono = new google.maps.Polygon({
            paths: yo.coordenadas(geometry, zona),
            identificador: id,
            clave : "poligono_" + id,
            capa: capa,
            informacion: propiedades,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35
        });
        
        poligono.setMap(this.mapa);
        
        //se agrega evento de click para ver instalaciones
        //dentro de poligono
        this.addClickListener(poligono, this.mapa);
        
        lista_poligonos.push(poligono);
    },
    
    /**
     * 
     * @param {google.maps.Polygon} poligono
     * @returns {void}
     */
    addClickListener : function(poligono, mapa){
        var yo = this;
        poligono.addListener('click', function(event) {
            
            //si el poligono pertenece a una capa
            //se buscan todos los poligonos que pertenecen a esta
            var seleccion = {};
            if(poligono.capa != null){
                seleccion = jQuery.grep(lista_poligonos, function( a ) {
                    if(a["identificador"] == poligono.identificador){
                        return true;
                    }
                });
            //si no, solo se buscan marcadores en el poligono actual
            } else {
                seleccion[0] = poligono;
            }
            
            var marcadores = {};
            //se recorren marcadores, y se buscan los dentro del poligono
            $.each(lista_markers, function(i, marker){
               $.each(seleccion, function(j, poligono_seleccionado){
                   
                    var bo_marcador_dentro_de_poligono = poligono_seleccionado.containsLatLng(marker.getPosition()); 
                    
                    if(bo_marcador_dentro_de_poligono){
                        marcadores[i] = marker.informacion;
                        
                        if(marker.capa != null){
                           marcadores[i]["CAPA"] = marker.capa;
                        }
                    }
               });
            });
            
            var popup = new MapaInformacionElemento();
            popup.popupInformacion(marcadores, poligono);
        });
        
        var eliminar = new MapaElementoEliminar();
        eliminar.eliminar(poligono, mapa);
    },
    
    
    
    /**
     * Retorna coordenadas del poligono
     * @param {object} geometry
     * @param {string} zona
     * @returns {Array}
     */
    coordenadas : function(geometry, zona){
        var poligono = [];
        var i;
        $.each(geometry, function(i, coordenadas){
           $.each(coordenadas, function(j, valores){
               LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(valores[0]), parseFloat(valores[1]), zona);
               poligono.push(new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1])));
           });
        });
        
        return poligono;
    }
});


