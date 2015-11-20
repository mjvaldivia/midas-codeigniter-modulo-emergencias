var HomeMapa = Class({

    markers     : [],
    geozone     : "19H",
    id_div_mapa : "",
    latitud     : "",
    longitud    : "",
    mapa        : null,
    infoWindow  : null,

    /**
     * Carga de dependencias
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

            var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(longitud_utm), 
                                                       parseFloat(latitud_utm), 
                                                       this.geozone);
            this.latitud = parseFloat(latLon[0]);
            this.longitud = parseFloat(latLon[1]);

    },
    
    /**
     * Inicia el mapa
     * @returns {void}
     */
    initialize : function(){

        var myLatlng = new google.maps.LatLng(this.latitud, this.longitud);

        var mapOptions = {
          zoom: 10,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);

        this.mapa = map;
    },
    
    /**
     * Selecciona un marcador, muestra informacion y centra el mapa
     * @param {int} id
     * @returns {void}
     */
    selectMarkerById : function(id){
        var yo = this;
        var result = $.grep(this.markers, function(e){ return e.id == id; });
        
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
    loadMarkers : function(){
        var yo = this;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "home/ajax_load_map_markers", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(markers){
          
                for( i = 0; i < markers.length; i++ ) {
                    
                    var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(markers[i]["longitud"]), 
                                                               parseFloat(markers[i]["latitud"]), 
                                                               yo.geozone);
                    
                    var position = new google.maps.LatLng(latLon[0], latLon[1]);

                    marker = new google.maps.Marker({
                        id: markers[i]["id"],
                        position: position,
                        icon: baseUrl + 'assets/img/spotlight-poi.png',
                        map: yo.mapa,
                        title: markers[i]["nombre"]
                    });
                    
                    yo.markers.push({"id" : markers[i]["id"], "marker" : marker})
                }
            }
        });
    }
});

