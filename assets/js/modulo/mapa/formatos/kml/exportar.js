var MapaKmlExportar = Class({
   
    /**
     * Crea kmz de un elemento
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {undefined}
     */
    makeElement : function(tipo, identificador, clave){
        var kml = "";
        
        var elemento_kml = new MapaKmlExportarElemento();
        
        var elementos = this.retornaElementos(tipo, identificador, clave);

        $.each(elementos, function(i, elemento){
            elemento_kml.addElemento(elemento);
        });
        
        if(elemento_kml.exportar()){
            kml = elemento_kml.retornaHash();
        }

        if(kml != ""){
            this.generaKmz(kml);
        }

    },
    
    generaKmz : function(kml){
                
         var parametros = {"kml" : kml};
        
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
    
    /**
     * 
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {Array}
     */
    retornaElementos : function(tipo, identificador, clave){
        var contenido = new MapaInformacionElementoContenido();
        
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
    }
    
});


