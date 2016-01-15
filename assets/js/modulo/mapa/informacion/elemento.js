var MapaInformacionElemento = Class({ 
    
    dialogoEdicion : function(clave){
        bootbox.dialog({
                message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Datos del elemento",
                className: "modal90",
                buttons: {
                    guardar: {
                        label: " Guardar cambios",
                        className: "btn-success fa fa-save",
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
                        }
                    },
                    eliminar: {
                        label: " Eliminar elemento",
                        className: "btn-danger fa fa-remove",
                        callback: function() {
                            var elementos = jQuery.grep(lista_poligonos, function( a ) {
                                if(a.clave == clave){
                                    return true;
                                }
                            });
                            
                            $.each(elementos, function(i, elem){
                                elem.setMap(null); 
                            });
                            
                            lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
                                if(a.clave != clave){
                                    return true;
                                }
                            });
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
        console.log(elemento);
        var parametros = {"marcadores" : JSON.stringify(marcadores),
                          "tipo" : elemento.tipo,
                          "color" : elemento.fillColor,
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
    }
});


