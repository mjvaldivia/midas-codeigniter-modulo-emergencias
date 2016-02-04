var MapaEditor = Class({    
    
    mapa : null,
    id_emergencia : null,
    
    class_poligono : null,
    class_marcador : null,
    class_capa     : null,
    class_kml      : null,
    
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
        this.class_kml = new MapaKml();
    },
    
    /**
     * Carga el editor
     * @param {type} mapa
     * @returns {undefined}
     */
    iniciarEditor : function (mapa){
        var yo = this;
        this.mapa = mapa;
        
        if(this.class_capa != null){
            yo.class_capa.seteaMapa(yo.mapa);
        }

        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: true,
            drawingControlOptions: {
              position: google.maps.ControlPosition.TOP_CENTER,
              drawingModes: [
                google.maps.drawing.OverlayType.MARKER,
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
               // google.maps.drawing.OverlayType.POLYLINE,
                google.maps.drawing.OverlayType.RECTANGLE
              ]
            },
            markerOptions: {"id" : null,
                            icon: baseUrl + 'assets/img/markers/spotlight-poi-black.png',
                            tipo : "PUNTO",
                            informacion : {"NOMBRE" : "MARCADOR AGREGADO",
                                           "TIPO" : "MARCADOR"},
                            capa: null,
                            draggable: true,
                            custom: true,
                            clave: ""},
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
        
        
        google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
            lista_markers.push(marker);
            
            var elemento = new MapaElementos();
            elemento.listaElementosVisor();
        });
        
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
            
            var circuloClickListener = new MapaInformacionElemento();
            circuloClickListener.addRightClickListener(rectangle, mapa);
            
            lista_poligonos.push(rectangle);
            
            var elemento = new MapaElementos();
            elemento.listaElementosVisor();
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
            
            var elemento = new MapaElementos();
            elemento.listaElementosVisor();
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
            
            
            var circuloClickListener = new MapaInformacionElemento();
            circuloClickListener.addRightClickListener(circle, mapa);
            
            lista_poligonos.push(circle);
            
            var elemento = new MapaElementos();
            elemento.listaElementosVisor();
        });

    },
    
     /**
     * Guardar
     * @returns {void}
     */
    guardar : function(){
        
        var custom = new MapaElementos();
        
        var yo = this;
        var parametros = {"capas" : this.class_capa.retornaIdCapas(),
                          "elementos" : custom.listCustomElements(),
                          "sidco" : $("#importar_sidco").is(":checked") ? 1:0,
                          "kmls" : this.class_kml.listKml(),
                          "id" : this.id_emergencia};
        Messenger().run({
            action: $.ajax,
            showCloseButton: true,
            successMessage: 'Mapa guardado correctamente',
            errorMessage: 'Ha ocurrido un error al guardar la configuración',
            progressMessage: '<i class=\"fa fa-spin fa-spinner\"></i> Guardando configuración de mapa...'
        }, {         
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
                    var elemento_custom = new MapaElementos();
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
    controlImportar : function (map) {
        
        $("#btn-importar-kml").click(function(){
            var kml = new MapaKmlImportar();
            kml.seteaMapa(map);
            kml.popupUpload();
        });
        
        $("#importar_sidco").click(function(){
            var sidco = new MapaKmlSidcoConaf();
            sidco.seteaMapa(map);
            
            if($(this).is(":checked")){
                sidco.loadKml();
            } else {
                sidco.remove();
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
        
        $("#btn-ubicacion-emergencia").click(function(){
            var marcador = new MapaMarcadorLugarEmergencia();
            marcador.seteaMapa(map);
            marcador.seteaEmergencia(yo.id_emergencia);
            marcador.addMarcador();
        });
    },
    
    /**
     * Boton para guardar
     * @param {type} map
     * @returns {undefined}
     */
    controlSave : function (map) {
        var yo = this;
        
        $("#btn-guardar").click(function(){
            yo.guardar();
        });
    },
    
    /**
     * Boton para seleccionar capas
     * @param {google_map} map
     * @returns {void}
     */
    controlCapas : function (map) {
        var yo = this;
        
        $("#btn-capas-gestionar").click(function(){
            yo.popupCapasComuna(); 
        });
        
        /*
        var divOptions = {
        		gmap: map,
        		name: '<i class="fa fa-eye"></i> &nbsp;Gestionar capas',
        		title: "",
        		id: "capas_comuna",
        		action: function(){
        			yo.popupCapasComuna(); 
        		}
        }
        var optionDiv1 = new optionDiv(divOptions);
        
        var divOptions2 = {
        		gmap: map,
        		label: 'Provincia',
        		title: "Capas pertenecientes a provincias",
        		id: "capas_provincias",
        		action: function(){
                            var capa_provincia = new MapaCapaProvincia();
                            capa_provincia.emergencia(yo.id_emergencia);
                            if($("#capas_provincias").css("display") == "none"){
                                capa_provincia.removeCapa();
                            } else {
        			capa_provincia.addCapa(map);
                            }
        		}
        }
       
        var optionDiv2 = new checkBox(divOptions2);
        
        var divOptions3 = {
        		gmap: map,
        		label: 'Region',
        		title: "Capas pertenecientes a provincias",
        		id: "capas_regiones",
        		action: function(){
                            var capa_region = new MapaCapaRegion();
                            capa_region.emergencia(yo.id_emergencia);
                            if($("#capas_regiones").css("display") == "none"){
                                capa_region.removeCapa();
                            } else {
        			capa_region.addCapa(map);
                            }
        		}
        }
       
        var optionDiv3 = new checkBox(divOptions3);
        
        
        
        //create the input box items
        
        //possibly add a separator between controls    
        var sep0 = new separator();
        var sep1 = new separator();
        var sep2 = new separator();
        
        
        //put them all together to create the drop down       
        var ddDivOptions = {
        	items: [sep0, optionDiv1, sep1, optionDiv2, sep2, optionDiv3],
                //items: [sep0, optionDiv1, sep3, optionDiv4],
        	id: "myddOptsDiv"        		
        }
        //alert(ddDivOptions.items[1]);
        var dropDownDiv = new dropDownOptionsDiv(ddDivOptions);               
                
        var dropDownOptions = {
        		gmap: map,
        		name: '<i class=\"fa fa-clone\"></i> Capas',
        		id: 'ddControl',
        		title: 'Seleccion de capas',
        		position: google.maps.ControlPosition.TOP_RIGHT,
        		dropDown: dropDownDiv 
        }
        
        var dropDown1 = new dropDownControl(dropDownOptions);   
        
        */
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
    popupCapasComuna : function(){
        var yo = this;
        if(this.class_capa != null){
            yo.class_capa.seteaMapa(yo.mapa);
            bootbox.dialog({
                    message: "<div id=\"contenido-popup-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Capas de comuna",
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
                url: siteUrl + "mapa_capas/popup_capas_comuna", 
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
            
            var poligonos = jQuery.grep(lista_poligonos, function( a ) {
                if(a["clave"] == randomString){
                    return true;
                }
            });
            
            var marcadores = jQuery.grep(lista_markers, function( a ) {
                if(a["clave"] == randomString){
                    return true;
                }
            });
            
            if(marcadores.lenght > 0 || poligonos.lenght > 0){
                return this.uniqID(20);
            } else {
                return randomString;
            }
        }
    },
    
});


