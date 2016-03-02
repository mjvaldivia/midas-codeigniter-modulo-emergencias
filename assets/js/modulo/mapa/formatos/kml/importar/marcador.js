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

        marker = new google.maps.Marker({
            position: posicion,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            informacion : propiedades,
            informacion_html : informacion,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: imagen
        });  

        this.informacionMarcador(marker);
       
        lista_markers.push(marker);
        google.maps.event.trigger(yo.mapa, 'marcador_cargado');
    },
    
    /**
     * Popup con informacion
     * @param {marker} marker
     * @returns {void}
     */
    informacionMarcador : function(marker){
        var yo = this;
          
        var infoWindow = new google.maps.InfoWindow({
            content: marker.informacion_html
        });  
          
          
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.open(yo.mapa, this);
        });
    }
});


