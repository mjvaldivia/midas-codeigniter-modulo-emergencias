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
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
    },
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    emergencia : function(id){
        this.id_emergencia = id;
    },
    
    /**
     * Añade funciones a ejecutar cuando el mapa esta cargado
     * @param {string} index identificador de la funcion para debug
     * @param {function} funcion funcion a ejecutar
     * @returns {void}
     */
    addOnReadyFunction : function(index, funcion){
        this.on_ready_functions[index] = funcion;
    },
    
    /**
     * Añade front-end de capa
     */
    addCapa : function(capa){
        this.capa = capa;
    },
    
    /**
     * Eventos para inicializar mapa
     * @returns {void}
     */
    bindMapa : function(){
        
        var height = $(window).height();
        $("#mapa").css("height", height - 65);
        
        google.maps.event.addDomListener(window, 'load', this.initialize());
        google.maps.event.addDomListener(window, "resize", this.resizeMap());
    },

    /**
     * Retorna mapa
     */
    getMapa : function(){
        return this.mapa;
    },
    
    
    
    
    /**
     * Guardar
     * @returns {void}
     */
    guardar : function(){
        
        var custom = new MapaElementoCustom();
        
        var yo = this;
        var parametros = {"capas" : this.capa.retornaIdCapas(),
                          "elementos" : custom.listCustomElements(),
                          "id" : this.id_emergencia};
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/save", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    notificacionCorrecto("Guardado","Se ha guardado correctamente la configuración del mapa");
                    var elemento_custom = new MapaElementoCustom();
                    elemento_custom.emergencia(yo.id_emergencia);
                    elemento_custom.removeCustomElements();
                    elemento_custom.loadCustomElements(yo.mapa);
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        }); 
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
                funcion(map);
            });
            
            yo.controlSave(map);
            yo.controlEditar(map);
            yo.controlCapas(map);
            yo.controlInstalaciones(map);
        });

        
        
        map.addListener('click', function(event) {
            console.log(event);
        });

        this.mapa = map;
    },
    
    /**
     * Boton editar
     * @param {googleMaps} map
     * @returns {void}
     */
    controlEditar : function (map) {
        var yo = this;
        var buttonOptions = {
        		gmap: map,
        		name: '<i class=\"fa fa-bullhorn\"></i> Ubicación emergencia',
        		position: google.maps.ControlPosition.TOP_RIGHT,
        		action: function(){
        		    
        		}
        }
        var button1 = new buttonControl(buttonOptions, "button-map");    
    },
        
    /**
     * Carga el popup con las capas
     * disponibles
     * @returns {void}
     */
    popupCapas : function(){
        var yo = this;
        if(this.capa != null){
            
            bootbox.dialog({
                    message: "<div id=\"contenido-popup-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Capas disponibles",
                    buttons: {
                        cerrar: {
                            label: " Cerrar ventana",
                            className: "btn-white fa fa-close",
                            callback: function() {}
                        }
                    }
            });
            
           
            
            var parametros = {"capas" : this.capa.retornaIdCapas(),
                              "id" : this.id_emergencia};
            
            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "mapa/popup_capas", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup-capas").html(data);
                    
                    $(".seleccion-capa").click(function(){
                        if($(this).is(":checked")){
                            yo.capa.addCapa($(this).val());
                        } else {
                            yo.capa.removeCapa($(this).val());
                        }
                    });
                }
            }); 
            
        } else {
            notificacionError("Ha ocurrido un problema", "No se encontro el front-end de capas");
        }
    },
    
    /**
     * Boton para seleccionar capas
     * @param {google_map} map
     * @returns {void}
     */
    controlCapas : function (map) {
        var yo = this;
        var buttonOptions = {
        		gmap: map,
        		name: '<i class=\"fa fa-clone\"></i> Capas',
        		position: google.maps.ControlPosition.TOP_RIGHT,
        		action: function(){
        			yo.popupCapas(); 
        		}
        }
        var button1 = new buttonControl(buttonOptions, "button-map");
    },
    
    /**
     * Boton para guardar
     * @param {type} map
     * @returns {undefined}
     */
    controlSave : function (map) {
        var yo = this;
        var buttonOptions = {
        		gmap: map,
        		name: '<i class=\"fa fa-save\"></i> Guardar',
        		position: google.maps.ControlPosition.TOP_RIGHT,
        		action: function(){
        			yo.guardar();
        		}
        }
        var button1 = new buttonControl(buttonOptions, "button-map button-success");
    },
    
    /**
     * Boton para mostrar instalaciones
     * @param {type} map
     * @returns {undefined}
     */
    controlInstalaciones : function (map) {
        var yo = this;
        var buttonOptions = {
        		gmap: map,
        		name: '<i class=\"fa fa-building\"></i> Instalaciones',
        		position: google.maps.ControlPosition.TOP_RIGHT,
        		action: function(){
        			
        		}
        }
        var button1 = new buttonControl(buttonOptions, "button-map");
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


