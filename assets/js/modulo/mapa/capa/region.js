var MapaCapaRegion = Class({ extends : MapaCapa}, {
    
    
    
    
    addCapa : function(mapa){
        var yo = this;
        
        this.class_marcador.seteaMapa(mapa);
        this.class_poligono.seteaMapa(mapa);
        this.class_multipoligono.seteaMapa(mapa);
        this.class_multilinea.seteaMapa(mapa);
        
        console.log("Agregando region");
        
        Messenger().run({
            action: $.ajax,
            successMessage: 'Capa de region cargada correctamente',
            errorMessage: 'Error al cargar capa',
            progressMessage: '<i class=\"fa fa-spin fa-spinner\"></i> Cargando capa de region...'
        }, {
            dataType: "json",
            cache: false,
            async: true,
            data: "id_emergencia=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa_capas/ajax_carga_capa_region", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                if(data.correcto){
                
                    $.each(data.capa, function(i, capa){
                        console.log("Cargando capa regiones ");
                        yo.cargaCapa("region", capa);
                        yo.listaCapasVisor();
                    });
                    
                }
            }
        });
    },
    
    /**
     * Quita una capa del visor
     * @param {int} id_capa
     * @returns {void}
     */
    removeCapa : function(){
        this.super("removeCapa", "region");
    }
});


