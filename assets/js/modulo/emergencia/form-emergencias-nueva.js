var FormEmergenciasNueva = Class({
    
    /**
     * Identificador de la alarma
     */
    id_alarma : null,
    mapa : null,
    
    /**
     * si se envio o no correctamente el email
     */
    bo_email_enviado : false,
    
    /**
     * 
     * @param int value identificador de alarma
     * @returns void
     */
    __construct : function(value) {
        this.id_alarma = value;
    },
    
    /**
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){
       this.recargaGrilla();
        
        var agregar = "";
        if(this.bo_email_enviado){
            agregar = "<br/> Estado email: Enviado correctamente";
        } else {
            notificacionError("Estado del envío de email", "Ha ocurrido un error al enviar el email")
        }
        
        notificacionCorrecto("Resultado de la operacion", "Se ha insertado correctamente" + agregar);
    },
    
    /**
     * Se recarga lista con resultados de busqueda
     * @returns void
     */
    recargaGrilla : function(){
        $("#btnBuscarAlarmas").trigger("click");
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
     * Se asigna plugin picklist a combo de comunas
     * @returns void
     */
    bindComunasPicklist : function(){
        $("#nueva_comunas").picklist(); 
    },
    
    bindMapa : function(){
       var mapa = new AlarmaMapa("mapa");
       mapa.cargaMapa(); 
    } ,
    
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
                yo.callBackRechazar();
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
        
        var parametros = $("#form_nueva_emergencia").serializeArray();
        
        var salida = false;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia/json_guardar_emergencia", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    yo.callBackGuardar();
                    yo.bo_email_enviado = data.res_mail;
                    salida = true;
                } else {
                    $("#form-nueva-error").removeClass("hidden");
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
                yo.bindComunasPicklist();
                yo.bindMapa();
                
            }
        }); 
    }
});


