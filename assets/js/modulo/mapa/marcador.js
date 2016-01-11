var lista_markers = [];

var MapaMarcador = Class({
    
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
     * Quita marcadores de acuerdo al parametro que se quiere buscar
     * @param {string} atributo parametro a buscar
     * @param {int} valor valor del parametro a buscar
     * @returns {void}
     */
    removerMarcadores : function(atributo, valor){
        
        var arr = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });
        
        //se quita marcador del mapa
        $.each(arr, function(i, marcador){
           marcador.setMap(null); 
        });
        
        //se borran los marcadores de la lista
        lista_markers = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });

    },
    
     /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMarcador : function(capa, lon, lat, propiedades, zona, imagen){
        var yo = this;
        
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(lon), 
                                                   parseFloat(lat), 
                                                   zona);


        var posicion = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        marker = new google.maps.Marker({
            position: posicion,
            capa: capa,
            informacion : propiedades,
            draggable:true,
            map: yo.mapa,
            icon: imagen
        });  

        this.informacionMarcador(marker);

        lista_markers.push(marker);

    },
    
    informacionMarcador : function(marker){
        var yo = this;
        var markerContent = '<div class="info_content">';
        var propiedades = marker.informacion;
        
        
        $.each(propiedades, function(nombre, valor){
            markerContent += '<div class="col-xs-12"><strong>' + nombre +':</strong> ' + valor + '</div>';
        });
        
        markerContent += '</div>';
          
        var infoWindow = new google.maps.InfoWindow({
            content: markerContent
        });  
          
          
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.open(yo.mapa, this);
        });
    }
    
    
});


