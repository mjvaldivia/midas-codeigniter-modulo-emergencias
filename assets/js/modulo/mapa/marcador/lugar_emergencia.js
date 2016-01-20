var MapaMarcadorLugarEmergencia = Class({ extends : MapaMarcador}, {
    

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
    
    addMarcador : function(map){
        var yo = this;
        
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                ]
            },
            markerOptions: {icon: baseUrl + "assets/img/emergencia.png",
                            informacion: {"NOMBRE" : "LUGAR EMERGENCIA"}},
        });

        drawingManager.setMap(map);
        
        google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
            
            var latLon = marker.getPosition();
            
            console.log(latLon);
            
            bootbox.dialog({
                    message: "<div id=\"contenido-popup-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                    title: "<i class=\"fa fa-arrow-right\"></i> Ingrese la cantidad de metros del radio de la alarma",
                    buttons: {
                        guardar: {
                            label: " Guardar",
                            className: "btn-success fa fa-save",
                            callback: function() {
                                var salida = false;
                                var parametros = {"id" : yo.id_emergencia,
                                                  "metros" : $("#metros").val(),
                                                  "lat" : latLon.lat,
                                                  "lon" : latLon.lng};
                                
                                $.ajax({         
                                    dataType: "json",
                                    cache: false,
                                    async: false,
                                    data: parametros,
                                    type: "post",
                                    url: siteUrl + "mapa/ajax_guardar_lugar_emergencia", 
                                    error: function(xhr, textStatus, errorThrown){
                                        notificacionError("Ha ocurrido un problema", errorThrown);
                                    },
                                    success:function(data){
                                        if(data.correcto == true){
                                            procesaErrores(data.error);
                                            salida = true;
                                            
                                            var circulo = new MapaCirculoDibujar();
                                            circulo.seteaMapa(map);
                                            circulo.seteaIdentificador("LUGAR_EMERGENCIA");
                                            circulo.dibujarCirculo("lugar_emergencia", 
                                                                    {"TIPO" : "LUGAR EMERGENCIA",
                                                                     "NOMBRE" : ""}, 
                                                                    marker.getPosition(), 
                                                                    parametros.metros, 
                                                                    "red");
                                            
                                        } else {
                                            $("#form_error").removeClass("hidden");
                                            procesaErrores(data.error);
                                        }
                                    }
                                });
                                drawingManager.setMap(null);
                                return salida;
                            }
                        },
                        cerrar: {
                            label: " Cerrar ventana",
                            className: "btn-white fa fa-close",
                            callback: function() {}
                        }
                    }
            });
            
            var parametros = {};
            
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "mapa/popup_lugar_emergencia", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup-capas").html(data);
                }
            });
        });
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
            url: siteUrl + "mapa/ajax_marcador_lugar_emergencia", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    var posicion = new google.maps.LatLng(parseFloat(data.resultado.lat), parseFloat(data.resultado.lon));
                    
                    var circulo = new MapaCirculoDibujar();
                    circulo.seteaMapa(mapa);
                    circulo.seteaIdentificador("LUGAR_EMERGENCIA");
                    circulo.dibujarCirculo("lugar_emergencia", 
                                            {"TIPO" : "LUGAR EMERGENCIA",
                                             "NOMBRE" : data.resultado.nombre}, 
                                            posicion, 
                                            data.resultado.radio, 
                                            "red");
                    
                    
                    yo.posicionarMarcador(null, 
                                          data.resultado.lon, 
                                          data.resultado.lat, 
                                          {"TIPO" : "LUGAR EMERGENCIA",
                                           "NOMBRE" : data.resultado.nombre}, 
                                          data.resultado.zona, 
                                           baseUrl + "assets/img/emergencia.png");
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