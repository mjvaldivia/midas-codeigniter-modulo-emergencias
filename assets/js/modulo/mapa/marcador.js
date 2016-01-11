var lista_markers = [];

var MapaMarcador = Class({
    
    mapa : null,
    
    
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    removerMarcadores : function(atributo, valor){
        
        var arr = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });
        
        $.each(arr, function(i, marcador){
           marcador.setMap(null); 
        });

    },
    
     /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMarcador : function(capa, lon, lat, zona, imagen){
        var yo = this;
        
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(lon), 
                                                   parseFloat(lat), 
                                                   zona);


        var posicion = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        marker = new google.maps.Marker({
            position: posicion,
            capa: capa,
            draggable:true,
            map: yo.mapa,
            icon: imagen
        });  

        lista_markers.push(marker);
        this.mapa.setCenter(posicion); 
    }
});


