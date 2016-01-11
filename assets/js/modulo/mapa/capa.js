var MapaCapa = Class({
    
    capas : {},
    class_marcador : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.class_marcador = new MapaMarcador();
    },
    
    /**
     * Retorna lista de identificadores de capas
     * cargadas en visor
     * @returns {array}
     */
    retornaIdCapas : function(){
        var lista_capas = {};
        var i = 0;
        
        $.each(this.capas, function(id_capa, capa){
            lista_capas[i] = id_capa;
            i++;
        });
        return lista_capas;
    },
    
    /**
     * Añade una capa al visor
     * @param {int} id_capa
     * @returns {void}
     */
    addCapa : function(id_capa){
        var yo = this;
        console.log(yo.capas);
        console.log("Agregando capa " + id_capa);
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_capa,
            type: "post",
            url: siteUrl + "mapa/ajax_capa", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    if(($.isEmptyObject(yo.capas[id_capa]))){
                        console.log("Cargando nueva capa " + id_capa);
                        yo.capas[id_capa] = data.capa;
                        yo.cargaCapa(id_capa, data.capa);
                    }
                }
            }
        });
    },
    
    /**
     * Quita una capa del visor
     * @param {int} id_capa
     * @returns {void}
     */
    removeCapa : function(id_capa){
        console.log("Quitando capa " + id_capa);
        this.class_marcador.removerMarcadores("capa", id_capa);
        delete(this.capas[id_capa]);
    },
    
    /**
     * 
     * @param {google_maps} mapa
     * @returns {void}
     */
    cargaCapas : function(mapa){
        
        this.class_marcador.seteaMapa(mapa);
       
        var yo = this;
        $.each(this.capas, function(id_capa, capa){
           yo.cargaCapa(id_capa, capa);
        });
    },
    
    /**
     * Carga una capa
     * @param {int} id_capa
     * @param {object} capa
     * @returns {void}
     */
    cargaCapa : function(id_capa, capa){
        var yo = this;
        var i = 0;
        $.each(capa.json.features, function(id_feature, feature){
            if(feature.type == "Feature"){
                yo.elemento(feature.geometry, id_capa, capa.zona, capa.icono, capa.color);
                i++;
            } 
        });
    },
    
    /**
     * Añade elemento
     * @param {array} geometry
     * @param {string} zona
     * @param {string} icono
     * @param {string} color
     * @returns {void}
     */
    elemento : function(geometry, capa, zona, icono, color){
        var yo = this;
        switch (geometry.type) {
            case "Point":
                yo.class_marcador.posicionarMarcador(capa,
                                                     geometry.coordinates[0], 
                                                     geometry.coordinates[1], 
                                                     zona, 
                                                     icono);
                break;
        }
    },
    
    /**
     * Carga las capas asociadas a la emergencia
     * @param {int} id_emergencia
     * @returns {void}
     */
    capasPorEmergencia : function(id_emergencia){
        console.log("Cargando informacion de capas asociadas a emergencia");
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_capas_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    yo.capas = data.resultado.capas;
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        });
    }
});


