var EventoFormEditar = Class({ extends : EventoFormNuevo}, {
        
    /**
     * Se llama al cargar formulario de edicion
     * @returns {undefined}
     */
    callOnShow : function(){
        this.super("callOnShow");
        $("#tipo_emergencia").trigger("change");
        $("#estado_emergencia").trigger("change");
    },
        
    /**
     * Guarda la edicion de la alarma
     * @returns {Boolean}
     */
    guardar : function(){
        var yo = this;
        
        var parametros = this.getParametros("form_editar");
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "evento/guardar", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    $("#form_editar_error").addClass("hidden");
                    procesaErrores(data.error);
                    yo.callBackGuardar();
                    salida = true;
                } else {
                    $("#form_editar_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
        
        return salida;
    },
    
    /**
     * Muestra formulario para ingresar nueva emergencia
     * @returns void
     */
    mostrarFormulario : function(){
        var yo = this;
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "evento/editar/id/" + this.id_alarma , 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                bootbox.dialog({
                    message: html,
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Editar alarma",
                    buttons: {
                        guardar: {
                            id: "btn-guardar",
                            label: " Guardar edición de evento",
                            className: "btn-success fa fa-check",
                            callback: function() {
                                return yo.guardar();
                            }
                        },
                        paso2: {
                            label: " Ir al paso 2",
                            className: "btn-primary fa fa-arrow-right",
                            callback: function() {
                                yo.showPaso2("form_editar");
                                return false;
                            }
                        },
                        cerrar: {
                            label: " Cancelar",
                            className: "btn-white fa fa-close",
                            callback: function() {

                            }
                        }
                    }
                });
                
                yo.bindMapa();
                yo.callOnShow();
            }
        }); 
    }    
});

