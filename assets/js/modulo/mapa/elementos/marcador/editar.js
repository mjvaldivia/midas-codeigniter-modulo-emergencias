var MapaMarcadorEditar = Class({  
    
    marker : null,
    
    seteaMarker : function(marker){
        this.marker = marker;
    },
    
    clickListener : function(){
        var yo = this;
        this.marker.addListener('rightclick', function(event) {
            var parametros = {"html" : yo.marker.html,
                              "icono" : yo.marker.getIcon(),
                              "propiedades" : yo.marker.informacion};
            
            bootbox.dialog({
                message: "<div id=\"contenido-popup\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Datos del marcador",
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
                url: siteUrl + "mapa/popup_marcador_editar", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup").html(data);
                    
                    CKEDITOR.config.scayt_autoStartup = true;
                    CKEDITOR.config.scayt_sLang = "es_ES";
                    CKEDITOR.config.extraPlugins = 'justify';
                    CKEDITOR.replace( "texto-marcador" );
                }
            }); 
        });
    }
});


