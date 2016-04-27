var MapaKmlExportar = Class({
   
   
   makeMapa : function(){
       var kml = "";
        var iconos = "";
        
        var elemento_kml = new MapaKmlExportarElemento();
        var marcador     = new MapaKmlExportarMarcador();
        
       
        $.each(lista_poligonos, function(i, elemento){
            elemento_kml.addElemento(elemento);
        });
        

        $.each(lista_markers, function(i, marker){
            if(marker.getVisible()){
                marcador.addMarcador(marker);
            }
        });
        
        if(elemento_kml.exportar(marcador.retornaMarcadores())){
            kml = elemento_kml.retornaHash();
            iconos = elemento_kml.retornaIconos();
        }

        if(kml != ""){
            this.generaKmz(kml, iconos);
        }
   },
   
    /**
     * Crea kmz de un elemento
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {undefined}
     */
    makeElement : function(tipo, identificador, clave){
        var kml = "";
        var iconos = "";
        
        var elemento_kml = new MapaKmlExportarElemento();
        var marcador     = new MapaKmlExportarMarcador();
        
        var lista_elementos = this.retornaElementos(tipo, identificador, clave);
        $.each(lista_elementos, function(i, elemento){
            elemento_kml.addElemento(elemento);
        });
        
        var lista_marcadores = this.retornaMarcadores(tipo, identificador, clave);
        $.each(lista_marcadores, function(i, marker){
            marcador.addMarcador(marker);
        });
        
        if(elemento_kml.exportar(marcador.retornaMarcadores())){
            kml = elemento_kml.retornaHash();
            iconos = elemento_kml.retornaIconos();
        }

        if(kml != ""){
            this.generaKmz(kml, iconos);
        }

    },
    
    /**
     * Genera KMZ
     * @param {type} kml
     * @returns {undefined}
     */
    generaKmz : function(kml, iconos){
                
         var parametros = {"kml" : kml,
                           "images" : iconos};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa_kml/ajax_generar_kmz",  
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    document.location.href = siteUrl + "mapa_kml/kml_temporal/hash/" + data.hash
                }
            }
        }); 
    },
    
    retornaMarcadores : function(tipo, identificador, clave){
         var contenido = new MapaInformacionElementoContenido();
        
        var elementos = this.retornaElementoSeleccionado(tipo, identificador, clave);
        
        var marcadores = [];
        $.each(elementos, function(i, elemento_seleccionado){
            $.each(lista_markers, function(j, marker){

                if(contenido.elementoContainsPoint(elemento_seleccionado, marker.getPosition())){
                    marcadores.push(marker);
                }
                
            });
        });
        
        return marcadores;
    },
    
    /**
     * 
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {Array}
     */
    retornaElementos : function(tipo, identificador, clave){
        var contenido = new MapaInformacionElementoContenido();
        
        var elementos = this.retornaElementoSeleccionado(tipo, identificador, clave);
        
        var aux = elementos;
        $.each(aux, function(i, elemento_seleccionado){
            $.each(lista_poligonos, function(j, elemento){
                if(elemento.clave != elemento_seleccionado.clave){
                    if(contenido.elementoContainsElemento(elemento_seleccionado, elemento, true)){
                        elementos.push(elemento);
                    }
                }
            });
        });
        
        return elementos;
    },
    
    /**
     * Busca elemento seleccionado
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {undefined}
     */
    retornaElementoSeleccionado : function(tipo, identificador, clave){
        if(tipo == "CIRCULO LUGAR EMERGENCIA"){
            var elementos = jQuery.grep(
                lista_poligonos, 
                function( a ) {
                    if(a["identificador"] == identificador){
                        return true;
                    }
            });
        } else {
            var elementos = jQuery.grep(
                lista_poligonos, 
                function( a ) {
                    if(a["clave"] == clave){
                        return true;
                    }
            });
        }
        
        return elementos;
    }
});


