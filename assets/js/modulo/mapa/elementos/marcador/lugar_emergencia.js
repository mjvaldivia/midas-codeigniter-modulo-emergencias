var MapaMarcadorLugarEmergencia = Class({ extends : MapaMarcador}, {
    
    mapa : null,

    draggable : true,
    
    /**
     * identificador de la emergencia
     */
    id_emergencia : null,
    
    /**
     * 
     */
    drawing_manager : null,
    
    /**
     * id unico generado
     */
    unique_id : null,
    
    /**
     * Si es o no un elemento que se debe guardar
     */
    custom : true,
    
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {

    },
    
    /**
     * 
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    setearMapa : function(mapa) {
        this.mapa = mapa;
    },
    
    /**
     * 
     * @param {boolean} custom
     * @returns {undefined}
     */
    seteaCustom : function(custom){
        this.custom = custom;
    },
    
    /**
     * Dibuja circulo con la zona de la emergencia
     * @param {int} id
     * @param {string} lon
     * @param {string} lat
     * @param {int} radio
     * @param {object} propiedades
     * @returns {undefined}
     */
    dibujarCirculo : function(id, lon, lat, radio, propiedades, color){
        if(radio > 0){
            var yo = this;

            var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));
            
            var editor = new MapaEditor();
            var identificador = editor.uniqID(20);
            
            var circulo = new MapaCirculo();
            circulo.seteaTipo("CIRCULO LUGAR EMERGENCIA");
            circulo.seteaMapa(yo.mapa);
            circulo.seteaCustom(yo.custom);
            circulo.seteaUniqueId(yo.unique_id);
            circulo.seteaEditable(false);
            circulo.seteaIdentificador(identificador);
            circulo.dibujarCirculo(id, 
                                   propiedades, 
                                   posicion, 
                                   radio, 
                                   color);
        }
    },
    
    /**
     * Posiciona el marcador de emergencia
     * @param {int} id
     * @param {string} lon
     * @param {string} lat
     * @param {int} radio
     * @param {object} propiedades
     * @param {string} imagen
     * @returns {undefined}
     */
    posicionarMarcador : function(id, lon, lat, zonas, propiedades, imagen){
        var yo = this;
        this.quitarLugarAlarma();
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        var draggable = true;
        if(zonas.lenght > 0){
            draggable = false;
        }
        
        var editor = new MapaEditor();
        this.unique_id = editor.uniqID(20);

        var marker = new google.maps.Marker({
            id : id,
            tipo : "PUNTO LUGAR EMERGENCIA",
            position: posicion,
            identificador: id,
            clave : yo.unique_id,
            capa: null,
            custom: yo.custom,
            informacion : propiedades,
            draggable: draggable,
            map: yo.mapa,
            icon: imagen
        });  

        
        this.informacionMarcador(marker);
        
        $.each(zonas, function(i, datos){
            yo.dibujarCirculo(id, lon, lat, datos.radio, datos.propiedades, datos.color);
        });

        var dragend = new MapaMarcadorMoveListener();
        dragend.addMoveListener(marker, yo.mapa);
        
        this.listenerRightClick(marker);
        
        lista_markers.push(marker);
    },
    
    /**
     * Menu al hacer click con boton derecho
     * @param {google.maps.Marker} marker
     * @returns {void}
     */
    listenerRightClick : function(marker){
        
        google.maps.event.clearListeners(marker, 'rightclick');
        
        var yo = this;

        var contextMenuOptions={}; 
        
        contextMenuOptions.classNames = {
            menu:'context_menu', 
            menuSeparator:'context_menu_separator'
        }; 

        var menuItems=[]; 
       
        menuItems.push({
            className:'context_menu_item', 
            eventName:'agregar_zona_lugar_emergencia', 
            label:'<i class=\"fa fa-plus\"></i> Agregar zona '
        });
        
        menuItems.push({});
        
        var zonas = jQuery.grep(lista_poligonos, function( a ) {
            if(a["clave"] == marker.clave){
                return true;
            }
        });
        
        $.each(zonas, function(i, circulo){
            menuItems.push({
                className:'context_menu_item', 
                eventName:'eliminar_zona__' + circulo.identificador, 
                label:'<div class=\"row\"><div class=\"col-xs-9\"><i class=\"fa fa-remove\"></i> Eliminar zona </div><div class=\"col-xs-3\"><div class="color-capa-preview" style="background-color:' + circulo.fillColor + '"></div></div></div>'
            });
        });
        
        
        menuItems.push({
            className:'context_menu_item', 
            eventName:'eliminar_lugar_emergencia_click', 
            label:'<i class=\"fa fa-remove\"></i> Eliminar lugar de la emergencia'
        });
         
        contextMenuOptions.menuItems = menuItems; 

        var contextMenu = new ContextMenu(
            this.mapa , 
            contextMenuOptions
        ); 

        google.maps.event.addListener(marker, 'rightclick', function(mouseEvent){ 
            contextMenu.show(mouseEvent.latLng); 
        }); 
        
        
        google.maps.event.addListener(contextMenu, 'menu_item_selected', function(latLng, eventName){
            switch(eventName){
                case 'agregar_zona_lugar_emergencia':
                    contextMenu.hide();
                    yo.popupMetros(yo.mapa, marker, contextMenu);
                break;
                case 'eliminar_lugar_emergencia_click':
                    contextMenu.hide();
                    delete contextMenu;
                    var elemento = new MapaElementos();
                    elemento.removeOneCustomElements("clave", marker.clave);
                break;
                default:
                    var separar = eventName.split("__");
                   
                    var eliminar = jQuery.grep(lista_poligonos, function( a ) {
                        if(a["identificador"] == separar[1]){
                            return true;
                        }
                    });
                    
                    $.each(eliminar, function(i, elemento){
                       elemento.setMap(null); 
                    });
                    
                    lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
                        if(a["identificador"] != separar[1]){
                            return true;
                        }
                    });
                    contextMenu.hide();
                    delete contextMenu;
                    
                    yo.listenerRightClick(marker);
                break;
            }
	});
        
    },
    
    /**
     * Inicia dibujador de marcador
     * @param {googleMap} map
     * @returns {undefined}
     */
    drawingManager : function(){
        var yo = this;
        var editor = new MapaEditor();
        this.unique_id = editor.uniqID(20);
        
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                ]
            },
            markerOptions: {
                            id : null,
                            tipo : "PUNTO LUGAR EMERGENCIA",
                            identificador: null,
                            draggable: true,
                            clave : yo.unique_id,
                            custom : yo.custom,
                            icon: baseUrl + "assets/img/emergencia.png",
                            informacion: {"TIPO" : "LUGAR EMERGENCIA",
                                          "NOMBRE" : ""}
            },
        });

        drawingManager.setMap(this.mapa);
        
        this.drawing_manager = drawingManager;
    },
    
    /**
     * Quita la alarma
     * @returns {undefined}
     */
    quitarLugarAlarma : function(){
        var alarma = new MapaMarcadorLugarAlarma();
        alarma.removerAlarma();
    },
    
    /**
     * 
     * @param {int} id
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    /**
     * Valida y dibuja circulo 
     * @param {marker} marker
     * @returns {Boolean}
     */
    addCirculo : function(marker){
        var yo = this;
        var salida = false;
        var latLon = marker.getPosition();  
        var parametros = {"id" : yo.id_emergencia,
                          "metros" : $("#metros").val(),
                          "color" : $("#color").val(),
                          "lat" : latLon.lat,
                          "lon" : latLon.lng};
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/ajax_valida_lugar_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    salida = true;
                    
                    var posicion = marker.getPosition();
                    
                    yo.dibujarCirculo(
                        null, 
                        posicion.lng(), 
                        posicion.lat(), 
                        parametros.metros, 
                        {"TIPO" : "LUGAR EMERGENCIA",
                         "NOMBRE" : "ZONA EMERGENCIA"},
                        $("#color").val()
                    );
                    
                } else {
                    $("#form_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        });
        
        if(this.drawing_manager != null){
            this.drawing_manager.setMap(null);
        }
        return salida;  
    },
    
    /**
     * Popup para ingresar metros
     * @param {marker} marker
     * @returns {undefined}
     */
    popupMetros : function(mapa, marker, contextMenu){
        this.mapa = mapa;
        var yo = this;
        var latLon = marker.getPosition();    
        
        bootbox.dialog({
            message: "<div id=\"contenido-popup-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
            title: "<i class=\"fa fa-arrow-right\"></i> Ingrese la cantidad de metros del radio de la alarma",
            buttons: {
                guardar: {
                    label: " Guardar",
                    className: "btn-success fa fa-save",
                    callback: function() {
                        if(contextMenu != null){
                            contextMenu.hide();
                        }

                        var salida = yo.addCirculo(marker);
                        yo.listenerRightClick(marker);
                        return salida;
                    }
                },
                cerrar: {
                    label: " Cerrar ventana",
                    className: "btn-white fa fa-close",
                    callback: function() {
                        yo.listenerRightClick(marker);
                        if(contextMenu != null){
                            contextMenu.hide();
                        }
                        if(yo.drawing_manager != null){
                            yo.drawing_manager.setMap(null);
                            yo.drawing_manager = null;
                        }
                    }
                }
            }
        });

        var parametros = {};

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/popup_lugar_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-capas").html(data);
            }
        });
   
    },
    
    /**
     * Añade marcador de lugar emergencia
     * @param {googleMap} map
     * @returns {undefined}
     */
    addMarcador : function(){
        var yo = this;
        this.drawingManager();
        google.maps.event.addListener(yo.drawing_manager, 'markercomplete', function(marker) {
            yo.quitarLugarAlarma();
            yo.informacionMarcador(marker);
            
            yo.popupMetros(yo.mapa, marker, null);
            var dragend = new MapaMarcadorMoveListener();
            dragend.addMoveListener(marker, yo.mapa);
            lista_markers.push(marker);
        });
    }

});