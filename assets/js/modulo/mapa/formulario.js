/**
 * Clase para agregar mapa a formulario.
 * 
 * @requires 
 * 
 * @type MapaFormulario
 */
var MapaFormulario = Class({
    
    /**
     * Nombre del input de busqueda de direccion
     */
    places_input : null,
    
    /**
     * Icono utilizado para el marcador
     */
    icon : "assets/img/referencia.png",
    
    /**
     * googleMaps
     */
    mapa : null,
    
    /**
     * Marcador en el mapa
     */
    marker : null,

    /**
     * Identificador del contenedor html del mapa
     */
    id_div_mapa : "",
    
    /**
     * Latitud por defecto
     */
    latitud : -33.04864,
    
    /**
     * Longitud por defecto
     */
    longitud : -71.613353,
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
    },
    
    /**
     * Setea el icono para el marcador
     * @param {string} icono
     * @returns {undefined}
     */
    seteaIcono : function (icono){
        this.icon = icono;
    },
    
    /**
     * Setea el id del input de busqueda de direcciones
     * @param {string} place
     * @returns {void}
     */
    seteaPlaceInput : function(place){
        this.places_input = place;
    },
    
    /**
     * Setea el valor de la latitud del centro del mapa
     * @param {string} latitud
     * @returns {undefined}
     */
    seteaLatitud : function(latitud){
        if(latitud != ""){
            this.latitud = latitud;
        }
    },
    
    /**
     * Setea el valor de la longitud del centro del mapa
     * @param {string} longitud
     * @returns {undefined}
     */
    seteaLongitud : function(longitud){
        if(longitud != ""){
            this.longitud = longitud;
        }
    },
    
    /**
     * 
     * @returns {undefined}
     */
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
            icon: baseUrl + yo.icon
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

        var myLatlng = new google.maps.LatLng(parseFloat(yo.latitud),parseFloat(yo.longitud));

        var mapOptions = {
          zoom: 4,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.HYBRID
        };

        map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);


        
        this.mapa = map;
    },
    
    /**
     * Configuracion de busqueda de direcciones
     * @returns {void}
     */
    places : function(){
        var yo = this;
        if(yo.places_input != null && $("#" + yo.places_input).length > 0){
            $("#" + yo.places_input).livequery(function(){
                ac = new google.maps.places.Autocomplete((document.getElementById(yo.places_input)), {
                    componentRestrictions: {country: 'cl'}
                });

                ac.addListener('place_changed', function () {
                    var place = ac.getPlace();
                    
                    if (place && place.length === 0) {
                        return;
                    }
                    
                    var index = place.address_components.length - 2;
                    var region = place.address_components[index].long_name;  

                    $('#longitud').val(parseFloat(place.geometry.location.lng()));
                    $('#latitud').val(parseFloat(place.geometry.location.lat()));
                    $('.mapa-coordenadas').trigger("change");

                });
            });
        }
          
    },
    
    /**
     * Cambia posicion en los input
     * @param {type} posicion
     * @returns {void}
     */
    setInputs : function(posicion){
        $('#longitud').val(parseFloat(posicion.lng()));
        $('#latitud').val(parseFloat(posicion.lat()));
    },
    
    /**
     * Actualiza posicion de marcador y mapa de acuerdo
     * a los input de latitud y longitud
     * @returns {undefined}
     */
    setMarkerInputs : function(){
        if($('#latitud').val() != "" && $('#longitud').val() != ""){
            var yo = this;

            if(this.marker != null){
                this.marker.setMap(null);
                this.marker = null;
            }

            var marker = new google.maps.Marker({
                draggable:true,
                map: yo.mapa,
                icon: baseUrl + yo.icon
            });  

            google.maps.event.addListener(marker, 'dragend', function (){
                yo.setInputs(marker.getPosition());
            });

            this.marker = marker;


            this.marker.setPosition( new google.maps.LatLng( parseFloat($('#latitud').val()), parseFloat($('#longitud').val())) );
            this.mapa.setZoom(18);
            this.mapa.panTo( new google.maps.LatLng(parseFloat($('#latitud').val()), parseFloat($('#longitud').val())) );
        }
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