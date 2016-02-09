var MapaInformacionElementoEdicion = Class({ 
    
    /**
     * 
     * @param {type} clave
     * @param {type} parametros
     * @returns {undefined}
     */
    dialogoLugarEmergencia : function(clave, parametros){
        this.dialogo(
            "Datos del lugar de la emergencia",
            siteUrl + "mapa/popup_lugar_emergencia_edicion",
            clave, 
            parametros,
            function(elem, valor){
                if(elem.identificador == valor){
                    return true;
                } else {
                    return false;
                }
            },
            function(elem){
                if(elem.tipo == "CIRCULO LUGAR EMERGENCIA"){
                    return true;
                } else {
                    return false;
                }
            },
            function(){
                var custom = new MapaElementos();
                custom.removeOneCustomElements("identificador", clave);
            }
        );
    },
    
    /**
     * 
     * @param {type} clave
     * @param {type} parametros
     * @returns {undefined}
     */
    dialogoElemento : function(clave, parametros){
        this.dialogo(
            "Datos del elemento",
            siteUrl + "mapa/popup_elemento_edicion",
            clave, 
            parametros,
            function(elem, valor){
                if(elem.clave == valor){
                    return true;
                } else {
                    return false;
                }
            },
            function(elem){
                if(elem.tipo == "CIRCULO" || elem.tipo == "RECTANGULO" || elem.tipo== "POLIGONO"){
                    return true;
                } else {
                    return false;
                }
            },
            function(){
                var custom = new MapaElementos();
                custom.removeOneCustomElements("clave", clave);
            }
        );
    },
    
    /**
     * 
     * @param {type} clave identificador del elemento
     * @param {type} parametros parametros a enviar
     * @param {function} funcion_elemento funcion para buscar el elemento editado
     * @param {function} funcion_tipo function para el tipo del elemento editado
     * @returns {undefined}
     */
    dialogo : function(
            popup_titulo,
            save_url,
            clave, 
            parametros, 
            funcion_elemento, 
            funcion_tipo,
            funcion_remove
    ){
        var yo = this;
        
        bootbox.dialog({
            message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
            title: "<i class=\"fa fa-arrow-right\"></i> " + popup_titulo,
            className: "modal90",
            buttons: {
                guardar: {
                    label: " Efectuar cambios",
                    className: "btn-success fa fa-check",
                    callback: function() {

                        var informacion = {};

                        $('input[name^="parametro_nombre"]').each(function(i, input) {
                            informacion[$(input).val()] = $($('input[name^="parametro_valor"]').get(i)).val(); 
                        });

                        $.each(lista_poligonos, function(i, elem){
                            if(funcion_elemento(elem, clave)){
                                if(funcion_tipo(elem)){
                                    elem.setOptions(
                                        {fillColor : $("#color_editar").val()}
                                    );
                                    elem["informacion"] = informacion;
                                }
                            }
                        });
                        
                        //recarga menu inferior con elementos cargados
                        var elemento = new MapaElementos();
                        elemento.listaElementosVisor();
                    }
                },
                eliminar: {
                    label: " Quitar elemento",
                    className: "btn-danger fa fa-remove",
                    callback: function() {
                        funcion_remove();
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
            data: parametros,
            type: "post",
            url: save_url, 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-informacion-capas").html(data);
                yo.formPropiedades();
            }
        }); 
    },
    
    
    /**
     * Eventos formulario para agregar propiedades
     * @returns {undefined}
     */
    formPropiedades : function(){
        $("#add-propiedad").click(function(e){
            e.preventDefault();
            $("#div-propiedades").append(
                "<div class=\"row\">"
                    + "<div class=\"col-lg-4 text-right\">"
                        + "<input class=\"form-control\" type\"text\" name=\"parametro_nombre[]\" value=\"\" />"
                    + "</div>"
                    + "<div class=\"col-lg-1 text-left\">:</div>"
                    + "<div class=\"col-lg-6 text-left\">"
                        + "<input class=\"form-control propiedades\" type=\"text\" name=\"parametro_valor[]\" value=\"\">"
                    + "</div>"
                    + "<div class=\"col-lg-1 text-left\">"
                        + "<button class=\"btn btn-xs btn-danger remove-propiedad\"><i class=\"fa fa-remove\"></i></button>"
                    + "</div>"
            + "</div>"
            );
        });

        $(".remove-propiedad").livequery(function(){
            $(this).unbind("click");
            $(this).click(function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        });
    },
});


