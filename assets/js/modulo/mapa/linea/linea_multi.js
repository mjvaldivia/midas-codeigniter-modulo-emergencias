var MapaLineaMulti = Class({ extends : MapaLinea}, {
         
    /**
     * Dubuja poligono en el mapa
     * @param {mixed} capa si es null el poligono no pertenece a capa
     * @param {object} geometry
     * @param {string} zona
     * @param {string} color
     * @returns {void}
     */
    dibujarLinea : function(id, capa, geometry, propiedades, zona, color){

        var yo = this;

        $.each(geometry, function(i, multipoligono){
            var coord = [];
            $.each(multipoligono, function(j, coordenadas){
                var LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(coordenadas[0]), parseFloat(coordenadas[1]), zona);
                coord.push({"lat" : parseFloat(LatLng[0]), "lng" : parseFloat(LatLng[1])});
            });
            
           
            
            var linea = new google.maps.Polyline({
                    path: coord,
                    identificador: id,
                    clave : "linea_" + id,
                    capa: capa,
                    informacion: propiedades,

                    geodesic: true,
                    strokeColor: color,
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });

                linea.setMap(yo.mapa);

                lista_poligonos.push(linea);
        });    
    }   
});
