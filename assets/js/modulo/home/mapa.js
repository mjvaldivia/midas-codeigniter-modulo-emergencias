var HomeMapa = Class({
    
    tipo_alarma : 1,
    tipo_emergencia : 2,
    
    /**
     * Zona por defecto
     */
    geozone     : "19H",
    
    /**
     * Id del elemento HTML que contiene el mapa
     */
    id_div_mapa : "",
    
    /**
     * Elemento google maps
     */
    mapa        : null,
    
    /**
     * Lista de marcadores en el mapa
     */
    markers_emergencia     : [],
    markers_alarma     : [],
    
    /**
     * Popup de informacion de marcador
     */
    infoWindow  : null,
    
    /**
     * Latitud y longitud del centro del mapa
     */
    latitud     : "",
    longitud    : "",

    /**
     * Carga de dependencias
     * @param {string} id elemento html
     * @returns void
     */
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
        this.infoWindow = new google.maps.InfoWindow();
    },
    
    /**
     * 
     * @param {string} latitud_utm
     * @param {string} longitud_utm
     * @returns {void}
     */
    setLatitudLongitudUTM : function(latitud_utm, longitud_utm){
            this.latitud = parseFloat(parseFloat(latitud_utm));
            this.longitud = parseFloat(parseFloat(longitud_utm));

    },
    
    /**
     * Inicia el mapa
     * @returns {void}
     */
    initialize : function(){

        if($("#" + this.id_div_mapa).length > 0){
            var myLatlng = new google.maps.LatLng(this.latitud, this.longitud);

            var mapOptions = {
              zoom: 8,
              center: myLatlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);

            this.mapa = map;
        }
    },
    
    /**
     * Selecciona un marcador, muestra informacion y centra el mapa
     * @param {int} id
     * @returns {void}
     */
    selectMarkerAlarmaById : function(id){
        var yo = this;
        var result = $.grep(this.markers_alarma, function(e){ return e.id == id; });
        
        if(result.length > 0){
            
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: "id=" + id,
                type: "post",
                url: siteUrl + "home/ajax_alarma_info", 
                error: function(xhr, textStatus, errorThrown){

                },
                success:function(html){
                    var marker = result[0]["marker"];
                    yo.mapa.setCenter(marker.getPosition());

                    yo.infoWindow.setContent(html);
                    yo.infoWindow.open(yo.mapa, marker);
                    
                }
            });
        }
    },
    
    /**
     * Selecciona un marcador, muestra informacion y centra el mapa
     * @param {int} id
     * @returns {void}
     */
    selectMarkerEmergenciaById : function(id){
        var yo = this;
        var result = $.grep(this.markers_emergencia, function(e){ return e.id == id; });
        
        if(result.length > 0){
            
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: "id=" + id,
                type: "post",
                url: siteUrl + "home/ajax_emergencia_info", 
                error: function(xhr, textStatus, errorThrown){

                },
                success:function(html){
                    var marker = result[0]["marker"];
                    yo.mapa.setCenter(marker.getPosition());

                    yo.infoWindow.setContent(html);
                    yo.infoWindow.open(yo.mapa, marker);
                    
                }
            });
        }
    },
    
    /**
     * Carga los marcadores
     */
    loadMarkers : function(fecha_inicio, fecha_termino){
        
        $.each(this.markers_emergencia, function(i, val){
            val.marker.setMap(null);
        });
        
        this.markers_emergencia = [];
        
        $.each(this.markers_alarma, function(i, val){
            val.marker.setMap(null);
        });
        
        this.markers_alarma = [];
        
        
        var parametros = {"date_start" : fecha_inicio.format("YYYY-MM-DD"),
                          "date_end"   : fecha_termino.format("YYYY-MM-DD")};
         
        var yo = this;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "home/ajax_load_map_markers", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(markers){
          
                for( i = 0; i < markers.length; i++ ) {
                                        
                    var position = new google.maps.LatLng(parseFloat(markers[i]["latitud"]), parseFloat(markers[i]["longitud"]));
                    
                    var imagen = baseUrl + 'assets/img/spotlight-poi.png';
                    if(markers[i]["tipo"] == yo.tipo_alarma){
                        imagen = baseUrl + 'assets/img/spotlight-poi-yellow.png';
                    }
                    
                    marker = new google.maps.Marker({
                        id: markers[i]["id"],
                        position: position,
                        icon: imagen,
                        map: yo.mapa,
                        title: markers[i]["nombre"]
                    });
                    
                    if(markers[i]["tipo"] == yo.tipo_alarma){
                        yo.markers_alarma.push({"id" : markers[i]["id"], "marker" : marker})
                    } else {
                        yo.markers_emergencia.push({"id" : markers[i]["id"], "marker" : marker})
                    }
                    
                    
                }
            }
        });
    }
});

