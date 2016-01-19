var EmergenciaReporteForm = Class({
    
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    mostrarReporte : function(){
        var imagen = new EmergenciaReporteMapaImagen("mapa");
        imagen.addOnReadyFunction("carga pdf", this.generarPdf, this.id_emergencia);
        imagen.crearImagen();
        return false;
    },
    
    generarPdf : function(hash, id){  
        window.open(siteUrl + 'emergencia_reporte/pdf/id/' + id + '/hash/' + hash, "_blank");
    },
    
    mostrar : function(){
        var yo = this;
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "emergencia_reporte/index/id/"+ yo.id_emergencia, 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                bootbox.dialog({
                    title: "Emergencia <i class=\"fa fa-arrow-right\"></i> Reporte",
                    className: "modal90",
                    message: html,
                    buttons: {
                        reporte: {
                            label: "<i class=\"fa fa-envelope-o\"></i> Ver reporte",
                            className: "btn-warning",
                            callback: function () {
                                return yo.mostrarReporte();
                            }
                        },
                        danger: {
                            label: "<i class=\"fa fa-close\"></i> Cerrar",
                            className: "btn-white"
                        }
                    }

                });
            }
        });
    }
});


