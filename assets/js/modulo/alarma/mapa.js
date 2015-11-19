var AlarmaMapa = Class({
    
    mapa : null,
    marker : null,
    geozone : null,
    id_div_mapa : "",
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa) {
        
        var yo = this;
        
        this.id_div_mapa = id_mapa;
        
        google.maps.event.addDomListener(window, 'load', this.initialize());
        google.maps.event.addDomListener(window, "resize", this.resizeMap());
        
        $(".mapa-coordenadas").keyup(function(){
            yo.setMarkerInputs();
        });
        
        $(".mapa-coordenadas").change(function(){
            yo.setMarkerInputs();
        });
    },
    
    /**
     * 
     * @returns {void}
     */
    cargaMapa : function(){
        //se dispara evento lazy
        google.maps.event.trigger(this.mapa, "resize");
    },
    
    /**
     * Setea el marcador
     */
    setMarker : function (posicion){
        var yo = this;       
        
        var marker = new google.maps.Marker({
            position: posicion,
            draggable:true,
            map: yo.mapa,
            icon: baseUrl + 'assets/img/referencia.png'
        });  
        
        google.maps.event.addListener(marker, 'dragend', function (){
            yo.setInputs(marker.getPosition());
        });
        
        this.marker = marker;
    },
    
    /**
     * Inicia el mapa
     * @returns {void}
     */
    initialize : function(){
        
        var yo = this;
        
        
        var latitud = "";
        var longitud = "";
        var geozone  = "19H"
        
        if($("#geozone").val()!=""){
            geozone = $("#geozone").val();
        }
        
        if($('#nueva_longitud').val() == "" || $('#nueva_latitud').val() == ""){
            //UTM de valparaiso
            longitud = 256029;
            latitud = 6340442;
        } else {
            latitud = $('#nueva_latitud').val();
            longitud = $('#nueva_longitud').val();
        }
        
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(longitud), 
                                                   parseFloat(latitud), 
                                                   geozone);


        var myLatlng = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        var mapOptions = {
          zoom: 15,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);


        var marker = new google.maps.Marker({
            position: myLatlng,
            draggable:true,
            map: map,
            icon: baseUrl + 'assets/img/referencia.png'
        });  
        
        google.maps.event.addListener(marker, 'dragend', function (){
            yo.setInputs(marker.getPosition());
        });
        
        this.marker = marker;
        this.mapa = map;
    },
    
    /**
     * Cambia posicion en los input
     * @param {type} posicion
     * @returns {void}
     */
    setInputs : function(posicion){
        var punto = GeoEncoder.decimalDegreeToUtm(parseFloat(posicion.lng()), parseFloat(posicion.lat()));
        //console.log(results[0].geometry.location.lat());
        $('#nueva_longitud').val(punto[0]);
        $('#nueva_latitud').val(punto[1]);
    },
    
    setMarkerInputs : function(){
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat($('#nueva_longitud').val()), parseFloat($('#nueva_latitud').val()), $("#geozone").val());
        console.log(latLon);
        this.marker.setPosition( new google.maps.LatLng( parseFloat(latLon[0]), parseFloat(latLon[1]) ) );
        this.mapa.panTo( new google.maps.LatLng( parseFloat(latLon[0]), parseFloat(latLon[1]) ) );
    },
    
    /**
     * 
     * @returns {void}
     */
    resizeMap : function(){
        var yo = this;
        if(typeof this.mapa =="undefined") return;
        setTimeout( function(){yo.resize();} , 400);
    },
    
    /**
     * Centra el mapa
     * @returns {void}
     */
    resize : function (){
        var center = this.mapa.getCenter();
        google.maps.event.trigger(this.mapa, "resize");
        this.mapa.setCenter(center); 
    }

});