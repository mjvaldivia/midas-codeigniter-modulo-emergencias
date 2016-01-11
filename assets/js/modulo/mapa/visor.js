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
          zoom: 13,
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
        });

        this.controlEditar(map);
        this.controlCapas(map);
        this.controlInstalaciones(map);
        this.controlSave(map);
        
        map.addListener('click', function(event) {
            console.log(event);
        });
        
        
        
        
        this.mapa = map;
    },
    
    controlEditar : function (map) {
        var controlDiv = document.createElement('div');
        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '3px';
        controlUI.style.marginRight = '50px';
        controlUI.style.marginTop = '10px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Agregar elementos al mapa';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '11px';
        controlText.style.lineHeight = '28px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = '<i class=\"fa fa-edit\"></i> Editar';
        controlUI.appendChild(controlText);

        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

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
     * Boton para capas
     * @param {google_map} map
     * @returns {void}
     */
    controlCapas : function (map) {
        var yo = this;
        var controlDiv = document.createElement('div');
        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '3px';
        controlUI.style.marginRight = '5px';
        controlUI.style.marginTop = '10px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Muestra capas';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '11px';
        controlText.style.lineHeight = '28px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = '<i class=\"fa fa-clone\"></i> Capas';
        controlUI.appendChild(controlText);

        controlUI.addEventListener('click', function() {
            yo.popupCapas();
        });


        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

    },
    
    controlSave : function (map) {
        var controlDiv = document.createElement('div');
        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#5cb85c';
        
        controlUI.style.border = '2px solid #4cae4c';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '3px';
        controlUI.style.marginRight = '5px';
        controlUI.style.marginTop = '10px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Guarda los cambios en el mapa';
        controlDiv.appendChild(controlUI);

  
        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = '#FFF';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '11px';
        controlText.style.lineHeight = '28px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = '<i class=\"fa fa-save\"></i> Guardar';
        controlUI.appendChild(controlText);

        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

    },
    
    controlInstalaciones : function (map) {
        var controlDiv = document.createElement('div');
        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '3px';
        controlUI.style.marginRight = '5px';
        controlUI.style.marginTop = '10px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Muestra instalaciones para cargar';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '11px';
        controlText.style.lineHeight = '28px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = '<i class=\"fa fa-building\"></i> Instalaciones';
        controlUI.appendChild(controlText);

        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

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


