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
     * Parche para corregir mapa en reporte
     * @returns {elementosAnonym$0.controlador.controller|String}
     */
    getController : function(){
      var controller = getController();  
      if(controller == "mapa" || controller == "mapa_publico"){
          return controller;
      } else {
          return "mapa";
      }
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
                strokeWeight: 1,
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
            
            marker.html = "";
            marker.clave = yo.uniqID(21);
            
            lista_markers.push(marker);
            
            var elemento = new MapaElementos();
            elemento.listaElementosVisor();

            var click = new MapaMarcadorEditar();
            click.seteaMarker(marker);
            click.clickListener();
            
            var elemento_marcador = new MapaMarcador();
            elemento_marcador.seteaMapa(yo.mapa);
            elemento_marcador.informacionMarcador(marker);
            
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
                strokeWeight: 1,
                fillColor: '#ffff00',
                fillOpacity: 0.35,
                popup_poligono: true
            });
            
            var circuloClickListener = new MapaPoligonoInformacion();
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
                strokeWeight: 1,
                fillColor: '#ffff00',
                fillOpacity: 0.35,
                popup_poligono: true
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
                editable: true,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 1
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
                strokeWeight: 1,
                fillColor: '#ffff00',
                fillOpacity: 0.35,
                popup_poligono: true
            });
            
            var circuloClickListener = new MapaPoligonoInformacion();
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
        $("#btn-guardar").prop("disabled", true);
        var tareas = new MapaLoading();
        var custom = new MapaElementos();
        tareas.push(1);
        var yo = this;
        var parametros = {"capas" : this.class_capa.retornaIdCapas(),
                          "zoom" : this.mapa.getZoom(),
                          "latitud" : this.mapa.getCenter().lat(),
                          "longitud" : this.mapa.getCenter().lng(),
                          //"posicion" : yo.mapa.getCenter(),
                          "tipo_mapa" : this.mapa.getMapTypeId(),
                          "elementos" : custom.listCustomElements(),
                          
                          "sidco" : $("#importar_sidco").is(":checked") ? 1:0,
                          
                          "casos_febriles" : $("#importar_rapanui_casos").is(":checked") ? 1:0,
                          "casos_febriles_zona" : $("#importar_rapanui_zonas").is(":checked") ? 1:0,
                          
                          "marea_roja" : $("#marea_roja").is(":checked") ? 1:0,
                          "marea_roja_pm" : $("#marea_roja_pm").is(":checked") ? 1:0,
                          
                          "vectores" : $("#vectores_marcadores").is(":checked") ? 1:0,
                          "vectores_hallazgos" : $("#vectores_hallazgos").is(":checked") ? 1:0,
                          
                          "kmls" : this.class_kml.listArchivosKml(),
                          "kmls_ocultos" : this.getArchivosImportadosOcultos(),
                          "id" : this.id_emergencia};
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: baseUrl + yo.getController() + "/save", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                   /* */
                    
                    var archivos = new MapaArchivos();
                    archivos.seteaEmergencia(yo.id_emergencia);
                    archivos.seteaMapa(yo.mapa);
                    archivos.quitarArchivos();
                    archivos.loadArchivos(yo.mapa);
                    
                    var elemento_custom = new MapaElementos();
                    elemento_custom.emergencia(yo.id_emergencia);
                    elemento_custom.removeCustomElements();
                    elemento_custom.loadCustomElements(yo.mapa, false);
                    
                    $("#btn-guardar").prop("disabled", false);
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
                tareas.remove(1);
            }
        }); 
    },
    
    /**
     * 
     * @returns {object}
     */
    getArchivosImportadosOcultos : function(){
        var ocultos = {};
        $(".ocultar-archivo-importado").each(function(i, elemento){
            console.log(elemento);
           if(!($(elemento).is(":checked"))){
               ocultos[i] = $(elemento).val();
           } 
        });
        return ocultos;
    },
    
    /**
     * Boton editar
     * @param {googleMaps} map
     * @returns {void}
     */
    controlImportar : function (map) {

        var $this = this;

        /**
         * Popup para subir kml
         */
        $("#btn-importar-kml").click(function(){
            var kml = new MapaKmlImportar();
            kml.seteaMapa(map);
            kml.popupUpload();
        });
        

       
        
        
        
        /**
         * Exportar mapa a kml
         */
        $("#btn-exportar-kml").click(function(){
           var exportar = new MapaKmlExportar();
           exportar.makeMapa();
        });
        
        $(".ver-detalle-archivo").livequery(function(){
            $(this).click(function(){
                var id = $(this).data("rel");
                var hash = $(this).data("hash");
                bootbox.dialog({
                    message: "<div id=\"contenido-popup-informacion-archivo\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                    title: "<i class=\"fa fa-arrow-right\"></i> Detalle archivo importado",
                    className: "modal90",
                    buttons: {
                        
                        guardar: {
                            label: " Efectuar cambios",
                            className: "btn-success fa fa-check",
                            callback: function() {

                               
                            }
                        },
                        eliminar: {
                            label: " Quitar elemento",
                            className: "btn-danger fa fa-remove",
                            callback: function() {
                                lista_kml = jQuery.grep(lista_kml, function( a ) {
                                    if(a["hash"] == hash){
                                        var marcador = new MapaMarcador();
                                        marcador.removerMarcadores("relacion", a["hash"]);

                                        var poligono = new MapaPoligono();
                                        poligono.removerPoligono("relacion", a["hash"]);

                                        return false;
                                    } else {
                                        return true;
                                    }
                                });

                                var archivo = new MapaArchivos();
                                archivo.updateListaArchivosAgregados();
                            }
                        },
                        cerrar: {
                            label: " Cerrar ventana",
                            className: "btn-white fa fa-close",
                            callback: function() {}
                        }
                    }
                });

                $.ajax({         
                    dataType: "html",
                    cache: false,
                    async: true,
                    data: {"id" : id},
                    type: "post",
                    url:  baseUrl + "mapa_kml/popup_informacion_archivo", 
                    error: function(xhr, textStatus, errorThrown){
                        notificacionError("Ha ocurrido un problema", errorThrown);
                    },
                    success:function(data){
                        $("#contenido-popup-informacion-archivo").html(data);
                        
                        $(".archivo-eliminar-elemento").livequery(function(){
                            $(this).unbind("click");
                            $(this).click(function(){
                                var primaria = $(this).data("rel");
                                var tipo = $(this).data("tipo");
                                console.log(tipo);
                                console.log(hash);
                                console.log(primaria);
                                if(tipo == "marcador"){
                                    var marcadores = jQuery.grep(lista_markers, function( a ) {
                                        if(a["identificador"] == "kml_" + hash && a["clave_primaria"] == primaria){
                                            return true;
                                        }
                                    });
                                    
                                    $.each(marcadores, function(i, marker){
                                        marker.setMap(null); 
                                    });
                                    
                                    lista_markers = jQuery.grep(lista_markers, function( a ) {
                                        if(a["identificador"] == "kml_" + hash && a["clave_primaria"] == primaria){
                                            return false;
                                        }
                                    });
                                } else if(tipo == "poligono"){
                                    var poligonos = jQuery.grep(lista_poligonos, function( a ) {
                                        console.log("Identificador: " + a["identificador"] + " Primaria:" + a["clave_primaria"]);
                                        if(a["identificador"] == "kml_" + hash){
                                            return true;
                                        }
                                    });
                                    
                                    console.log(poligonos);
                                    
                                    $.each(poligonos, function(i, marker){
                                        marker.setMap(null); 
                                    });
                                    
                                    lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
                                        if(a["identificador"] == "kml_" + hash){
                                            return false;
                                        }
                                    });
                                }
                            });
                        });
                    }
                }); 
                
            });
        });
        
      

    },
    
    /**
     * Boton editar
     * @param {googleMaps} map
     * @returns {void}
     */
    controlEditar : function (map) {
       
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
         
    },
    
    /**
     * Boton para mostrar instalaciones
     * @param {type} map
     * @returns {undefined}
     */
    controlInstalaciones : function (map) {
        
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


