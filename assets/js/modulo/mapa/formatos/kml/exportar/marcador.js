var MapaKmlExportarMarcador = Class({
    marcadores : [],
    
    /**
     * Agrega informacion de un marcador
     * @param {googleMaps} marker
     * @returns {undefined}
     */
    addMarcador : function(marker){
        var icono = marker.getIcon();
        var posicion = marker.getPosition();
        var propiedades = marker.informacion;
        
        this.marcadores.push({
            "icono" : icono,
            "posicion" : posicion,
            "informacion" : propiedades}
        );
    },
    
    /**
     * 
     * @returns {Array}
     */
    retornaMarcadores : function(){
        return this.marcadores;
    }
});


