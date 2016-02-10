var EmergenciaReporteMapaImagen = Class({
    
    div : null,
    on_ready_functions : {},
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function(div) {
        this.div = div;
    },
    
     /**
     * Añade funciones a ejecutar cuando la imagen esta cargada
     * @param {string} index identificador de la funcion para debug
     * @param {function} funcion funcion a ejecutar
     * @returns {void}
     */
    addOnReadyFunction : function(index, funcion, parametros){
        this.on_ready_functions[index] = {"funcion" : funcion,
                                          "parametros" : parametros};
    },
    
    /**
     * Captura imagen del mapa
     * @returns {undefined}
     */
    crearImagen : function(){
        var yo = this;
        
        html2canvas($('#' +  yo.div),
        {
            proxy : baseUrl + "emergencias/html2canvas.proxy.php",
            useCORS: true,
            onrendered: function(canvas)
            {
                var dataUrl = canvas.toDataURL("image/jpg");
                var img = dataUrl.replace(/^data:image\/(png|jpg);base64,/, "");
                
                var temp_hash = yo.crearImagenTemporal(img);
                
                //ejecuta funciones despues de generar imagen temporal
                $.each(yo.on_ready_functions, function(i, funcion){
                    console.log("Carga de " + i);
                    funcion.funcion(temp_hash, funcion.parametros);
                });
            }
        });
    },
    
    /**
     * Guarda captura en archivo temporal
     * @param {type} img
     * @returns {Array.hash|currentData.hash}
     */
    crearImagenTemporal : function(img){
        var data = {"imagen" : img};
        
        var temp_hash = null;
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: data,
            type: "post",
            url: siteUrl + "emergencia_reporte/ajax_mapa_imagen", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                   temp_hash = data.hash;
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        });
        
        return temp_hash;
    }
});


