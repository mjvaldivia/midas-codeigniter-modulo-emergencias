var MapaPoligonoMulti = Class({ extends : MapaPoligono}, {
         
    /**
     * Dubuja poligono en el mapa
     * @param {mixed} capa si es null el poligono no pertenece a capa
     * @param {object} geometry
     * @param {string} zona
     * @param {string} color
     * @returns {void}
     */
    dibujarPoligono : function(id, nombre, capa, geometry, propiedades, zona, color){

        var yo = this;

        $.each(geometry, function(i, multipoligono){
           $.each(multipoligono, function(j, coordenadas){
               
                var coord = [];
                $.each(coordenadas, function(k, valores){
                    coord.push(new google.maps.LatLng(parseFloat(valores[1]), parseFloat(valores[0])));
                });
           
                var poligono = new google.maps.Polygon({
                     clave_primaria : yo.clave_primaria,
                     relacion: yo.relacion,
                     paths: coord,
                     identificador: id,
                     nombre : nombre,
                     clave : "poligono_" + id,
                     capa: capa,
                     custom: yo.custom,
                     editable: yo.editable,
                     informacion: propiedades,
                     tipo: "POLIGONO",
                     strokeColor: '#000',
                     strokeOpacity: 0.8,
                     strokeWeight: 1,
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
