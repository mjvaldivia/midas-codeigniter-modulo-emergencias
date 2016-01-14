var MapaInformacionElemento = Class({ 
    
    /**
     * Levanta popup con la informacion del poligono
     * @param {object} marcadores
     * @returns {void}
     */
    popupInformacion : function(marcadores, elemento){
        var parametros = {"marcadores" : marcadores,
                          "informacion" : elemento.informacion};
            
        if(elemento.capa != null){
            parametros["capa"] = elemento.capa;
        }    
            
        bootbox.dialog({
                message: "<div id=\"contenido-popup-informacion-capas\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Datos del elemento",
                className: "modal90",
                buttons: {
                    cerrar: {
                        label: " Cerrar ventana",
                        className: "btn-white fa fa-close",
                        callback: function() {}
                    }
                }
        });

        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa/popup_poligono_informacion", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                $("#contenido-popup-informacion-capas").html(data);
            }
        }); 
    },
});


