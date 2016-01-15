var MapaCapa = Class({
    
    capas : {},
    bo_capas_cargadas : false,
    class_marcador : null,
    class_poligono : null,
    class_multipoligono : null,
    id_emergencia : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.class_marcador = new MapaMarcador();
        this.class_poligono = new MapaPoligono();
        this.class_multipoligono = new MapaPoligonoMulti();
    },
    
    /**
     * 
     * @param {type} id
     * @returns {undefined}
     */
    emergencia : function(id){
        this.id_emergencia = id;
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
            if(!($.isEmptyObject(capa))){
                lista_capas[i] = id_capa;
                i++;
            }
        });
        return lista_capas;
    },
    
    addCapaPorId : function(mapa, id_subcapa){
        this.class_marcador.seteaMapa(mapa);
        this.class_poligono.seteaMapa(mapa);
        this.class_multipoligono.seteaMapa(mapa);
        this.addCapa(id_subcapa);
    },
    
    /**
     * Añade una capa al visor
     * @param {int} id_capa
     * @returns {void}
     */
    addCapa : function(id_subcapa){
        var yo = this;
        
        console.log(yo.capas);
        console.log("Agregando Sub-Capa " + id_subcapa);
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_subcapa + "&id_emergencia=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_capa", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto){
                    if(($.isEmptyObject(yo.capas[id_subcapa]))){
                        console.log("Cargando nueva capa " + id_subcapa);
                        yo.capas[id_subcapa] = data.capa;
                        yo.cargaCapa(id_subcapa, data.capa);
                    }
                }
                console.log(yo.capas);
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
        this.class_poligono.removerPoligono("capa", id_capa);
        delete(this.capas[id_capa]);
    },
    
    /**
     * 
     * @param {google_maps} mapa
     * @returns {void}
     */
    cargaCapas : function(mapa){
        
        this.class_marcador.seteaMapa(mapa);
        this.class_poligono.seteaMapa(mapa);
        this.class_multipoligono.seteaMapa(mapa);
        
        var yo = this;
        
        $.each(this.capas, function(id_capa, capa){
            yo.cargaCapa(id_capa, capa);
        });
        
        this.bo_capas_cargadas = true;
    },
    
    /**
     * Carga una capa
     * @param {int} id_subcapa
     * @param {object} capa
     * @returns {void}
     */
    cargaCapa : function(id_subcapa, capa){
        var yo = this;
        var i = 0;
        
        $.each(capa.json, function(id, data){
            
            yo.elemento(data.id, data.geojson, data.propiedades, id_subcapa, capa.zona, capa.icono, capa.color);
            i++;
            
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
    elemento : function(id, geometry, propiedades, subcapa, zona, icono, color){
       
        var yo = this;
        switch (geometry.type) {
            case "Point":
                yo.class_marcador.posicionarMarcador(subcapa,
                                                     geometry.coordinates[0], 
                                                     geometry.coordinates[1], 
                                                     propiedades,
                                                     zona, 
                                                     icono);
                break;
            case "Polygon":
                yo.class_poligono.dibujarPoligono(id, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
            case "MultiPolygon":
                yo.class_multipoligono.dibujarPoligono(id, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
        }
    },
    
    /**
     * Carga las capas asociadas a la emergencia
     * @param {int} id_emergencia
     * @returns {void}
     */
    capasPorEmergencia : function(map){
        console.log("Cargando informacion de capas asociadas a emergencia");
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_capas_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    //if(data.resultado.capas.lenght > 0){
                        yo.capas = data.resultado.capas;
                        yo.cargaCapas(map);
                    //}
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        });
    }
});


