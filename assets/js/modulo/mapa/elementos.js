var MapaElementos = Class({
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    emergencia : function(id){
        this.id_emergencia = id;
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

        marker = new google.maps.Marker({
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
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35
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
            bounds: coordenadas
        });
        
        var circuloClickListener = new MapaInformacionElemento();
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
            radius: radio
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
               case "POLIGONO":
               case "RECTANGULO":
               case "CIRCULO":
                   preview = "<div class=\"color-capa-preview\" style=\"background-color:" + data.color + "; height: 20px;width: 20px;\"></div>";
                   break;
               default:
                   preview = "<img style=\"height:20px\" src=\"" + data.icono + "\" >";
                   break;
           }
           
                    
           html += "<li data=\"" + data.id + "\" class=\"\">\n"
                 + "<div class=\"row\"><div class=\"col-xs-2\">" + preview + "</div><div class=\"col-xs-10\"> " + data.tipo + "</div>"
                 + "</div>\n"
                 + "</li>";
           
           
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
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadCustomElements : function(mapa, mensaje_carga){
        
        this.mapa = mapa;
        this.loadConfiguracion(mensaje_carga);
        
        var yo = this;
        
        var ajax = {         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_elementos_emergencia", 
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
                    
                    if(!bo_lugar_emergencia){
                        var lugar_alarma = new MapaMarcadorLugarAlarma();
                        lugar_alarma.seteaEmergencia(yo.id_emergencia);
                        lugar_alarma.marcador(yo.mapa);   
                    }
                    
                    yo.listaElementosVisor();
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
                
            }
        };

         $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_contar_elementos", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.cantidad > 0){
                    if(mensaje_carga){
                        Messenger().run({
                            action: $.ajax,
                            showCloseButton: true,
                            successMessage: '<strong> Elementos </strong> <br> Ok',
                            errorMessage: '<strong> Elementos </strong> <br> Se produjo un error al cargar',
                            progressMessage: '<strong> Elementos </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
                        },
                        ajax
                        );
                
                        
                    } else {
                        $.ajax(ajax);
                    }
                } else {
                    var lugar_alarma = new MapaMarcadorLugarAlarma();
                    lugar_alarma.seteaEmergencia(yo.id_emergencia);
                    lugar_alarma.marcador(yo.mapa);
                }
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
            url: siteUrl + "mapa/ajax_mapa_configuracion", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
               if(data.correcto){
                   if(data.resultado.sidco == 1){
                        var sidco = new MapaKmlSidcoConaf();
                        sidco.seteaMapa(yo.mapa);
                        sidco.loadKml(mensaje_carga);
                        $("#importar_sidco").prop("checked", true);
                   } else {
                       $("#importar_sidco").prop("checked", false);
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
    
    /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listCustomElements : function(){
        
        var parametro = {};
        
        var custom_element = jQuery.grep(lista_poligonos, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        var custom_markers = jQuery.grep(lista_markers, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        var custom = $.merge(custom_element, custom_markers);
        
        $.each(custom, function(i, elemento){
            var data = null;
            
            switch(elemento.tipo){
                case "PUNTO":
                    data = {"tipo" : "PUNTO",
                            "clave" : elemento.clave,
                            "icono" : elemento.getIcon(),
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
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
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : {"center" : elemento.getPosition(),
                                             "zonas"  : zonas}};
                    break;
                case "POLIGONO":
                    data = {"tipo" : "POLIGONO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : elemento.getPath().getArray()};
                    break;
                case "RECTANGULO":
                    data = {"tipo" : "RECTANGULO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : elemento.getBounds()};
                    break;
                case "CIRCULO":
                    data = {"tipo" : "CIRCULO",
                            "clave" : elemento.clave,
                            "color" : elemento.fillColor,
                            "id" : elemento.id,
                            "propiedades" : elemento.informacion,
                            "coordenadas" : {"center" : elemento.getCenter(),
                                             "radio"  : elemento.getRadius()}};
                    break;
                
            }

            if(data != null){
                parametro[i] = JSON.stringify(data);
            }
        });
        return parametro;
    }
});


