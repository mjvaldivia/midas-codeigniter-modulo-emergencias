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
           if(i == 0){
               html += "<li class=\"\">\n"
                 + "<div class=\"row\">"
                 + "<div class=\"col-xs-1\"></div>\n"
                 + "<div class=\"col-xs-2 badge alert-info\">Tipo archivo</div>\n"
                 + "<div class=\"col-xs-4 badge alert-info\">Descripción</div>"
                 + "<div class=\"col-xs-4 badge alert-info\">Nombre</div>"
                 + "<div class=\"col-xs-1 badge alert-info\"></div>"
                 + "</div>"
                 + "</li>";
           } 
            
           html += "<li data=\"" + json.hash + "\" class=\"\">\n"
                 + "<div class=\"row\">"
                 + "<div class=\"col-xs-1\"><input checked=\"checked\" class=\"ocultar-archivo-importado\" type=\"checkbox\" data-rel=\"" + json.hash + "\"/></div>\n"
                 + "<div class=\"col-xs-2\">(" + json.tipo + ")</div>\n"
                 + "<div class=\"col-xs-4\"> " + json.nombre + "</div>"
                 + "<div class=\"col-xs-4\"> " + json.archivo + "</div>"
                 + "<div class=\"col-xs-1\"><button data-rel=\"" + json.hash + "\" title=\"Quitar archivo\" class=\"btn btn-xs btn-danger btn-quitar-archivo\"> <i class=\"fa fa-remove\"></i></button></div>"
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
                    jQuery.grep(lista_markers, function( a ) {
                        if(a["identificador"] == "kml_" + hash ){
                            a.setVisible(true);
                        }
                    });
                    jQuery.grep(lista_poligonos, function( a ) {
                        if(a["identificador"] == "kml_" + hash){
                            a.setMap(yo.mapa);
                        }
                    });
                } else {
                    jQuery.grep(lista_markers, function( a ) {
                        if(a["identificador"] == "kml_" + hash ){
                            a.setVisible(false);
                        }
                    });
                    jQuery.grep(lista_poligonos, function( a ) {
                        if(a["identificador"] == "kml_" + hash){
                            a.setMap(null);
                        }
                    });
                }
           });
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
               if(data.cantidad>0){
                   Messenger().run({
                       action: $.ajax,
                       showCloseButton: true,
                       successMessage: '<strong> KML </strong> <br> Ok',
                       errorMessage: '<strong> KML </strong> <br> Se produjo un error al cargar',
                       progressMessage: '<strong> KML </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
                   }, {         
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
                                                poligono.seteaMapa(mapa);
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
                               });
                               yo.updateListaArchivosAgregados();
                           }
                       }
                   });
               }
               
               
           }
       });
        
        
        
       
    }
});

