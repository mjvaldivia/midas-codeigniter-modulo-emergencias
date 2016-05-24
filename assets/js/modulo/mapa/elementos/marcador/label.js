var MapaMarcadorLabel = Class({ extends : MapaMarcador}, {
    
    /**
     * 
     * @param {int} id
     * @param {string} label
     * @param {float} lon
     * @param {float} lat
     * @param {int} capa
     * @param {type} propiedades
     * @param {type} imagen
     * @returns {undefined}
     */
    posicionarMarcador : function(id, label, lon, lat, capa, propiedades, imagen){
        var yo = this;
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        var parametros = {
            position: posicion,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            informacion : propiedades,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: imagen
        };

        var marker = new  google.maps.Marker(parametros);  
        this.informacionMarcador(marker);
        
        var mapLabel = new MapLabel({
            text: label,
            position: posicion,
            map: yo.mapa,
            fontSize: 12,
            zIndex : 10000000000000000,
            strokeColor: "#FFFFFF",
            align: 'center'
        });

        marker.bindTo('map', mapLabel);
        marker.bindTo('position', mapLabel);
        
        lista_markers.push(marker);
        google.maps.event.trigger(yo.mapa, 'marcador_cargado');
    }
});


