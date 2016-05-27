var lista_kml = [];

var MapaArchivos = Class({
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
      this.mapa = mapa;  
    },
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    updateListaArchivosAgregados : function(){
        var kml = this.listArchivosKml();
                
        var html = "";
        var cantidad = 0;
       
        var lista = kml;
     
        $.each(lista, function(i, json){ 
            
           if(i!=0){
               html += "<li class=\"divider\"></li>";
           } 
            
           html += "<li data=\"" + json.hash + "\" class=\"\">\n"
                 
                 + "<div class=\"row\">"
                 + "<div class=\"col-xs-2 text-center\"><input checked=\"checked\" name=\"archivos_importados_ocultos[]\" class=\"ocultar-archivo-importado\" type=\"checkbox\" value=\"" + json.id + "\" data-rel=\"" + json.hash + "\"/></div>\n"
                 + "<a href=\"#\" data-hash=\"" + json.hash + "\" data-rel=\"" + json.id + "\" class=\"ver-detalle-archivo\">"
                 + "<div class=\"col-xs-2\">(" + json.tipo + ")</div>\n"
                 + "<div class=\"col-xs-4\"> " + json.nombre + "</div>"
                 + "<div class=\"col-xs-4\"> " + json.archivo + "</div>"
                 + "</a>"
                 + "</div>"
                 + "</li>";
         
           cantidad++;
        });
        
        
        $("#cantidad_elementos_importados").html(cantidad);
 
        if(cantidad > 0){
            $("#cantidad_elementos_importados").addClass("alert-success");
        } else {
            $("#cantidad_elementos_importados").removeClass("alert-success");
        }

        $("#lista_importados_agregados").html(html);
        
        this.bindCheckVisualizar();
        
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindCheckVisualizar : function(){
        var yo = this;
        $(".ocultar-archivo-importado").livequery(function(){
           $(this).unbind("click");
           $(this).click(function(){
                var hash = $(this).attr("data-rel"); 
                if($(this).is(":checked")){
                    yo.ocultarMostrarElementos(hash, true);
                } else {
                    yo.ocultarMostrarElementos(hash, false);
                }
           });
        });
    },
    
    /**
     * 
     * @param {type} hash
     * @param {type} mostrar
     * @returns {undefined}
     */
    ocultarMostrarElementos : function(hash, mostrar){
        var $this = this;
        jQuery.grep(lista_markers, function( a ) {
            if(a["identificador"] == "kml_" + hash ){
                if(mostrar){
                    a.setVisible(true);
                } else {
                    a.setVisible(false);
                }
            }
        });
        jQuery.grep(lista_poligonos, function( a ) {
            if(a["identificador"] == "kml_" + hash){
                if(mostrar){
                    a.setMap($this.mapa);
                } else {
                    a.setMap(null);
                }
            }
        });
    },
    
     /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listArchivosKml : function(){
        var lista = {};
        $.each(lista_kml, function(i, kml){
            lista[i] = {"id" : kml.id,
                        "hash" : kml.hash,
                        "tipo" : kml.tipo,
                        "archivo" : kml.archivo,
                        "nombre" : kml.nombre};
        });
        return lista;
    },
    
    quitarElementos : function(hash){
        
    },
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadArchivos : function(mapa){
        
        var tareas = new MapaLoading();
        tareas.push(1);
        var yo = this;
        this.mapa = mapa;
        $.ajax({         
           dataType: "json",
           cache: false,
           async: true,
           data: "id=" + yo.id_emergencia,
           type: "post",
           url: siteUrl + "mapa_kml/ajax_contar_kml_emergencia", 
           error: function(xhr, textStatus, errorThrown){
               notificacionError("Ha ocurrido un problema - ", errorThrown);
           },
           success:function(data){
               tareas.remove(1);
               if(data.cantidad>0){
                   tareas.push(1);
                   $.ajax({         
                       dataType: "json",
                       cache: false,
                       async: true,
                       data: "id=" + yo.id_emergencia,
                       type: "post",
                       url: siteUrl + "mapa_kml/ajax_kml_emergencia", 
                       error: function(xhr, textStatus, errorThrown){
                           notificacionError("Ha ocurrido un problema", errorThrown);
                       },
                       success:function(data){
                           if(data.correcto){
                               $.each(data.resultado.elemento, function(id, elemento){
                                   if(elemento.tipo == "KMZ" || elemento.tipo == "KML"){
                                       
                                        $.each(elemento.elementos, function(i, row){
                                            var coordenadas = jQuery.parseJSON(row.coordenadas);
                                            
                                            if(row["tipo"] == "PUNTO"){
                                                var marcador = new MapaKmlImportarMarcador();
                                                marcador.seteaMapa(mapa);
                                                marcador.seteaClavePrimaria(elemento.id);
                                                marcador.posicionarMarcador(
                                                        "kml_" + elemento.hash, 
                                                        null, 
                                                        coordenadas.lat, 
                                                        coordenadas.lon, 
                                                        {"NOMBRE" : row.nombre,
                                                         "TIPO" : elemento.nombre}, 
                                                        row.propiedades, 
                                                        baseUrl + row.icono
                                               );
                                            } 
                                           
                                            if(row["tipo"] == "MULTIPOLIGONO"){
                                               
                                                var poligono = new MapaPoligonoMulti();
                                                poligono.seteaMapa(mapa);
                                                poligono.seteaClavePrimaria(elemento.id);
                                                poligono.dibujarPoligono(
                                                    "kml_" + elemento.hash,
                                                    row.nombre, 
                                                    null,
                                                    coordenadas, 
                                                    {"NOMBRE" : row.nombre,
                                                    "TIPO" : elemento.nombre},
                                                    null, 
                                                    row.color);
                                            }
                                            
                                            if(row["tipo"] == "POLIGONO"){
                                               
                                                var poligono = new MapaPoligono();
                                               // poligono.seteaCustom(true);
                                                poligono.seteaMapa(mapa);
                                                poligono.seteaClavePrimaria(elemento.id);
                                                poligono.dibujarPoligono(
                                                    "kml_" + elemento.hash,
                                                    row.nombre, 
                                                    null,
                                                    coordenadas, 
                                                    {"NOMBRE" : row.nombre,
                                                    "TIPO" : elemento.nombre},
                                                    null, 
                                                    row.color);
                                            }
                                            
                                            if(row["tipo"] == "LINEA"){
                                                var linea = new MapaLineaMulti();
                                                linea.seteaClavePrimaria(elemento.id);
                                                linea.seteaMapa(mapa);
                                                linea.dibujarLinea(
                                                    "kml_" + elemento.hash,
                                                    null, 
                                                    coordenadas.linea, 
                                                    {"NOMBRE" : row.nombre},
                                                    null,
                                                    row.color);
                                            }
                                        });
                                       
                                        kml = {
                                            "id" : elemento.id,
                                            "tipo" : elemento.tipo,
                                            "hash" : elemento.hash,
                                            "nombre" : elemento.nombre, 
                                            "archivo" : elemento.archivo
                                        };            
                                        
                                        lista_kml.push(kml);
                                    }
                                    
                                    if(elemento.oculto){
                                        yo.ocultarMostrarElementos(elemento.hash, false);
                                        $(".ocultar-archivo-importado[value='" + elemento.id + "']").waitUntilExists(function(){
                                            $(this).prop("checked", false);
                                        });
                                    }
                                    
                               });
                               
                                if($("#lista_importados_agregados").length > 0){
                                    yo.updateListaArchivosAgregados();
                                }
                           }
                           tareas.remove(1);
                       }
                   });
               }
               
               
           }
       });
        
        
        
       
    }
});

