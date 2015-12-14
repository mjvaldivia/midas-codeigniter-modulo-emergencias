var FormEmergenciasNueva = Class({ extends : FormAlarma}, {
                
    /**
     * Se recarga lista con resultados de busqueda
     * @returns void
     */
    recargaGrilla : function(){
        $("#btnBuscarAlarmas").trigger("click");
    },
    
    /**
     * Activa los botones presentes en el paso 2
     * @returns {undefined}
     */
    btnPaso2 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        $(path_buttons + "button[data-bb-handler='guardar']").hide();
        //$(path_buttons + "button[data-bb-handler='rechazar']").hide();
        $(path_buttons + "button[data-bb-handler='paso2']").show();
    },
    
    /**
     * Activa los botones presentes en paso 1
     * @returns {undefined}
     */
    btnPaso1 : function(){
        var path_buttons = ".bootbox > .modal-dialog > .modal-content > .modal-footer > "; 
        $(path_buttons + "button[data-bb-handler='guardar']").show();
        //$(path_buttons + "button[data-bb-handler='rechazar']").show();
        $(path_buttons + "button[data-bb-handler='paso2']").hide();
    },
    
    /**
     * Retorno despues de rechazar
     * @returns void
     */
    callBackRechazar : function(){
        this.recargaGrilla();
        notificacionCorrecto("Resultado de la operacion", "Se ha rechazado correctamente");
    },
    
    /**
     * Se rechaza creacion de emergencia
     * @returns {Boolean}
     */
    rechazaEmergencia : function(){
        var yo = this;
        
        var parametros = $("#form_nueva_emergencia").serializeArray();
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/json_rechaza_alarma", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                salida = data.correcto;
                if(data.correcto){
                    yo.callBackRechazar();
                }
            }
        }); 
        
        return salida;
    },
    
    /**
     * Guarda y activa la alarma
     * @returns {Boolean}
     */
    guardaEmergencia : function(){
        
        var yo = this;
        
        var parametros = this.getParametros("form_nueva_emergencia");
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/json_activa_alarma", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.bo_email_enviado = data.res_mail;
                    yo.callBackGuardar();
                    salida = true;
                } else {
                    $("#form_nueva_emergencia_error").removeClass("hidden");
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
            url: siteUrl + "emergencia/form_nueva/id/" + this.id_alarma , 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                bootbox.dialog({
                    message: html,
                    className: "modal90",
                    title: "<i class=\"fa fa-arrow-right\"></i> Generar emergencia",
                    buttons: {
                        guardar: {
                            label: " Activar y generar emergencia",
                            className: "btn-success fa fa-check",
                            callback: function() {
                                return yo.guardaEmergencia();
                            }
                        },
                        paso2: {
                            label: " Ir al paso 2",
                            className: "btn-primary fa fa-arrow-right",
                            callback: function() {
                                yo.showPaso2("form_nueva_emergencia");
                                return false;
                            }
                        },
                        rechazar: {
                            label: " Rechazar emergencia",
                            className: "btn-danger fa fa-thumbs-down",
                            callback: function() {
                                return yo.rechazaEmergencia();
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


