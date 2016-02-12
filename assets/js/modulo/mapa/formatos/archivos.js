var lista_kml = [];

var MapaArchivos = Class({
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
    updateListaArchivosAgregados : function(){
        var kml = this.listArchivosKml();
                
        var html = "";
        var cantidad = 0;
       
        var lista = kml;
       

       
        $.each(lista, function(i, json){
            
           if(i == 0){
               html += "<li data=\"" + json.id + "\" class=\"\">\n"
                 + "<div class=\"row\">"
                 + "<div class=\"col-xs-3 badge alert-info\">Tipo archivo</div>\n"
                 + "<div class=\"col-xs-4 badge alert-info\">Descripción</div>"
                 + "<div class=\"col-xs-4 badge alert-info\">Nombre</div>"
                 + "<div class=\"col-xs-1 badge alert-info\"></div>"
                 + "</div>"
                 + "</li>";
           } 
            
           html += "<li data=\"" + json.id + "\" class=\"\">\n"
                 + "<div class=\"row\">"
                 + "<div class=\"col-xs-3\">(" + json.tipo + ")</div>\n"
                 + "<div class=\"col-xs-4\"> " + json.nombre + "</div>"
                 + "<div class=\"col-xs-4\"> " + json.archivo + "</div>"
                 + "<div class=\"col-xs-1\"><button date-rel=\"" + json.id + "\" title=\"Quitar archivo\" class=\"btn btn-xs btn-danger btn-quitar-archivo\"> <i class=\"fa fa-remove\"></i></button></div>"
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
                        "nombre" : kml.nombre,
                        "file" : kml.url};
        });
        return lista;
    },
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadArchivos : function(mapa){
        var yo = this;

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
                                        var kmzLayer = new google.maps.KmlLayer( siteUrl + "mapa_kml/kml/id/" + elemento.id + "/file." + elemento.tipo,{
                                            suppressInfoWindows: false,
                                            preserveViewport: true
                                        });
                                        kmzLayer.setMap(mapa);
                                        kmzLayer.id = elemento.id;
                                        kmzLayer.archivo = elemento.archivo;
                                        kmzLayer.nombre = elemento.nombre;
                                        kmzLayer.tipo = elemento.tipo;
                                        lista_kml.push(kmzLayer);
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

