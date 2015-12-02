var FormAlarmasEditar = Class({ extends : FormAlarma}, {
    
    
    /**
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){
        this.recargaGrilla();        
        notificacionCorrecto("Resultado de la operacion", "Se ha editado la alarma correctamente");
    },
    
    /**
     * Guarda la edicion de la alarma
     * @returns {Boolean}
     */
    guardar : function(){
        var yo = this;
        
        var parametros = $("#form_editar").serializeArray();
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "alarma/guardaAlarma", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
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
            url: siteUrl + "alarma/form_editar/id/" + this.id_alarma , 
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
                            label: " Guardar edición de alarma",
                            className: "btn-success fa fa-check",
                            callback: function() {
                                return yo.guardar();
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
                yo.bindComunasPicklist();
                yo.bindMapa();
            }
        }); 
    }    
});

