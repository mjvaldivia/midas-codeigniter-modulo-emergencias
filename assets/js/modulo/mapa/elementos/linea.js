var MapaLinea = Class({
    /**
     * Google map
     */
    mapa : null,
    
    /**
     * Si el elemento tiene clave en BD
     */
    clave_primaria : null,
    
    /**
     * String de relacion con otro elemento (KML u otro)
     */
    relacion: null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * 
     * @param {type} id
     * @returns {undefined}
     */
    seteaClavePrimaria : function(id){
        this.clave_primaria = id;  
    },
    
    /**
     * @param {int} id
     */
    seteaRelacion : function(relacion){
        this.relacion = relacion;
    },
    
    /**
     * 
     * @param {type} id
     * @param {type} capa
     * @param {type} geometry
     * @param {type} propiedades
     * @param {type} zona
     * @param {type} color
     * @returns {undefined}
     */
    dibujarLinea : function(id, capa, geometry, propiedades, zona, color){
        var yo = this;
        
        var linea = new google.maps.Polyline({
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            path: yo.coordenadas(geometry),
            identificador: id,
            clave : "poligono_" + id,
            capa: capa,
            informacion: propiedades,
            tipo: "LINEA",
            geodesic: true,
            strokeColor: "#00000",
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        linea.setMap(this.mapa);
        
        lista_poligonos.push(linea);
    },
    
     /**
     * Retorna coordenadas del poligono
     * @param {object} geometry
     * @param {string} zona
     * @returns {Array}
     */
    coordenadas : function(geometry){
        var poligono = [];
        var i;
        $.each(geometry, function(i, coordenadas){
           $.each(coordenadas, function(j, valores){
               poligono.push(new google.maps.LatLng(parseFloat(valores[0]), parseFloat(valores[1])));
           });
        });
        return poligono;
    }
});


