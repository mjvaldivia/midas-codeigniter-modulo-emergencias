var MapaMareaRojaCasosPm = Class({ extends : MapaMareaRojaCasos}, {
    
    /**
     * 
     * @param {object} valor
     * @returns {String}
     */
    coloresIcono : function(valor){
        var icono = "";
        if(valor.resultado == "ND" || valor.resultado == "nd"){
            icono = baseUrl + "assets/img/markers/marisco/marcador-verde.png"
        } else {
            
            if(200 > parseInt(valor.resultado)){
                icono = baseUrl + "assets/img/markers/marisco/marcador-azul.png";
            }
            
            if( 1000 >= parseInt(valor.resultado) && parseInt(valor.resultado) >= 200){
                icono = baseUrl + "assets/img/markers/marisco/marcador-amarillo.png";
            }
            
            if(parseInt(valor.resultado) > 1000){
                icono = baseUrl + "assets/img/markers/marisco/marcador-rojo.png";
            }
            
        }
        
        return icono;
    },
});


