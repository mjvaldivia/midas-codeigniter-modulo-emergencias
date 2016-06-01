var MapaInformacionElementoEdicion = Class({ 
    
    mapa : null,
    
    
    seteaMapa : function(mapa){
      this.mapa = mapa;  
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
     * 
     * @param {type} clave
     * @param {type} parametros
     * @returns {undefined}
     */
    dialogoLugarEmergencia : function(clave, parametros){
        var $this = this;
        this.dialogo(
            "Datos del lugar de la emergencia",
             baseUrl + $this.getController() + "/popup_lugar_emergencia_edicion",
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
        var $this = this;
        this.dialogo(
            "Datos del elemento",
            baseUrl + $this.getController() + "/popup_elemento_edicion",
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
                                    
                                    if($("#editar_forma").val() == "No"){
                                        elem.setEditable(false);
                                    } else {
                                        if($("#editar_forma").val() == "Si"){
                                            elem.setEditable(true);
                                        }
                                    }
                                    
                                    if(elem.tipo == "CIRCULO LUGAR EMERGENCIA"){
                                        elem.setRadius(parseInt($("#metros_editar").val()));
                                    }
                            
                                    elem["informacion"] = informacion;
                                }
                            }
                        });
                        
                        /*if($("#editar_mover").val()!="No"){
                            
                            var este = jQuery.grep(lista_poligonos, function( a ) {
                                if(funcion_elemento(a, clave)){
                                    return true;
                                }
                            });
                            
                            console.log(este[0]);
                            
                            var mapa = este[0].getMap();
                            este[0].setMap(null);
                            
                            var otros = jQuery.grep(lista_poligonos, function( a ) {
                                if(a.getMap() != null && !funcion_elemento(a, clave)){
                                    a.setMap(null);
                                    return true;
                                }
                            });
                            
                            console.log(otros);
                            
                            if($("#editar_mover").val() == "1"){
                                
                                $.each(otros, function(i, elemento){
                                   elemento.setMap(mapa); 
                                });
                                
                                este[0].setMap(mapa);
                                
                            } else {

                                este[0].setMap(mapa);
                                
                                $.each(otros, function(i, elemento){
                                   elemento.setMap(mapa); 
                                });
                                
                                
                            }
                        }*/
                        
                        
                        //recarga menu inferior con elementos cargados
                        var elemento = new MapaElementos();
                        elemento.listaElementosVisor();
                        $(".sp-choose").trigger("click");
                    }
                },
                eliminar: {
                    label: " Quitar elemento",
                    className: "btn-danger fa fa-remove",
                    callback: function() {
                        $(".sp-choose").trigger("click");
                        funcion_remove();
                    }
                },
                cerrar: {
                    label: " Cerrar ventana",
                    className: "btn-white fa fa-close",
                    callback: function() {
                        $(".sp-choose").trigger("click");
                    }
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
                yo.formExportar();
                
            }
        }); 
    },
    
    /**
     * 
     * @returns {undefined}
     */
    formExportar : function(){
        $("#exportar-elemento-kmz").click(function(e){
            e.preventDefault();
            var exportar = new MapaKmlExportar();
            exportar.makeElement(
                $("#elemento_tipo").val(), 
                $("#elemento_identificador").val(),
                $("#elemento_clave").val()
            );
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
                    + "<div class=\"col-lg-3 text-right\">"
                        + "<input class=\"form-control\" type\"text\" name=\"parametro_nombre[]\" value=\"\" />"
                    + "</div>"
                    + "<div class=\"col-lg-1 text-center\">:</div>"
                    + "<div class=\"col-lg-7 text-left\">"
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


