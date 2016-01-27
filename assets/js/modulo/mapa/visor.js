var marker_search = null;


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
          scaleControl: true,
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
        
        this.searchBox(map);
        this.contextMenu(map);
        
        map.addListener('click', function(event) {
            console.log(event);
        });

        this.mapa = map;
    },
    
    /**
     * Caja de busqueda
     * @param {googleMap} map
     * @returns {void}
     */
    searchBox : function(map){
        var input = document.getElementById('pac-input');
        
        ac = new google.maps.places.Autocomplete(input, {
            componentRestrictions: {country: 'cl'}
        });
        
        ac.addListener('place_changed', function () {
            var place = ac.getPlace();
            if (place.length === 0) {
                return;
            }
            
            map.setCenter(place.geometry.location);
            
            //se borra marcador de busqueda si ya existia
            if(!(marker_search == null)){
                marker_search.setMap(null);
                marker_search = null;
            }
            
            //se agrega marcador
            var marker = new google.maps.Marker({
                position: place.geometry.location,
                icon: {
                  path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                  scale: 3
                },
                draggable: true,
                map: map
            });
            
            marker.setAnimation(google.maps.Animation.BOUNCE);
            
            marker_search = marker;
            
            map.addListener('center_changed', function(event) {
                marker_search.setMap(null);
                marker_search = null;
                google.maps.event.clearInstanceListeners(this);
            });
  
        });
        
        
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('busqueda'));
    },
    
    /**
     * 
     * @param {googleMap} map
     * @returns {void}
     */
    contextMenu : function(map){
      /*
      var contextMenuOptions={}; 
      contextMenuOptions.classNames={menu:'context_menu', menuSeparator:'context_menu_separator'}; 
      
      var menuItems=[]; 
      menuItems.push({className:'context_menu_item', eventName:'zoom_in_click', label:'Zoom in'});
      menuItems.push({className:'context_menu_item', eventName:'zoom_out_click', label:'Zoom out'}); 
      
      menuItems.push({}); 
      menuItems.push({className:'context_menu_item', eventName:'center_map_click', label:'Center map here'}); 
      contextMenuOptions.menuItems=menuItems; 
      
      var contextMenu=new ContextMenu(map, contextMenuOptions); 
      
      google.maps.event.addListener(map, 'rightclick', function(mouseEvent){ 
          contextMenu.show(mouseEvent.latLng); 
      });  */
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


