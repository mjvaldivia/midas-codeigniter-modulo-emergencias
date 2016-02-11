var Visor = Class({    
    
    mapa : null,
    capa : null,
    id_emergencia : null,
    geozone : "19H",
    id_div_mapa : "",
    latitud : "-36.82013519999999",
    longitud : "-73.0443904",
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
    },

    /**
     * 
     * @param {type} lat
     * @param {type} lon
     * @returns {undefined}
     */
    setCenter : function(lat,lon){
        this.latitud = lat;
        this.longitud = lon;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    centrarLugarEmergencia : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_posicion_lugar_emergencia", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    yo.centrarMapa(data.resultado.lat, data.resultado.lon);
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        }); 
    },
    
    /**
     * 
     * @param {type} lat
     * @param {type} lon
     * @returns {undefined}
     */
    centrarMapa : function (lat, lon){
        this.latitud = lat;
        this.longitud = lon;
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));
        this.mapa.setCenter(posicion);
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
      
        var myLatlng = new google.maps.LatLng(parseFloat(yo.latitud), parseFloat(yo.longitud));

        var mapOptions = {
          zoom: 14,
          scaleControl: true,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(yo.id_div_mapa), mapOptions);

        google.maps.event.addListenerOnce(map, 'idle', function(){
            console.log("Mapa cargado totalmente");
            console.log("Iniciando carga de elementos");
            $.each(yo.on_ready_functions, function(i, funcion){
                console.log("Carga de " + i);
                funcion.funcion(map, funcion.parametros);
            });
        });
        
        google.maps.event.addListener(map, 'click', function(e){
            console.log(e);
        });

        yo.contextMenu(map);

        yo.mapa = map;

        google.maps.event.addDomListener(window, "resize", yo.resizeMap());
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


