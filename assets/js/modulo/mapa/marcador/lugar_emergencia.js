var MapaMarcadorLugarEmergencia = Class({  
    
    mapa : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {

    },
    
    /**
     * Posiciona marcador en el mapa
     * @param {google.maps} mapa
     * @returns {void}
     */
    marcador : function(mapa){
        this.mapa = mapa;
        var yo = this;
        var id = $("#id").val();
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id,
            type: "post",
            url: siteUrl + "mapa/ajax_marcador_lugar_alarma", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    yo.posicionarMarcador(data.resultado.lon, 
                                          data.resultado.lat, 
                                          data.resultado.zona);
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
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
    posicionarMarcador : function(lon, lat, zona){
        var yo = this;
        
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(lon), 
                                                   parseFloat(lat), 
                                                   zona);


        var posicion = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        marker = new google.maps.Marker({
            position: posicion,
            draggable:true,
            map: yo.mapa,
            icon: baseUrl + 'assets/img/referencia.png'
        });  

        this.mapa.setCenter(posicion); 
    }

});


