var MapaKmlExportarElemento = Class({
    
    file_hash : "",
    elementos : [],
    /**
     * 
     * @returns {retorno|String}
     */
    retornaHash : function(){
        return this.file_hash;
    },
    
    
    addElemento : function(elemento){
        var coordenadas = {};
        switch(elemento.tipo){
            case "POLIGONO":
                var paths = elemento.getPaths();
                $.each(paths.j, function(i, paths_j){
                    coordenadas = paths_j.j;
                });
                break;
            case "CIRCULO":
                var contenido = new MapaInformacionElementoContenido();
                coordenadas = contenido.coordenadasCirculo(elemento.getCenter(), elemento.getRadius());
                break;
            case "CIRCULO LUGAR EMERGENCIA":
                var contenido = new MapaInformacionElementoContenido();
                coordenadas = contenido.coordenadasCirculo(elemento.getCenter(), elemento.getRadius());
                
                //se buscan hermanas menores, que contengan el marcador
                var hermana_menor = jQuery.grep(lista_poligonos, function( a ) {
                    if(a["tipo"] == "CIRCULO LUGAR EMERGENCIA" && a["identificador"] != elemento.identificador && a["clave"]==elemento.clave){
                        if(a.getRadius() < elemento.getRadius()){
                            return true;
                        }
                    }
                });
                
                if(hermana_menor.length > 0){
                    $.each(hermana_menor, function(i, hermana){
                        var coordenadas_hermana = contenido.coordenadasCirculo(hermana.getCenter(), hermana.getRadius());
                        $.each(coordenadas_hermana, function(j, coord){
                            coordenadas.push(coord);
                        });
                    });
                }
                
                
                
                break;
            case "RECTANGULO":
                var bounds = elemento.getBounds();
                var NE = bounds.getNorthEast();
                var SW = bounds.getSouthWest();
                var NW = new google.maps.LatLng(NE.lat(),SW.lng());
                var SE = new google.maps.LatLng(SW.lat(),NE.lng());
                coordenadas = new Array(NE,NW,SW,SE);
                break;
        }
        
        this.elementos.push({"coordenadas" : JSON.stringify(coordenadas),
                            "color" : elemento.fillColor,
                            "tipo" : elemento.tipo,
                            "informacion" : JSON.stringify(elemento.informacion)});
    },

    /**
     * 
     * @param {type} elemento
     * @returns {Boolean}
     */
    exportar : function(){
        var correcto = true;
        var retorno = "";
        
        var parametros = {"elemento" : {}};
        $.each(this.elementos, function(i, elemento){
            parametros["elemento"][i] = elemento;
        });

        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "mapa_kml/ajax_exportar_kml_elemento", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema - ", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    retorno = data.file;
                } else {
                    correcto = false;
                }
            }
       });
       
       this.file_hash = retorno;
       
       return correcto;
    }
});


