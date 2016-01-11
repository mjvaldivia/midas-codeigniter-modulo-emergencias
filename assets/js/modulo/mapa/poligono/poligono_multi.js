var MapaPoligonoMulti = Class({ extends : MapaPoligono}, {
            
    coordenadas : function(geometry, zona){
        var poligono = [];

        $.each(geometry, function(i, multipoligono){
           $.each(multipoligono, function(j, coordenadas){
               $.each(coordenadas, function(k, valores){
                   LatLng = GeoEncoder.utmToDecimalDegree(parseFloat(valores[0]), parseFloat(valores[1]), zona);
                   poligono.push(new google.maps.LatLng(parseFloat(LatLng[0]), parseFloat(LatLng[1])));
               });
           });
        });
        
        return poligono;
    }
    
});
