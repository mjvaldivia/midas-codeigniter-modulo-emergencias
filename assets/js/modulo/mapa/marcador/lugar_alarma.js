var MapaMarcadorLugarAlarma = Class({ extends : MapaMarcador}, {
    

    draggable : true,
    
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
                    yo.posicionarMarcador(null, 
                                          data.resultado.lon, 
                                          data.resultado.lat, 
                                          {"TIPO" : "LUGAR ALARMA",
                                           "NOMBRE" : data.resultado.nombre}, 
                                          data.resultado.zona, 
                                          baseUrl + 'assets/img/referencia.png');
                    //yo.centrarMapa(mapa, data.resultado.lon, data.resultado.lat, data.resultado.zona);

                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        }); 
    },
    
    centrarMapa : function (mapa, lon, lat, zona){
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(lon), 
                                                   parseFloat(lat), 
                                                   zona);
        var posicion = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));
        mapa.setCenter(posicion);
    }
    
});


