var MapaKmlExportar = Class({
   
    /**
     * Crea kmz de un elemento
     * @param {type} tipo
     * @param {type} identificador
     * @param {type} clave
     * @returns {undefined}
     */
    makeElement : function(tipo, identificador, clave){
        var lista_kml = [];
        
        var elemento_kml = new MapaKmlExportarElemento();
        
        var elementos = this.retornaElementos(tipo, identificador, clave);

        $.each(elementos, function(i, elemento){
            if(elemento_kml.exportar(elemento)){
                lista_kml.push({"file" : elemento_kml.retornaHash()});
            }
        });

        if(lista_kml.length > 0){
            this.generaKmz(lista_kml);
        }

    },
    
    generaKmz : function(lista_hash){
        
        console.log(lista_hash);
        
         var parametros = {"kml" : {}};
        $.each(lista_hash, function(i, hash){
            parametros["kml"][i] = hash.file;
        });
        
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
        if(tipo == "CIRCULO LUGAR EMERGENCIA"){
            var elementos = jQuery.grep(
                lista_poligonos, 
                function( a ) {
                    if(a["clave"] == clave){
                        return true;
                    }
            });
        } else {
            var elementos = jQuery.grep(
                lista_poligonos, 
                function( a ) {
                    if(a["identificador"] == identificador){
                        return true;
                    }
            });
        }
        return elementos;
    }
    
});


