var MapaEditor = Class({    
    
    mapa : null,
    id_emergencia : null,
    class_poligono : null,
    class_marcador : null,
    class_capa     : null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Añade front-end de capa
     */
    seteaClaseCapa : function(capa){
        this.class_capa = capa;
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
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.class_marcador = new MapaMarcador();
        this.class_poligono = new MapaPoligono();
    },
    
    /**
     * Carga el editor
     * @param {type} mapa
     * @returns {undefined}
     */
    iniciarEditor : function (mapa){
        var yo = this;
        this.mapa = mapa;
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: true,
            drawingControlOptions: {
              position: google.maps.ControlPosition.TOP_CENTER,
              drawingModes: [
                //google.maps.drawing.OverlayType.MARKER,
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
               // google.maps.drawing.OverlayType.POLYLINE,
                google.maps.drawing.OverlayType.RECTANGLE
              ]
            },
            markerOptions: {icon: baseUrl + 'assets/img/markers/spotlight-poi-black.png'},
            circleOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            polygonOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            },
            rectangleOptions: {
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            }
        });
        drawingManager.setMap(mapa);
        
        google.maps.event.addListener(drawingManager, 'rectanglecomplete', function(rectangle) {
            rectangle.setOptions({
                id : null,
                custom : true,
                tipo : "RECTANGULO",
                identificador:null,
                capa : null,
                clave : yo.uniqID(20),
                informacion: {"NOMBRE" : "Rectangulo agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            });
            
            var rectanguloClickListener = new  MapaRectanguloClickListener();
            rectanguloClickListener.addClickListener(rectangle, mapa);
            lista_poligonos.push(rectangle);
        });
        
        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            polygon.setOptions({
                id : null,
                custom : true,
                tipo : "POLIGONO",
                identificador:null,
                clave : yo.uniqID(20),
                capa : null,
                informacion: {"NOMBRE" : "Poligono agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            });
            yo.class_poligono.addClickListener(polygon, mapa);
            lista_poligonos.push(polygon);
        });
        
        google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
            circle.setOptions({
                id : null,
                custom : true,
                tipo : "CIRCULO",
                identificador:null,
                clave : yo.uniqID(20),
                capa : null,
                informacion: {"NOMBRE" : "Circulo agregado"},
                clickable: true,
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#ffff00',
                fillOpacity: 0.35
            })
            var circuloClickListener = new MapaCirculoClickListener();
            circuloClickListener.addClickListener(circle, mapa);
            lista_poligonos.push(circle);
        });

    },
    
     /**
     * Guardar
     * @returns {void}
     */
    guardar : function(){
        
        var custom = new MapaElementoCustom();
        
        var yo = this;
        var parametros = {"capas" : this.class_capa.retornaIdCapas(),
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
        		    var marcador = new MapaMarcadorLugarEmergencia();
                            marcador.seteaEmergencia(yo.id_emergencia);
                            marcador.addMarcador(map);
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
     * Carga el popup con las capas
     * disponibles
     * @returns {void}
     */
    popupCapas : function(){
        var yo = this;
        if(this.class_capa != null){
            
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
            
           
            
            var parametros = {"capas" : this.class_capa.retornaIdCapas(),
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
                            yo.class_capa.addCapa($(this).val());
                        } else {
                            yo.class_capa.removeCapa($(this).val());
                        }
                    });
                }
            }); 
            
        } else {
            notificacionError("Ha ocurrido un problema", "No se encontro el front-end de capas");
        }
    },
    
    /**
     * Genera id unico
     * @param {type} len
     * @param {type} charSet
     * @returns {String|editorAnonym$0@call;uniqID}
     */
    uniqID : function (len, charSet) {
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz,randomPoz+1);
        }
        
        var elementos = jQuery.grep(lista_poligonos, function( a ) {
            if(a.clave == randomString){
                return true;
            }
        });
        
        if(elementos.length > 0){
            return this.uniqID(20);
        } else {
            return randomString;
        }
    },
    
});


