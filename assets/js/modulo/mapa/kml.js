var lista_kml = [];

var MapaKml = Class({
    
     /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listKml : function(){
        var lista = {};
        $.each(lista_kml, function(i, kml){
            lista[i] = {"id" : kml.id,
                        "nombre" : kml.nombre,
                        "file" : kml.url};
        });
        return lista;
    }
});

