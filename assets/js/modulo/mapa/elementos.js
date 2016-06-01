var MapaElementos = Class({
    
    /**
     * googleMap
     */
    mapa : null,
    
    /**
     * Id de la emergencia actual
     */
    id_emergencia : null,
    
    /**
     * Si esta habilitado o no el popup
     * con informacion del poligono
     */
    bo_informacion_poligonos : true,
    
    on_load_functions : {},
    
     /**
     * Añade funciones a ejecutar cuando el mapa esta cargado
     * @param {string} index identificador de la funcion para debug
     * @param {function} funcion funcion a ejecutar
     * @returns {void}
     */
    addOnLoadFunction : function(index, funcion, parametros){
        this.on_load_functions[index] = {"funcion" : funcion,
                                          "parametros" : parametros};
    },
    

    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    emergencia : function(id){
        this.id_emergencia = id;
    },
    
    /**
     * Parche para corregir mapa en reporte
     * @returns {elementosAnonym$0.controlador.controller|String}
     */
    getController : function(){
      var controller = getController();  
      if(controller == "mapa" || controller == "mapa_publico"){
          return controller;
      } else {
          return "mapa";
      }
    },
    
    /**
     * Habilita o no popup con datos de poligono 
     */
    seteaPopupPoligono : function(booleano){
        this.bo_informacion_poligonos = booleano;
    },
    
    /**
     * 
     * @param {type} id
     * @param {type} propiedades
     * @param {type} coordenadas
     * @param {type} color
     * @returns {undefined}
     */
    dibujarLinea : function(id, propiedades, coordenadas, color){
        var yo = this;
        var linea = new google.maps.Polyline({
            custom : true,
            path: coordenadas,
            identificador: id,
            clave : "linea_" + id,
            informacion: propiedades,
            tipo: "LINEA",
            geodesic: true,
            editable: true,
            strokeColor: "#000",
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        linea.setMap(yo.mapa);
        
        lista_poligonos.push(linea);
    },
    
    /**
     * 
     * @param {type} id
     * @param {type} clave
     * @param {type} propiedades
     * @param {type} coordenadas
     * @param {type} icono
     * @returns {undefined}
     */
    dibujarMarcador : function(id, clave, propiedades, coordenadas, icono){
        var yo = this;
        var posicion = new google.maps.LatLng(parseFloat(coordenadas.lat), parseFloat(coordenadas.lng));

        var marker = new google.maps.Marker({
            id : id,
            tipo : "PUNTO",
            position: posicion,
            identificador: id,
            clave : clave,
            capa: null,
            custom: true,
            informacion : propiedades,
            draggable: true,
            map: yo.mapa,
            icon: icono
        });  
        
        var click = new MapaMarcadorEditar();
        click.seteaMarker(marker);
        click.clickListener();
        
        var elemento_marcador = new MapaMarcador();
        elemento_marcador.seteaMapa(yo.mapa);
        elemento_marcador.informacionMarcador(marker);
        
        lista_markers.push(marker);
    },
    
    /**
     * Dibuja poligono
     * @param {type} id
     * @param {type} propiedades
     * @param {type} coordenadas
     * @param {type} color
     * @returns {undefined}
     */
    dibujarPoligono : function(id, propiedades, coordenadas, color){
        var poligono = new google.maps.Polygon({
            paths: coordenadas,
            id : id,
            custom : true,
            tipo : "POLIGONO",
            identificador: null,
            clave : "elemento_" + id,
            capa: null,
            informacion: propiedades,
            clickable: true,
            editable: false,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            popup_poligono: this.bo_informacion_poligonos
        });
        
        poligono.setMap(this.mapa);
        
        
        
        //se agrega evento de click para ver instalaciones
        //dentro de poligono
        var poligonoClickListener = new MapaPoligono();
        poligonoClickListener.addClickListener(poligono, this.mapa);
        
        
        lista_poligonos.push(poligono);
    },
    
    /**
     * 
     * @param {int} id
     * @param {object} propiedades
     * @param {object} coordenadas
     * @returns {void}
     */
    dibujarRectangulo : function (id, propiedades, coordenadas, color){
        var rectangle = new google.maps.Rectangle({
            id : id,
            custom : true,
            tipo : "RECTANGULO",
            identificador:null,
            clave : "elemento_" + id,
            capa : null,
            informacion: propiedades,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: this.mapa,
            bounds: coordenadas,
            popup_poligono: this.bo_informacion_poligonos
        });
        
        var circuloClickListener = new MapaPoligonoInformacion();
        circuloClickListener.addRightClickListener(rectangle, this.mapa);
        
        lista_poligonos.push(rectangle);
    },
    
    /**
     * 
     * @param {int} id
     * @param {object} propiedades
     * @param {object} centro
     * @param {string} radio
     * @returns {void}
     */
    dibujarCirculo : function(id, propiedades, centro, radio, color){
        var circulo = new google.maps.Circle({
            id : id,
            custom : true,
            tipo : "CIRCULO",
            identificador:null,
            capa : null,
            informacion: propiedades,
            clave : "elemento_" + id,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: this.mapa,
            center: centro,
            radius: radio,
            popup_poligono: this.bo_informacion_poligonos
        });
        
        var circuloClickListener = new MapaInformacionElemento();
        circuloClickListener.addRightClickListener(circulo, this.mapa);
        
        lista_poligonos.push(circulo);
    },
    
    /**
     * 
     * @returns {undefined}
     */
    listaElementosVisor : function(){
        
        var lista = this.listCustomElements();
        
        var html = "";
        var cantidad = 0;
       
        $.each(lista, function(i, json){
           var data = jQuery.parseJSON(json);
           var preview = "";
           switch(data.tipo){
               case "LINEA":
               case "POLIGONO":
               case "RECTANGULO":
               case "CIRCULO":
                   preview = "<div class=\"color-capa-preview\" style=\"background-color:" + data.color + "; height: 20px;width: 20px;margin-left:9px\"></div>";
                   break;
               default:
                   preview = "<img style=\"height:20px\" src=\"" + data.icono + "\" >";
                   break;
           }
           
           if(i!=0){
               html += "<li class=\"divider\"></li>";
           } 
            
           html += "<li data=\"" + data.id + "\" class=\"\"><a href=\"#\">\n"
                    + "<div class=\"row\">"
                       + "<div class=\"col-xs-2 text-center\">" + preview + "</div>"
                       + "<div class=\"col-xs-10\"> " + data.nombre + "</div>"
                    + "</div>\n"
                 + "</a></li>";
           
           
           cantidad++;
        });
        
        
        $("#cantidad_elementos_agregados").html(cantidad);
 
        if(cantidad > 0){
            $("#cantidad_elementos_agregados").addClass("alert-success");
        } else {
            $("#cantidad_elementos_agregados").removeClass("alert-success");
        }

        $("#lista_elementos_agregados").html(html);
    },
    
    /*
    function alternateColor(color, textId, myInterval) {
    if(!myInterval){
        myInterval = 200;    
    }
    var colors = ['grey', color];
    var currentColor = 1;
    document.getElementById(textId).style.color = colors[0];
    setInterval(function() {
        document.getElementById(textId).style.color = colors[currentColor];
        if (currentColor < colors.length-1) {
            ++currentColor;
        } else {
            currentColor = 0;
        }
    }, myInterval);
}
alternateColor('yellow','myText');*/
    
    
    iluminarPoligono : function(elemento, color){
        $.each(lista_poligonos, function(i, forma){
           forma.color_original = forma.getFillColor();
           forma.setFillColor("gray");
        });
        elemento.setFillColor("yellow");    
    },
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadCustomElements : function(mapa, mensaje_carga){
        var tareas = new MapaLoading();
        
        
        
        
        this.mapa = mapa;
        
        var yo = this;
        
        var ajax = {         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: baseUrl + yo.getController() + "/ajax_elementos_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    
                    var bo_lugar_emergencia = false;
                    
                    $.each(data.resultado.elemento, function(id, elemento){
                        if(elemento.tipo == "PUNTO LUGAR EMERGENCIA"){
                            var lugar_emergencia = new MapaMarcadorLugarEmergencia();
                            lugar_emergencia.seteaMapa(mapa);
                            lugar_emergencia.posicionarMarcador(
                                    id, 
                                    elemento.coordenadas.center.lng, 
                                    elemento.coordenadas.center.lat, 
                                    elemento.coordenadas.zonas, 
                                    elemento.propiedades, 
                                    elemento.icono
                            );
                            
                            bo_lugar_emergencia = true;
                        }
                        
                        if(elemento.tipo == "LINEA"){
                            yo.dibujarLinea(id, elemento.propiedades, elemento.coordenadas, elemento.color);
                        }
                        
                        if(elemento.tipo == "PUNTO"){
                            yo.dibujarMarcador(id, elemento.clave, elemento.propiedades, elemento.coordenadas, elemento.icono);
                        }
                        
                        if(elemento.tipo == "CIRCULO"){
                            yo.dibujarCirculo(id, elemento.propiedades,elemento.coordenadas.center,elemento.coordenadas.radio, elemento.color);
                        }
                        
                        if(elemento.tipo == "RECTANGULO"){
                            yo.dibujarRectangulo(id, elemento.propiedades, elemento.coordenadas, elemento.color);
                        }
                        
                        if(elemento.tipo == "POLIGONO"){
                            yo.dibujarPoligono(id, elemento.propiedades, elemento.coordenadas, elemento.color);
                        }
                    });
                    
                    /*if(!bo_lugar_emergencia){
                        var lugar_alarma = new MapaMarcadorLugarAlarma();
                        lugar_alarma.seteaEmergencia(yo.id_emergencia);
                        lugar_alarma.marcador(yo.mapa);   
                    }*/
                    
                    yo.listaElementosVisor();
                    
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
                tareas.remove(1);
            }
        };
        
        tareas.push(1);
         $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: baseUrl + yo.getController() + "/ajax_contar_elementos", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                tareas.remove(1);
                if(data.cantidad > 0){
                    if(mensaje_carga){
                        tareas.push(1);
                        $.ajax(ajax)
                       /* Messenger().run({
                            action: $.ajax,
                            showCloseButton: true,
                            successMessage: '<strong> Elementos </strong> <br> Ok',
                            errorMessage: '<strong> Elementos </strong> <br> Se produjo un error al cargar',
                            progressMessage: '<strong> Elementos </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
                        },
                        ajax
                        );*/
                
                        
                    } else {
                        $.ajax(ajax);
                    }
                } else {
                   /* var lugar_alarma = new MapaMarcadorLugarAlarma();
                    lugar_alarma.seteaEmergencia(yo.id_emergencia);
                    lugar_alarma.marcador(yo.mapa);  */ 
                }
                yo.loadConfiguracion(mensaje_carga);
            }
        });
    },
    
    
    
    /**
     * 
     * @returns {undefined}
     */
    loadConfiguracion : function(mensaje_carga){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: baseUrl + yo.getController() + "/ajax_mapa_configuracion", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
               if(data.correcto){
                   
                    $.each(yo.on_load_functions, function(i, funcion){
                        funcion.funcion(data, yo.mapa);
                    });

                    
                    
                    if(data.resultado.tipo_mapa != "" && data.resultado.tipo_mapa != null){
                        yo.mapa.setMapTypeId(data.resultado.tipo_mapa);
                    }

               }
            }
        });
    },
    
    /**
     * 
     * @param {string} atributo
     * @param {string} valor
     * @returns {undefined}}
     */
    removeOneCustomElements : function(atributo, valor){
        console.log("Quitando elemento " + atributo + " " + valor);
        var custom = jQuery.grep(lista_poligonos, function( a ) {
            //if(a.custom){
                if(a[atributo] == valor){
                    return true;
                }
            //}
        });
        
        $.each(custom, function(i, elemento){
           elemento.setMap(null); 
        });
        
        lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });
        
        var custom = jQuery.grep(lista_markers, function( a ) {
            //if(a.custom){
                if(a[atributo] == valor){
                    return true;
                }
            //}
        });
        
        $.each(custom, function(i, elemento){
           elemento.setMap(null); 
        });
        
        lista_markers = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });
        
        this.listaElementosVisor();
    },
    
    /**
     * Quita todos los elementos custom
     * @returns {undefined}
     */
    removeCustomElements : function(){
        var custom = jQuery.grep(lista_poligonos, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        $.each(custom, function(i, elemento){
           elemento.setMap(null); 
        });
        
        
        lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
            if(!a.custom){
                return true;
            }
        });
        
        var custom = jQuery.grep(lista_markers, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        $.each(custom, function(i, elemento){
           elemento.setMap(null); 
        });
        
        
        lista_markers = jQuery.grep(lista_markers, function( a ) {
            if(!a.custom){
                return true;
            }
        });
    },
    
    
    listElements : function(function_marcador, function_forma){
        
        var parametro = {};
        
        var custom_element = function_marcador();
        var custom_markers = function_forma();
        
        var custom = $.merge(custom_element, custom_markers);
        
        $.each(custom, function(i, elemento){
            var data = null;
            
            var primaria = null;
            if(elemento.clave_primaria){
                primaria = elemento.clave_primaria;
            }
            
            switch(elemento.tipo){
                case "PUNTO":
                    data = {"tipo" : "PUNTO",
                            "clave" : elemento.clave,
                            "icono" : elemento.getIcon(),
                            "hash" : elemento.icono_hash,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "html" : elemento.html,
                            "coordenadas" : elemento.getPosition()};
                    break;
                case "PUNTO LUGAR EMERGENCIA":
                    
                    var radio = 0;
                    var color  = "";
                    var arr = jQuery.grep(lista_poligonos, function( a ) {
                        if(a.tipo == "CIRCULO LUGAR EMERGENCIA"){
                            if(a.clave == elemento.clave){
                                return true;
                            }
                        }
                    });
                    
                    var zonas = {};
                    $.each(arr, function(i, circulo){
                       zonas[i] = {"radio" : circulo.getRadius(),
                                   "color" : circulo.fillColor,
                                   "propiedades" : circulo.informacion};
                    });
                    
                    data = {"tipo" : "PUNTO LUGAR EMERGENCIA",
                            "clave" : elemento.clave,
                            "icono" : elemento.getIcon(),
                            "color" : color,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : {"center" : elemento.getPosition(),
                                             "zonas"  : zonas}};
                    break;
                case "POLIGONO":
                    data = {"tipo" : "POLIGONO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : elemento.getPath().getArray()};
                    break;
                case "RECTANGULO":
                    data = {"tipo" : "RECTANGULO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : elemento.getBounds()};
                    break;
                case "CIRCULO":
                    data = {"tipo" : "CIRCULO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : {"center" : elemento.getCenter(),
                                             "radio"  : elemento.getRadius()}};
                    break;
                case "LINEA":
                    data = {"tipo" : "LINEA",
                            "clave" : elemento.clave,
                            "color" : elemento.strokeColor,
                            "primaria" : primaria,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : elemento.getPath().getArray()};
                    break;
                
            }
            
            if(data == null){
                console.log(elemento);
            }
            
            if(elemento.informacion.NOMBRE){
                data["nombre"] = elemento.informacion.NOMBRE;
            } else {
                data["nombre"] = data.tipo;
            }
            
            if(data != null){
                parametro[i] = JSON.stringify(data);
            }
        });
        return parametro;
    },
    
    /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listCustomElements : function(){
        return this.listElements(
            function(){
                return jQuery.grep(lista_markers, function( a ) {
                    if(a.custom){
                        return true;
                    }
                });
            },
            function(){
                return jQuery.grep(lista_poligonos, function( a ) {
                    if(a.custom){
                        return true;
                    }
                });
            }
        );
    }
});


