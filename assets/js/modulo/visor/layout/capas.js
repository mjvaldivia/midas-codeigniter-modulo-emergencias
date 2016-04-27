var VisorLayoutCapas = Class({ extends : MapaLayoutCapas}, {
    
    /**
     * 
     * @returns {undefined}
     */
    callCapas : function(){
        var yo = this;
        
        var parametros = {"id" : $("#regiones").val()};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "POST",
            url:  siteUrl + "visor/ajax_capas_region", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                yo.renderCategorias(data.lista);
            }
        });
    }
});


