var tipo_marcador_lugar_emergencia = 1;
var tipo_marcador_lugar_alarma     = 2;
var tipo_marcador_capa             = 3;
var tipo_marcador_otros            = 4;

var Visor = Class({    
    
    mapa : null,
    capa : null,
    id_emergencia : null,
    geozone : "19H",
    id_div_mapa : "",
    latitud : 6340442,
    longitud : 256029,
    callback : null,
    
    on_ready_functions : {},
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa,geozone) {
        this.id_div_mapa = id_mapa;
        if(geozone !== undefined)
            this.geozone = geozone;
    },
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    /**
     * Añade funciones a ejecutar cuando el mapa esta cargado
     * @param {string} index identificador de la funcion para debug
     * @param {function} funcion funcion a ejecutar
     * @returns {void}
     */
    addOnReadyFunction : function(index, funcion, parametros){
        this.on_ready_functions[index] = {"funcion" : funcion,
                                          "parametros" : parametros};
    },
    
    /**
     * Tamaño del mapa
     * @param {int} height
     * @returns {undefined}
     */
    seteaHeight : function(height){
        $("#" + this.id_div_mapa).css("height", height);
    },
    
    /**
     * Eventos para inicializar mapa
     * @returns {void}
     */
    bindMapa : function(){
        google.maps.event.addDomListener(window, 'load', this.initialize());
        google.maps.event.addDomListener(window, "resize", this.resizeMap());
    },


    setCenter : function(lat,lon){
        this.latitud = lat;
        this.longitud = lon;
    },

    /**
     * Retorna mapa
     */
    getMapa : function(){
        return this.mapa;
    },
 
    /**
     * Inicia el mapa
     * @returns {void}
     */
    initialize : function(){
        
        var yo = this;
        var latLon = GeoEncoder.utmToDecimalDegree(parseFloat(yo.longitud), 
                                                   parseFloat(yo.latitud), 
                                                   yo.geozone);

        if(!(latLon[0] >= -90 && latLon[0] <= 90)){
           latLon[0] = yo.latitud;
        }
       
        if(!(latLon[1] >= -90 && latLon[1] <= 90)){
           latLon[1] = yo.longitud;
        }

        var myLatlng = new google.maps.LatLng(parseFloat(latLon[0]), parseFloat(latLon[1]));

        var mapOptions = {
          zoom: 10,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(this.id_div_mapa), mapOptions);

        google.maps.event.addListenerOnce(map, 'idle', function(){
            console.log("Mapa cargado totalmente");
            console.log("Iniciando carga de elementos");
            $.each(yo.on_ready_functions, function(i, funcion){
                console.log("Carga de " + i);
                funcion.funcion(map, funcion.parametros);
            });
        });

        
        
        map.addListener('click', function(event) {
            console.log(event);
        });

        this.mapa = map;
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


