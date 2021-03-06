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
                coord.push({"lat" : parseFloat(coordenadas[0]), "lng" : parseFloat(coordenadas[1])});
            });

            var linea = new google.maps.Polyline({
                clave_primaria : yo.clave_primaria,
                relacion: yo.relacion,
                id : id,
                path: coord,
                identificador: id,
                clave : "linea_" + id,
                capa: capa,
                informacion: propiedades,
                tipo: "LINEA",
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
