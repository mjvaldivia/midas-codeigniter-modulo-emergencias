var EventoReporteMapaImagen = Class({
    
    /**
     * Contenedor del mapa
     */
    div : null,
    
    /**
     * Funciones que se ejecutan
     * despues de sacar foto del mapa
     */
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
        
        var transform=$(".gm-style>div:first>div").css("transform")
        var comp=transform.split(",") //split up the transform matrix
        var mapleft=parseFloat(comp[4]) //get left value
        var maptop=parseFloat(comp[5])  //get top value
        $(".gm-style>div:first>div").css({ //get the map container. not sure if stable
          "transform":"none",
          "left":mapleft,
          "top":maptop,
        });
        
        
        html2canvas($('#' +  yo.div),
        {
            proxy : baseUrl + "html2canvas.proxy.php",
            useCORS: true,
            onrendered: function(canvas)
            {
                var dataUrl = canvas.toDataURL("image/jpg");
                var img = dataUrl.replace(/^data:image\/(png|jpg);base64,/, "");
                
                var temp_hash = yo.crearImagenTemporal(img);
                
                $(".gm-style>div:first>div").css({
                    left:0,
                    top:0,
                    "transform":transform
                });
                
                //ejecuta funciones despues de generar imagen temporal
                $.each(yo.on_ready_functions, function(i, funcion){
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


