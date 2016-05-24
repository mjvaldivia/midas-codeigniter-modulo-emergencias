var EventoReporteForm = Class({
    
    /**
     * Identificador de la emergencia
     */
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    
    /**
     * 
     * @param {type} boton
     * @returns {Boolean}
     */
    enviarCorreo : function(boton){
        var imagen = new EventoReporteMapaImagen("mapa");
        imagen.addOnReadyFunction("enviando email", this.correo, boton);
        imagen.crearImagen();
        return false;
    },
    
    /**
     * Envia email con reporte
     * @param {string} hash identificador de la imagen del mapa
     * @param {object} boton que dispara el envio de correo
     * @returns {undefined}
     */
    correo : function(hash, boton){
        var parametros = $("#form_reporte_emergencia").serializeArray();
        
        var add = {"value" : hash,
                   "name"  : "hash"};
               
        parametros.push(add);
        
        console.log(parametros);
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "emergencia_reporte/ajax_enviar_correo", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto == true){
                    //procesaErrores(data.error);
                    notificacionCorrecto("Envío de reporte", "El correo se ha enviado correctamente");
                    bootbox.hideAll()
                } else {
                    $("#form_error").removeClass("hidden");
                    procesaErrores(data.error);
                    
                    $(boton).children("i").addClass("fa-envelope-o");
                    $(boton).children("i").removeClass("fa-spin fa-spinner");
                }
            }
        });
    },
    
    /**
     * Carga el reporte
     * @returns {Boolean}
     */
    mostrarReporte : function(){
        var imagen = new EventoReporteMapaImagen("mapa");
        imagen.addOnReadyFunction("carga pdf", this.generarPdf, this.id_emergencia);
        imagen.crearImagen();
        return false;
    },
    
    /**
     * 
     * @param {string} hash de la imagen del mapa en cache
     * @param {int} id identificador emergencia
     * @returns {undefined}
     */
    generarPdf : function(hash, id){  
        window.open(siteUrl + 'emergencia_reporte/pdf/id/' + id + '/hash/' + hash, "_blank");
    },
    
    /**
     * Muestra el formulario en popoup
     * @returns {undefined}
     */
    mostrar : function(){
        var yo = this;
        
        bootbox.dialog({
            title: "Emergencia <i class=\"fa fa-arrow-right\"></i> Reporte",
            className: "modal90",
            message: "<div id=\"contenido-popup-reporte\"><div class=\"row text-center\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div></div>",
            buttons: {
                email: {
                    label: "<i class=\"fa fa-envelope-o\"></i> Enviar email",
                    className: "btn-success",
                    callback: function (e) {
                        var boton = e.currentTarget;
                        $(boton).children("i").removeClass("fa-envelope-o");
                        $(boton).children("i").addClass("fa-spin fa-spinner");
                        var retorno = yo.enviarCorreo(boton);
                        
                        return retorno;
                    }
                },
                reporte: {
                    label: "<i class=\"fa fa-file\"></i> Ver reporte",
                    className: "btn-warning",
                    callback: function (e) {
                        var boton = e.currentTarget;
                        $(boton).children("i").removeClass("fa-file");
                        $(boton).children("i").addClass("fa-spin fa-spinner");
                        
                        var retorno = yo.mostrarReporte();
                        
                        $(boton).children("i").addClass("fa-file");
                        $(boton).children("i").removeClass("fa-spin fa-spinner");
                        return retorno;
                    }
                },
                danger: {
                    label: "<i class=\"fa fa-close\"></i> Cerrar",
                    className: "btn-white"
                }
            }

        });

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "emergencia_reporte/index/id/"+ yo.id_emergencia, 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("#contenido-popup-reporte").html(html);
                

                setInputCorreos("destinatario", $("#id").val());
              
            }
        });
    }
});


