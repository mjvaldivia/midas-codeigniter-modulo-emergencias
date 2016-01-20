var marker;

var regiones = {"Región de Tarapacá" : "19K",
               "Región de Antofagasta" : "19K",
               "III Región" : "19J",
               "Región de Atacama" : "19J",
               "Región de Coquimbo" : "19J",
               "Región de Valparaíso" : "19H",
               "VI Región" : "19H",
               "Región del libertador General Bernardo O'Higgins" : "19H",
               "VII Región" : "19H",
               "Región del Maule" : "19H",
               "Región del Bío Bío" : "18H",
               "IX Región" : "18H",
               "Región de la Araucania" : "18H",
               "X Región" : "18G",
               "Región de los lagos" : "18G",
               "XI Región" : "18G",
               "Región de Aysen" : "18G",
               "Región de Magallanes y de la Antártica Chilena" : "19K",
               "Región Metropolitana" : "19H",
               "Región de los Ríos" : "18H",
               "Región de Arica y Parinacota" : "19K"};

var AlarmaMapa = Class({
    
    mapa : null,
    marker : null,
    geozone : "19H",
    id_div_mapa : "",
    latitud : 6340442,
    longitud : 256029,
    callback : null,
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
       
    },
    
    inicio : function(){
        var yo = this;

        google.maps.event.addDomListener(window, 'load', this.initialize());
        google.maps.event.addDomListener(window, "resize", this.resizeMap());
        
        $(".mapa-coordenadas").keyup(function(){
            yo.setMarkerInputs();
        });
        
        $(".mapa-coordenadas").change(function(){
            yo.setMarkerInputs();
        });
        
        this.places();
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
        
        marker = new google.maps.Marker({
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
        console.log(yo.geozone);
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(yo.longitud), 
                                                   parseFloat(yo.latitud), 
                                                   yo.geozone);


        var myLatlng = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        var mapOptions = {
          zoom: 15,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);


        marker = new google.maps.Marker({
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
    
    places : function(){
        var yo = this;
        
        $("#nombre_lugar").livequery(function(){
            ac = new google.maps.places.Autocomplete((document.getElementById('nombre_lugar')), {
                componentRestrictions: {country: 'cl'}
            });

            ac.addListener('place_changed', function () {
                var place = ac.getPlace();
                if (place.length === 0) {
                    return;
                }
                var index = place.address_components.length - 2;
                var region = place.address_components[index].long_name;  

                yo.geozone = regiones[region];
                console.log(yo.geozone);
                
                var punto = GeoEncoder.decimalDegreeToUtm(parseFloat(place.geometry.location.lng()), parseFloat(place.geometry.location.lat()));
                $('#longitud').val(punto[0]);
                $('#latitud').val(punto[1]);
                $('.mapa-coordenadas').trigger("change");
            });
        });
        
          
    },
    
    /**
     * Cambia posicion en los input
     * @param {type} posicion
     * @returns {void}
     */
    setInputs : function(posicion){
        var punto = GeoEncoder.decimalDegreeToUtm(parseFloat(posicion.lng()), parseFloat(posicion.lat()));
        //console.log(results[0].geometry.location.lat());
        $('#longitud').val(punto[0]);
        $('#latitud').val(punto[1]);
    },
    
    setMarkerInputs : function(){
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat($('#longitud').val()), parseFloat($('#latitud').val()), this.geozone);
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
        
       // this.callback(this.mapa);
        
    }
    
    

});