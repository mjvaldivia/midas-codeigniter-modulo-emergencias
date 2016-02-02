var MapaLinea = Class({
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
    
    
    dibujarLinea : function(id, capa, geometry, propiedades, zona){
        var yo = this;
        
        var linea = new google.maps.Polyline({
            path: yo.coordenadas(geometry, zona),
            identificador: id,
            clave : "poligono_" + id,
            capa: capa,
            informacion: propiedades,
            
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        linea.setMap(this.mapa);
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
               poligono.push(new google.maps.LatLng(parseFloat(valores[0]), parseFloat(valores[1])));
           });
        });
        
        return poligono;
    }
});


