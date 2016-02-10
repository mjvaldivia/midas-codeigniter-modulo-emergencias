var MapaKmlExportarElemento = Class({
    
    exportar : function(elemento){
        var retorno = {};
        
        var coordenadas = {};
        switch(elemento.tipo){
            case "POLIGONO":
                coordenadas = elemento.getPaths();
                break;
            case "CIRCULO":
            case "CIRCULO LUGAR EMERGENCIA":
                var contenido = new MapaInformacionElementoContenido();
                coordenadas = contenido.coordenadasCirculo(elemento.getCenter(), elemento.getRadius());
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
        
        var parametros = {"coordenadas" : JSON.stringify(coordenadas),
                          "color" : elemento.fillColor,
                          "tipo" : elemento.tipo,
                          "informacion" : JSON.stringify(elemento.informacion)};
        
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
               retorno = data.clave_elemento_kml;
           }
       });
       
       return retorno;
    }
});


