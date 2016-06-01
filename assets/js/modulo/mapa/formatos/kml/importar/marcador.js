var MapaKmlImportarMarcador = Class({ extends : MapaMarcador}, {
    
    /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMarcador : function(id, capa, lon, lat, propiedades, informacion, imagen){
        var yo = this;
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        var marker = new google.maps.Marker({
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            position: posicion,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            tipo: "PUNTO",
            informacion : propiedades,
            informacion_html : informacion,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: imagen
        });  

        this.informacionMarcador(marker);
       
        var click = new MapaMarcadorEditar();
        click.seteaMarker(marker);
        click.clickListener();
       
        lista_markers.push(marker);
        google.maps.event.trigger(yo.mapa, 'marcador_cargado');
    }
});


