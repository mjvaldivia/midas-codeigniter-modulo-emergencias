var EmergenciaReporteForm = Class({
    
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
     * Carga el reporte
     * @returns {Boolean}
     */
    mostrarReporte : function(){
        var imagen = new EmergenciaReporteMapaImagen("mapa");
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
                        
                    }
                },
                reporte: {
                    label: "<i class=\"fa fa-file\"></i> Ver reporte",
                    className: "btn-warning",
                    callback: function (e) {
                        console.log(e);
                        return yo.mostrarReporte();
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
            }
        });
    }
});


