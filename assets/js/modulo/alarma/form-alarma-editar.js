var FormAlarmasEditar = Class({ extends : FormEmergenciasNueva}, {
    
    bindMapa : function(){
        var mapa = new AlarmaMapa("mapa");
       
        if($("#longitud").val() != "" && $("#latitud").val() != ""){
            mapa.setLongitud($("#longitud").val());
            mapa.setLatitud($("#latitud").val());
            mapa.setGeozone($("#geozone").val());
        }

        mapa.inicio();
        mapa.cargaMapa(); 
    } ,
    
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
                            label: " Guardar",
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
    },
    
    /**
     * Se asigna plugin picklist a combo de comunas
     * @returns void
     */
    bindComunasPicklist : function(){
        $("#comunas").picklist(); 
    }
    
});

