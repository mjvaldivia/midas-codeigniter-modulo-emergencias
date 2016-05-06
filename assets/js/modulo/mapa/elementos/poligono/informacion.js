var MapaPoligonoInformacion = Class({ 
    
    /**
     * Muestra dialogo que muestra informacion y permite editar 
     * datos del lugar de la emergencia
     * @param {string} identificador
     * @param {object} parametros
     * @returns {undefined}
     */
    dialogoLugarEmergencia : function(identificador, parametros){
        var dialogo = new MapaInformacionElementoEdicion();
        dialogo.dialogoLugarEmergencia(identificador, parametros);
    },
    
    /**
     * Muestra dialogo que muestra informacion y permite editar 
     * un elemento custom
     * @param {string} clave
     * @param {object} parametros
     * @returns {undefined}
     */
    dialogoEdicion : function(clave, parametros){
        var dialogo = new MapaInformacionElementoEdicion();
        dialogo.dialogoElemento(clave, parametros);
    },
    
    /**
     * Muestra dialogo con informacion de 
     * una capa seleccionada
     * @returns {undefined}
     */
    dialogoInformacion : function(parametros){
        bootbox.dialog({
            message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
            title: "<i class=\"fa fa-arrow-right\"></i> Datos del elemento",
            className: "modal90",
            buttons: {
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
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/popup_elemento_info", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-informacion-capas").html(data);
                var dialogo = new MapaInformacionElementoEdicion();
                dialogo.formExportar();
            }
        }); 
    },
    
    /**
     * Muestra dialogo con informacion de 
     * una capa seleccionada
     * @returns {undefined}
     */
    dialogoCapa : function(parametros){
        bootbox.dialog({
            message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
            title: "<i class=\"fa fa-arrow-right\"></i> Datos del elemento",
            className: "modal90",
            buttons: {
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
            data: parametros,
            type: "post",
            url: siteUrl + "mapa_capas/popup_informacion", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-informacion-capas").html(data);
                var dialogo = new MapaInformacionElementoEdicion();
                dialogo.formExportar();
            }
        }); 
    },
    
    /**
     * Levanta popup con la informacion del elemento
     * de acuerdo a su tipo
     * @param {object} marcadores
     * @returns {void}
     */
    popupInformacion : function(marcadores, formas, elemento){
        
        var parametros = {"marcadores"  : JSON.stringify(marcadores),
                          "formas"      : JSON.stringify(formas),
                          "tipo"        : elemento.tipo,
                          "color"       : elemento.fillColor,
                          "informacion" : JSON.stringify(elemento.informacion),
                          "clave" : elemento.clave,
                          "identificador" : elemento.identificador};
        
        if(elemento.capa != null){
            parametros["capa"] = elemento.capa;
            this.dialogoCapa(parametros);
        } else {
            if(elemento.tipo != "CIRCULO LUGAR EMERGENCIA"){
                if(elemento.custom == true) {
                    this.dialogoEdicion(elemento.clave, parametros);
                } else {
                    this.dialogoInformacion(parametros);
                }
            } else {
                if(elemento.custom == true) {
                    parametros["radio"] = elemento.getRadius(); 
                    this.dialogoLugarEmergencia(elemento.identificador, parametros); 
                } else {
                    if(elemento.tipo == "CIRCULO LUGAR EMERGENCIA" || elemento.tipo == "CIRCULO"){
                        parametros["radio"] = elemento.getRadius(); 
                    }
                    this.dialogoInformacion(parametros);
                }
            }
        }
    },
    
    /**
     * Muestra menu al presionar el boton derecho sobre un elemento
     * @param {google.maps.Polygon|google.maps.Rectangle|google.maps.Circle} elemento
     * @param {google.maps}
     * @returns {void}
     */
    addRightClickListener : function(elemento, mapa){
        var yo = this;
        
        elemento.addListener('rightclick', function(event) {

            // busca elementos en el punto donde se hizo click
            var seleccionado = [];
            $.each(lista_poligonos, function(j, elemento_seleccionado){

                var bo_elemento_seleccionado = false;
                switch(elemento_seleccionado.tipo){
                    case "RECTANGULO":
                        bo_elemento_seleccionado = elemento_seleccionado.getBounds().contains(event.latLng);
                        break;
                    // la zona en forma de dona no debe existir en la zona central al hacer click
                    case "CIRCULO LUGAR EMERGENCIA":
                        bo_elemento_seleccionado = (google.maps.geometry.spherical.computeDistanceBetween(event.latLng, elemento_seleccionado.getCenter()) <= elemento_seleccionado.getRadius());
                        if(bo_elemento_seleccionado){

                            //se buscan hermanas
                            var zonas = jQuery.grep(lista_poligonos, function( a ) {
                                if(a["tipo"] == "CIRCULO LUGAR EMERGENCIA" && a["identificador"] != elemento_seleccionado.identificador){
                                    if((google.maps.geometry.spherical.computeDistanceBetween(event.latLng, a.getCenter()) <= a.getRadius())){
                                        return true;
                                    }
                                }
                            });

                            //si las hermanas son mas chicas (estan contenidas dentro de la zona), entonces no se incluye esta zona en el menu
                            if(zonas.length > 0){
                               var mi_radio = elemento_seleccionado.getRadius();
                               $.each(zonas, function(i, zona_hermana){
                                   if(zona_hermana.getRadius() < mi_radio){
                                       bo_elemento_seleccionado = false;
                                   }
                               });
                            }
                        }
                        break;
                    case "CIRCULO":
                        bo_elemento_seleccionado = (google.maps.geometry.spherical.computeDistanceBetween(event.latLng, elemento_seleccionado.getCenter()) <= elemento_seleccionado.getRadius());
                        break;
                    case "LINEA":
                        //no se hace nada
                        break;
                    case "POLIGONO":
                    default:
                        bo_elemento_seleccionado = elemento_seleccionado.containsLatLng(event.latLng); 
                        break;
                }

                if(bo_elemento_seleccionado){
                    seleccionado.push(elemento_seleccionado);
                }
            });

            yo.muestraMenu(mapa, seleccionado, event.latLng);       
        });
     
    },
    
    /**
     * Muestra el menu
     * @param {type} mapa
     * @param {type} lista_elementos
     * @param {type} posicion
     * @returns {undefined}
     */
    muestraMenu : function(mapa, lista_elementos, posicion){
        var yo = this;
        
        var menu = new MapaInformacionElementoMenu();
        menu.render(
                mapa, 
                lista_elementos, 
                posicion, 
                function(lista){
                    yo.preparaPopupInformacion(mapa, lista);
                });
    },
    
    /**
     * Prepara y carga la informacion que se desplegara
     * en el popup
     * @param {object} lista_elementos elemento seleccionado en el menu
     * @returns {undefined}
     */
    preparaPopupInformacion : function(mapa,lista_elementos){
        
        var yo = this;
        

        
        /*var box = bootbox.dialog({
                message: '<div class=\"row\"><div class=\"col-xs-12 text-center\"><i class="fa fa-3x fa-spin fa-spinner"></i> <br/> Procesando información </div> </div>',
                buttons: {}
            });*/

    
            var contenido = new MapaInformacionElementoContenido();

            var elemento_principal = null;
            $.each(lista_elementos, function(i, elemento){

                //guardo informacion del ultimo elemento listado
                elemento_principal = elemento;

                //se recorren marcadores, y se busca los que estan dentro del elemento
                contenido.procesaMarcadores(elemento);
                contenido.procesaFormas(elemento, mapa);
            });

          
            
            yo.popupInformacion(
                contenido.retornaMarcadores(), 
                contenido.retornaFormas(),
                elemento_principal
            );

    }
});