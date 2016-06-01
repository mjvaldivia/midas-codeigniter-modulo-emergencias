//lista de capas cargadas en el visor
capas_visor = [];

var MapaCapa = Class({
    
    mapa : null,
    capas : {},
    bo_capas_cargadas : false,
    
    //elementos
    class_linea : null,
    class_multilinea : null,
    class_marcador : null,
    class_poligono : null,
    class_multipoligono : null,
    
    //identificador de la emergencia
    id_emergencia : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.class_linea = new MapaLinea();
        this.class_multilinea = new MapaLineaMulti();
        this.class_marcador = new MapaMarcador();
        this.class_poligono = new MapaPoligono();
        this.class_multipoligono = new MapaPoligonoMulti();
    },
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
        
        this.class_marcador.seteaMapa(mapa);
        this.class_poligono.seteaMapa(mapa);
        this.class_multipoligono.seteaMapa(mapa);
        this.class_linea.seteaMapa(mapa);
        this.class_multilinea.seteaMapa(mapa);
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
    
    /**
     * Añade elemento al mapa
     * @param {googleMap} mapa
     * @param {int} id_elemento
     * @returns {undefined}
     */
    addElemento : function(mapa, id_elemento){
        this.seteaMapa(mapa);
        var yo = this;        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_elemento,
            type: "post",
            url: siteUrl + "mapa/ajax_elemento", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    yo.elemento(
                            data.resultado.id, 
                            "",
                            data.resultado.geojson, 
                            data.resultado.propiedades, 
                            data.resultado.id_subcapa, 
                            data.resultado.zona, 
                            data.resultado.icono, 
                            data.resultado.color
                    );
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        });
    },
    
    /**
     * Añade una capa por el identificador
     * @param {type} mapa
     * @param {type} id_subcapa
     * @returns {undefined}
     */
    addCapaPorId : function(mapa, id_subcapa){
        this.class_marcador.seteaMapa(mapa);
        this.class_poligono.seteaMapa(mapa);
        this.class_multipoligono.seteaMapa(mapa);
        this.class_multilinea.seteaMapa(mapa);
        this.addCapa(id_subcapa);
    },
        
    /**
     * Añade una capa al visor
     * @param {int} id_capa
     * @returns {void}
     */
    addCapa : function(id_subcapa){
        var tareas = new MapaLoading();
        var yo = this;
        tareas.push(1);
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + id_subcapa + "&id_emergencia=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa_capas/ajax_carga_capa", 
            success:function(data){
                if(data.correcto){
                    if(($.isEmptyObject(yo.capas[id_subcapa]))){
                        yo.capas[id_subcapa] = data.capa;
                        yo.cargaCapa(id_subcapa, data.capa);
                        yo.listaCapasVisor();
                    }
                }
                tareas.remove(1);
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
        
        capas_visor = jQuery.grep(capas_visor, function( a ) {
            if(a["id"] != id_capa){
                return true;
            }
        });
        
        this.listaCapasVisor();
    },
    
    /**
     * 
     * @param {google_maps} mapa
     * @returns {void}
     */
    cargaCapas : function(mapa){
        this.class_linea.seteaMapa(mapa);
        this.class_multilinea.seteaMapa(mapa);
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
            yo.elemento(data.id, data.nombre, data.geojson, data.propiedades, id_subcapa, capa.zona, capa.icono, capa.color);
            i++;
        });
                
        var arr = jQuery.grep(capas_visor, function( a ) {
            if(a["id"] == id_subcapa){
                return true;
            }
        });
        
        if(arr.length == 0){
            
            var preview = "";
            if(capa.icono != ""){
                preview = "<img style=\"height:20px\" src=\"" + capa.icono + "\" >";
            } else {
                if(capa.color != ""){
                    preview = "<div class=\"color-capa-preview\" style=\"background-color:" + capa.color + "; height: 20px;width: 20px; margin-left:9px\"></div>";
                }
            }
            
            capas_visor.push({"id" : id_subcapa ,
                              "nombre" : capa.nombre,
                              "preview" : preview});
        }
        
    },
    
    /**
     * 
     * @returns {undefined}
     */
    listaCapasVisor : function(){
        var html = "";
        var cantidad = 0;
       
        $.each(capas_visor, function(i, data){
           
           if(i!=0){
               html += "<li class=\"divider\"></li>";
           } 
           
           html += "<li data=\"" + data.id + "\" class=\"\">\n"
                 + "<div class=\"row\"><div class=\"col-xs-2\">" + data.preview + "</div><div class=\"col-xs-10\"> " + data.nombre + "</div>"
                 + "</div>\n"
                 + "</li>";
           
           
           cantidad++;
        });
        
        
        $("#cantidad_capas_agregadas").html(cantidad);
 
        if(cantidad > 0){
            $("#cantidad_capas_agregadas").addClass("alert-success");
        } else {
            $("#cantidad_capas_agregadas").removeClass("alert-success");
        }
        
        $("#lista_capas_agregadas").html(html);
    },
    
    
    
    /**
     * Añade elemento
     * @param {array} geometry
     * @param {string} zona
     * @param {string} icono
     * @param {string} color
     * @returns {void}
     */
    elemento : function(id, nombre, geometry, propiedades, subcapa, zona, icono, color){
        var yo = this;
        switch (geometry.type) {
            case "LineString":
                yo.class_linea.dibujarLinea(id, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
            case "MultiLineString":
                yo.class_multilinea.dibujarLinea(id, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
            case "Point":
                yo.class_marcador.posicionarMarcador(id,
                                                     subcapa,
                                                     geometry.coordinates[0], 
                                                     geometry.coordinates[1], 
                                                     propiedades,
                                                     zona, 
                                                     icono);
                break;
            case "Polygon":
                yo.class_poligono.dibujarPoligono(id, nombre, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
            case "MultiPolygon":
                yo.class_multipoligono.dibujarPoligono(id, nombre, subcapa, geometry.coordinates, propiedades, zona, color);
                break;
        }
        
        
    },
    
    /**
     * Carga las capas asociadas a la emergencia
     * @param {int} id_emergencia
     * @returns {void}
     */
    capasPorEmergencia : function(map){
        var tareas = new MapaLoading();
        
        var yo = this;
        tareas.push(1);
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa_capas/ajax_contar_capas_comuna", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                tareas.remove(1);
                if(data.cantidad > 0){
                    tareas.push(1);
                    $.ajax({        
                        dataType: "json",
                        cache: false,
                        async: true,
                        data: "id=" + yo.id_emergencia,
                        type: "post",
                        url: siteUrl + "mapa_capas/ajax_capas_comuna_emergencia", 
                        error: function(xhr, textStatus, errorThrown){
                            notificacionError("Ha ocurrido un problema", errorThrown);
                        },
                        success:function(data){
                            if(data.correcto){
                                yo.capas = data.resultado.capas;
                                yo.cargaCapas(map);
                                yo.listaCapasVisor();
                            } else {
                                notificacionError("Ha ocurrido un problema", data.error);
                            }
                            tareas.remove(1);
                        }
                    });
                }
            }
        });
    }
});


