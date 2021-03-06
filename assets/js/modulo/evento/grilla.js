var EventoGrilla = Class({
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function() {
        this.loadGridAlarma();
        this.bindBtnEmergenciaNueva();
        this.bindBtnAlarmaEliminar();
        this.bindBtnEditarAlarma();
        this.bindBtnBuscar();
        this.bindBtnNuevaAlarma();
        this.bindBtnReporte();
        this.bindBtnFinalizar();
        
        var url = $(location).attr('href');
        var nuevo = url.indexOf("tab/nuevo");
        if(nuevo != -1){
            $("#nueva").trigger("click");
        }
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindBtnNuevaAlarma : function(){
        var yo = this;
        $("#nueva").click(function(e){
            e.preventDefault();
            var id = $(this).attr("data");
            var formulario = new EventoFormNuevo({
                "id" : id,
                callBackGuardar : function(bo_email_enviado){
                    yo.loadGridAlarma();
                    
                    var agregar = "";
                    if(bo_email_enviado){
                        agregar = "<br/> Se ha enviado correo electrónico a las direcciones seleccionadas ";
                    } else {
                        //notificacionError("Estado del envío de email", "Ha ocurrido un error al enviar el email")
                    }
                    
                    notificacionCorrecto("Resultado de la operacion", "Se ha creado un nuevo evento" + agregar);
                }
            });	
            formulario.mostrarFormulario();
        });
        
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindBtnBuscar : function(){
        var yo = this;
        $("#btnBuscarAlarmas").click(function(){
            yo.loadGridAlarma();
        });
    },
    
    /**
     * Asocia el evento para desplegar formulario para ingresar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEditarAlarma : function(){
        var yo = this;
        
        $(".editar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                var formulario = new EventoFormEditar({
                    "id" : id,
                    callBackGuardar : function(){
                        yo.loadGridAlarma();
                        notificacionCorrecto("Resultado de la operacion", "Se ha editado el evento correctamente");
                    }
                });	
                formulario.mostrarFormulario();
            });
        });
        
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindBtnFinalizar : function(){
        var yo = this;
        $(".emergencia-finalizar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data-rel");
                var formulario = new EventoFormFinalizar({
                    "id" : id,
                    callBack : function(){
                        yo.loadGridAlarma();
                    }
                });	
                formulario.mostrarFormulario();
            });
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindBtnReporte : function(){
        $(".emergencia-reporte").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data-rel");
                var reporte = new EventoReporteForm();	
                reporte.seteaEmergencia(id);
                reporte.mostrar();
            });
        });
    },
    
    /**
     * Asocia el evento para desplegar formulario para ingresar emergencia
     * a boton
     * @returns {void}
     */
    bindBtnEmergenciaNueva : function(){
        var yo = this;
        
        $(".emergencia-nueva").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Activar evento",
                    message: '¿Está seguro que desea activar la emergencia?',
                    buttons: {
                        success: {
                            label: "Activar",
                            className: "btn-success",
                            callback: function () {
                                var parametros = {"emergencia": id}
                                $.ajax({         
                                    dataType: "json",
                                    cache: false,
                                    async: false,
                                    data: parametros,
                                    type: "post",
                                    url: siteUrl + 'evento/ajax_activar_emergencia', 
                                    error: function(xhr, textStatus, errorThrown){
                                        notificacionError("Error", "Ha ocurrido un error al activar la emergencia");
                                    },
                                    success:function(data){
                                        if(data.estado == true){
                                            yo.loadGridAlarma();
                                            notificacionCorrecto("Resultado de la operacion", "Se ha activado el evento correctamente");
                                        } else {
                                            notificacionError("Error", "Ha ocurrido un error al activar la emergencia");
                                        }
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-white"
                        }
                    }
                }); 
                
            });
        });
        
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindBtnAlarmaEliminar : function(){
        var yo = this;
        $(".alarma-eliminar").livequery(function(){
            $(this).unbind( "click" );
            $(this).click(function(e){  
                e.preventDefault();
                var id = $(this).attr("data");
                bootbox.dialog({
                    title: "Eliminar elemento",
                    message: '¿Está seguro que desea eliminar este evento?',
                    buttons: {
                        success: {
                            label: "Aceptar",
                            className: "btn-primary",
                            callback: function () {
                                $.post(siteUrl + 'evento/eliminar',{id:id},'json').done(function (retorno) {
                                    if (retorno.correcto == true) { // sin error
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Se eliminó correctamente',
                                            buttons: {
                                                danger: {
                                                    label: "Cerrar",
                                                    className: "btn-info",
                                                    callback: function () {
                                                        yo.loadGridAlarma();
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        bootbox.dialog({
                                            title: "Resultado de la operacion",
                                            message: 'Error al eliminar',
                                            buttons: {
                                                danger: {
                                                    label: "Cerrar",
                                                    className: "btn-danger"
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-default"
                        }
                            }
                    }); 
                });
        });
    },
    
    /**
     * Carga la grilla de alarmas
     * @returns void
     */
    loadGridAlarma : function(){
        $("#grilla-alarma-loading").removeClass("hidden");
        $("#grilla-alarma").addClass("hidden");
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: $("#busqueda").serializeArray(),
            type: "post",
            url: siteUrl + "evento/ajax_grilla_alarmas", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#grilla-alarma").html(html);
                $("#grilla-alarma").removeClass("hidden");
                $("#grilla-alarma-loading").addClass("hidden");
            }
        });
    },
    
});

