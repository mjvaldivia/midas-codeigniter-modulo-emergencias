var MapaInformacionElemento = Class({ 
    
    /**
     * 
     * @param {string} clave
     * @returns {undefined}
     */
    dialogoEdicion : function(clave){
        bootbox.dialog({
                message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Datos del elemento",
                className: "modal90",
                buttons: {
                    guardar: {
                        label: " Efectuar cambios",
                        className: "btn-success fa fa-check",
                        callback: function() {
                            
                            var elementos = jQuery.grep(lista_poligonos, function( a ) {
                                if(a.clave == clave){
                                    return true;
                                }
                            });
                            
                            $.each(lista_poligonos, function(i, elem){
                                if(elem.clave == clave){
                                    if(elem.tipo == "CIRCULO" || elem.tipo == "RECTANGULO" || elem.tipo== "POLIGONO"){
                                        elem.setOptions({fillColor : $("#color_editar").val()})
                                    }
                                }
                            });
                            
                            var elemento = new MapaElementos();
                            elemento.listaElementosVisor();
                            
                        }
                    },
                    eliminar: {
                        label: " Quitar elemento",
                        className: "btn-danger fa fa-remove",
                        callback: function() {
                            var custom = new MapaElementos();
                            custom.removeOneCustomElements("clave", clave);
                        }
                    },
                    cerrar: {
                        label: " Cerrar ventana",
                        className: "btn-white fa fa-close",
                        callback: function() {}
                    }
                }
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    dialogo : function(){
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
    },
    
    /**
     * Levanta popup con la informacion del poligono
     * @param {object} marcadores
     * @returns {void}
     */
    popupInformacion : function(marcadores, elemento){
        var parametros = {"marcadores"  : JSON.stringify(marcadores),
                          "tipo"        : elemento.tipo,
                          "color"       : elemento.fillColor,
                          "informacion" : JSON.stringify(elemento.informacion)};
            
        if(elemento.capa != null){
            parametros["capa"] = elemento.capa;
            this.dialogo();
        }  else {  
            this.dialogoEdicion(elemento.clave);
        }

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/popup_informacion", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-informacion-capas").html(data);
            }
        }); 
    },
    
    /**
     * 
     * @param {google.maps.Polygon} poligono
     * @returns {void}
     */
    addRightClickListener : function(elemento, mapa){
        var yo = this;
        elemento.addListener('rightclick', function(event) {
            var seleccionado = [];
            $.each(lista_poligonos, function(j, elemento_seleccionado){
                
                var bo_elemento_seleccionado = false;
                switch(elemento_seleccionado.tipo){
                    //el circulo de la emergencia tiene tratamiento especial en circulo/click_listener.js
                    case "RECTANGULO":
                        bo_elemento_seleccionado = elemento_seleccionado.getBounds().contains(event.latLng);
                        break;
                    case "CIRCULO LUGAR EMERGENCIA":
                    case "CIRCULO":
                        bo_elemento_seleccionado = (google.maps.geometry.spherical.computeDistanceBetween(event.latLng, elemento_seleccionado.getCenter()) <= elemento_seleccionado.getRadius());
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
        menu.render(mapa, lista_elementos, posicion, function(lista){
            yo.preparaPopupInformacion(lista);
        });
    },
    
    /**
     * 
     * @param {type} lista_elementos
     * @returns {undefined}
     */
    preparaPopupInformacion : function(lista_elementos){
        var marcadores = {};
        var elemento_principal = null;
        $.each(lista_elementos, function(i, elemento){
            elemento_principal = elemento;
            //se recorren marcadores, y se buscan los dentro del poligono
            $.each(lista_markers, function(i, marker){
                var bo_marcador_dentro_de_poligono = false;
                switch(elemento.tipo){
                    //el circulo de la emergencia tiene tratamiento especial en circulo/click_listener.js
                    case "RECTANGULO":
                        bo_marcador_dentro_de_poligono = elemento.getBounds().contains(marker.getPosition());
                        break;
                    case "CIRCULO LUGAR EMERGENCIA":
                    case "CIRCULO":
                        bo_marcador_dentro_de_poligono = (google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), elemento.getCenter()) <= elemento.getRadius());
                        break;
                    case "POLIGONO":
                    default:
                        bo_marcador_dentro_de_poligono  = elemento.containsLatLng(marker.getPosition()); 
                        break;
                }

                if(bo_marcador_dentro_de_poligono){
                    marcadores[i] = marker.informacion;

                    if(marker.capa != null){
                        marcadores[i]["CAPA"] = marker.capa;
                     }
                }

            });
        });

        this.popupInformacion(marcadores, elemento_principal);
    }
});


