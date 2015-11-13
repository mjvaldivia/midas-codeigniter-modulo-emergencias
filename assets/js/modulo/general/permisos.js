var Permisos = Class({
    
    /**
     * Permisos
     */
    ver : true,
    nuevo: true,
    editar : true,
    eliminar : true,
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(modulo) {
        this.setPermisoEdicion(modulo);    
    },
    
    /**
     * Ve si el usuario tiene permisos de edicion
     * @param string modulo modulo del sistema (alarma, emergencia, capas, etc.)
     * @param string accion accion a realizar (nuevo, editar, ver, eliminar)
     * @returns void
     */
    setPermisoEdicion : function(modulo){
        
        var yo = this;
        
        var parametros = {"modulo" : modulo};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "session/json_puede_editar", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto){
                    yo.ver = data.ver;
                    yo.nuevo = data.nuevo;
                    yo.editar = data.editar;
                    yo.eliminar = data.eliminar;
                }
            }
        });
        
    }
});


