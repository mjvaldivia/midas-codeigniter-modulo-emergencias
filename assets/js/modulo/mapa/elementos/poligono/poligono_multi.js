var MapaPoligonoMulti = Class({ extends : MapaPoligono}, {
         
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

        $.each(geometry, function(i, multipoligono){
           $.each(multipoligono, function(j, coordenadas){
               
                var coord = [];
                $.each(coordenadas, function(k, valores){
                    coord.push(new google.maps.LatLng(parseFloat(valores[1]), parseFloat(valores[0])));
                });
           
                var poligono = new google.maps.Polygon({
                     paths: coord,
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
                 poligono.setMap(yo.mapa);

                 //se agrega evento de click para ver instalaciones
                 //dentro de poligono
                 yo.addClickListener(poligono, yo.mapa);

                 lista_poligonos.push(poligono);
            });
        });    
    }   
});
