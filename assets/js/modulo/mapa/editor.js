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
        this.class_kml = new MapaArchivos();
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
              position: google.maps.ControlPosition.BOTTOM_CENTER,
              drawingModes: [
                google.maps.drawing.OverlayType.MARKER,
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
                google.maps.drawing.OverlayType.POLYLINE,
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
        
        var ruler = new GoogleMapsRuler(mapa);
        ruler.button();
        
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
        
        google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {
            polyline.setOptions({
                id : null,
                custom : true,
                tipo : "LINEA",
                identificador:null,
                clave : yo.uniqID(20),
                capa : null,
                informacion: {"NOMBRE" : "Linea agregada"},
                clickable: false,
                editable: false,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2
            });
            
            yo.class_poligono.addClickListener(polyline, mapa);
            lista_poligonos.push(polyline);
            
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
            });
            
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
        console.log(this.mapa);
        var custom = new MapaElementos();
        
        var yo = this;
        var parametros = {"capas" : this.class_capa.retornaIdCapas(),
                          "tipo_mapa" : this.mapa.getMapTypeId(),
                          "elementos" : custom.listCustomElements(),
                          "sidco" : $("#importar_sidco").is(":checked") ? 1:0,
                          "casos_febriles" : $("#importar_rapanui_casos").is(":checked") ? 1:0,
                          "casos_febriles_zona" : $("#importar_rapanui_zonas").is(":checked") ? 1:0,
                          "kmls" : this.class_kml.listArchivosKml(),
                          "id" : this.id_emergencia};
        Messenger().run({
            action: $.ajax,
            showCloseButton: true,
            successMessage: '<strong> Guardar <strong> <br> Ok',
            errorMessage: '<strong> Guardar <strong> <br> Se produjo un error al guardar',
            progressMessage: '<strong> Guardar <strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Procesando...'
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
                    elemento_custom.loadCustomElements(yo.mapa, false);
                    
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
        
        
        
        
        /**
         * Popup para subir kml
         */
        $("#btn-importar-kml").click(function(){
            var kml = new MapaKmlImportar();
            kml.seteaMapa(map);
            kml.popupUpload();
        });
        
        /**
         * Importar datos externos de conaf
         */
        $("#importar_sidco").livequery(function(){
            $(this).click(function(){
                var sidco = new MapaKmlSidcoConaf();
                sidco.seteaMapa(map);

                if($(this).is(":checked")){
                    sidco.loadKml();
                } else {
                    sidco.remove();
                }
            });
        });
        
        /**
         * Importar casos febriles
         */
        $("#importar_rapanui_casos").livequery(function(){
            $(this).click(function(){
                var rapanui = new MapaIslaDePascuaCasos();
                rapanui.seteaMapa(map);

                if($(this).is(":checked")){
                    rapanui.load();
                    $("#formulario-casos-rango").removeClass("hidden");
                } else {
                    rapanui.remove();
                    
                    if(!$("#importar_rapanui_zonas").is(":checked")){
                        $("#formulario-casos-rango").addClass("hidden");
                    }
                }
            });
        });
        
        /**
         * Importar casos febriles
         */
        $("#importar_rapanui_zonas").livequery(function(){
            $(this).click(function(){
                var rapanui = new MapaIslaDePascuaZonas();
                rapanui.seteaMapa(map);
                if($(this).is(":checked")){
                    rapanui.load();
                    $("#formulario-casos-rango").removeClass("hidden");
                } else {
                    rapanui.remove();
                    
                    if(!$("#importar_rapanui_casos").is(":checked")){
                        $("#formulario-casos-rango").addClass("hidden");
                    }
                }
            });
        });
        
        /**
         * Importar embarazadas
         */
        $("#importar_rapanui_embarazo").livequery(function(){
            $(this).click(function(){
                var rapanui = new MapaIslaDePascuaEmbarazadas();
                rapanui.seteaMapa(map);
                if($(this).is(":checked")){
                    rapanui.load();
                } else {
                    rapanui.remove();
                }
            });
        });
        
        /**
         * Exportar mapa a kml
         */
        $("#btn-exportar-kml").click(function(){
           var exportar = new MapaKmlExportar();
           exportar.makeMapa();
        });
        
        /**
         * Quitar archivo subido
         */
        $(".btn-quitar-archivo").livequery(function(){
            $(this).click(function(){
                var id = $(this).attr("data-rel");
                
                lista_kml = jQuery.grep(lista_kml, function( a ) {
                    if(a["hash"] == id){
                        var marcador = new MapaMarcador();
                        marcador.removerMarcadores("identificador", "kml_" + a["hash"]);
                        
                        var poligono = new MapaPoligono();
                        poligono.removerPoligono("identificador", "kml_" + a["hash"]);
                        
                        return false;
                    } else {
                        return true;
                    }
                });
                
                var archivo = new MapaArchivos();
                archivo.updateListaArchivosAgregados();
            });
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
    },
    
    /**
     * Boton para mostrar instalaciones
     * @param {type} map
     * @returns {undefined}
     */
    controlInstalaciones : function (map) {
        var menu = new MapaLayoutAmbitoCapa();
        menu.seteaMapa(map);
        menu.seteaEmergencia(this.id_emergencia);
        menu.render();
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


