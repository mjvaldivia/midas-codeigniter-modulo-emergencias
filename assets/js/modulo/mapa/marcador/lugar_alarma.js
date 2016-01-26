var MapaMarcadorLugarAlarma = Class({ extends : MapaMarcador}, {
    
    draggable : true,
    id_emergencia : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {

    },
    
        /**
     * 
     * @param {int} id
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    removerAlarma : function(){
        this.removerMarcadores("identificador","lugar_alarma");
    },
        
    /**
     * Posiciona marcador en el mapa
     * @param {google.maps} mapa
     * @returns {void}
     */
    marcador : function(mapa){
        this.mapa = mapa;
        var yo = this;
       
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_marcador_lugar_alarma", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    yo.posicionarMarcador("lugar_alarma",
                                          null, 
                                          data.resultado.lon, 
                                          data.resultado.lat, 
                                          {"TIPO" : "LUGAR ALARMA",
                                           "NOMBRE" : data.resultado.nombre}, 
                                          data.resultado.zona, 
                                          baseUrl + 'assets/img/referencia.png');

                    yo.centrarMapa(mapa, data.resultado.lon, data.resultado.lat, data.resultado.zona);


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


