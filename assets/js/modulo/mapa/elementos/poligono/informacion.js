var MapaPoligonoInformacion = Class({ 
    
    mapa : null,
    
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
     * Muestra dialogo que muestra informacion y permite editar 
     * datos del lugar de la emergencia
     * @param {string} identificador
     * @param {object} parametros
     * @returns {undefined}
     */
    dialogoLugarEmergencia : function(identificador, parametros){
        var dialogo = new MapaInformacionElementoEdicion();
        dialogo.seteaMapa(this.mapa);
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
        dialogo.seteaMapa(this.mapa);
        dialogo.dialogoElemento(clave, parametros);
    },
    
    /**
     * Muestra dialogo con informacion de 
     * una capa seleccionada
     * @returns {undefined}
     */
    dialogoInformacion : function(parametros){
        var $this = this;
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
            url:  baseUrl + $this.getController() + "/popup_elemento_info", 
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
        
        
        switch(elemento.tipo){
            case "CIRCULO":
                var contenido = new MapaInformacionElementoContenido();
                parametros["geometry"] = JSON.stringify(contenido.coordenadasCirculo(elemento.getCenter(), elemento.getRadius()));
                break;
            case "POLIGONO":
                parametros["geometry"] = JSON.stringify(elemento.getPath().getArray());
                break;
            case "MULTIPOLIGONO":
                parametros["geometry"] = JSON.stringify(elemento.getPaths());
                break;
            case "RECTANGULO":
                var bounds = elemento.getBounds();
                var NE = bounds.getNorthEast();
                var SW = bounds.getSouthWest();
                var NW = new google.maps.LatLng(NE.lat(),SW.lng());
                var SE = new google.maps.LatLng(SW.lat(),NE.lng());
                parametros["geometry"] = JSON.stringify(new Array(NE,NW,SW,SE));
                break;
        }
        
        if(elemento.capa != null){
            parametros["capa"] = elemento.capa;
            this.dialogoCapa(parametros);
        } else {
            if(elemento.tipo != "CIRCULO LUGAR EMERGENCIA"){
                if(elemento.custom == true) {
                    this.dialogoEdicion(elemento.clave, parametros);
                } else {
                    this.dialogoEdicion(elemento.clave, parametros);
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
       
        /*
        elemento.addListener('click', function(event) {
       
            if(!click_en_menu){
                yo.muestraMenuParaInfoWindow(mapa, yo.elementosSeleccionados(event), event.latLng);  
            } else {
                click_en_menu = false;
                var menu = new MapaInformacionElementoMenu();
                menu._hideMenu();
            }

        });*/
        
        
        if(elemento.popup_poligono){
            elemento.addListener('rightclick', function(event) {
                yo.muestraMenuParaPopup(mapa, yo.elementosSeleccionados(event), event.latLng);  
            });
        }
    },
    
    /**
     * Busca elementos que contienen el punto donde se efectuo el click
     * @param {event} event
     * @returns {undefined}
     */
    elementosSeleccionados : function(event){
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
        
        return seleccionado;
    },
    
    /**
     * Muestra el menu para lanzar popup de informacion
     * @param {type} mapa
     * @param {type} lista_elementos
     * @param {type} posicion
     * @returns {undefined}
     */
    muestraMenuParaInfoWindow : function(mapa, lista_elementos, posicion){
        var yo = this;
        
        var menu = new MapaInformacionElementoMenu();
        menu.render(
                mapa, 
                lista_elementos, 
                posicion, 
                function(lista){
                    
                    var markerContent = '<div class="info_content">';
                    
                    markerContent += '<div class="col-xs-12"><strong>ELEMENTO:</strong> ' + lista[0].tipo + '</div>';
                    
                    var propiedades = lista[0].informacion;

                    $.each(propiedades, function(nombre, valor){
                        if(valor != ""){
                            markerContent += '<div class="col-xs-12"><strong>' + nombre +':</strong> ' + valor + '</div>';
                        }
                    });

                    markerContent += '</div>';

                    var infoWindow = new google.maps.InfoWindow({
                        content: markerContent,
                        position: posicion
                    });  

                    infoWindow.open(mapa);
                });
    },
    
    /**
     * Muestra el menu para lanzar popup de informacion
     * @param {type} mapa
     * @param {type} lista_elementos
     * @param {type} posicion
     * @returns {undefined}
     */
    muestraMenuParaPopup : function(mapa, lista_elementos, posicion){
        var yo = this;
        
        var menu = new MapaInformacionElementoMenu();
        menu.render(
                mapa, 
                lista_elementos, 
                posicion, 
                function(lista){
                    yo.preparaPopupInformacion(mapa, lista);
                    context_menu = null;
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
        yo.mapa = mapa;
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