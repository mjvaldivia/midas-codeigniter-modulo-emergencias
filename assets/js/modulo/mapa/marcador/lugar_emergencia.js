var MapaMarcadorLugarEmergencia = Class({ extends : MapaMarcador}, {
    
    mapa : null,

    draggable : true,
    id_emergencia : null,
    drawing_manager : null,
    unique_id : null,
    
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
     * Dibuja circulo con la zona de la emergencia
     * @param {int} id
     * @param {string} lon
     * @param {string} lat
     * @param {int} radio
     * @param {object} propiedades
     * @returns {undefined}
     */
    dibujarCirculo : function(id, lon, lat, radio, propiedades){
        if(radio > 0){
            var yo = this;

            var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));
            
            var circulo = new MapaCirculoDibujar();
            circulo.seteaTipo("CIRCULO LUGAR EMERGENCIA");
            circulo.seteaMapa(yo.mapa);
            circulo.seteaUniqueId(yo.unique_id);
            circulo.seteaEditable(true);
            circulo.seteaIdentificador(id);
            circulo.dibujarCirculo(id, 
                                   propiedades, 
                                   posicion, 
                                   radio, 
                                   "red");
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
    posicionarMarcador : function(id, lon, lat, radio, propiedades, imagen){
        var yo = this;
        this.quitarLugarAlarma();
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        var draggable = true;
        if(radio > 0){
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
            custom: true,
            informacion : propiedades,
            draggable: draggable,
            map: yo.mapa,
            icon: imagen
        });  

        this.informacionMarcador(marker);
        
        this.dibujarCirculo(id, lon, lat, radio, propiedades);

        lista_markers.push(marker);
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
                            draggable: false,
                            clave : yo.unique_id,
                            custom : true,
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
                          "lat" : latLon.lat,
                          "lon" : latLon.lng};
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/ajax_guardar_lugar_emergencia", 
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
                         "NOMBRE" : ""}
                    );
                    
                    if(parametros.metros == 0){
                        marker.setDraggable(true);
                    }
                    yo.informacionMarcador(marker);
                    lista_markers.push(marker);
                } else {
                    $("#form_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        });
        this.drawing_manager.setMap(null);
        return salida;  
    },
    
    /**
     * Popup para ingresar metros
     * @param {marker} marker
     * @returns {undefined}
     */
    popupMetros : function(mapa, marker){
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
                        return yo.addCirculo(marker);
                    }
                },
                cerrar: {
                    label: " Cerrar ventana",
                    className: "btn-white fa fa-close",
                    callback: function() {
                        yo.drawing_manager.setMap(null);
                        yo.drawing_manager = null;
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
            yo.popupMetros(yo.mapa, marker);
        });
    }

});