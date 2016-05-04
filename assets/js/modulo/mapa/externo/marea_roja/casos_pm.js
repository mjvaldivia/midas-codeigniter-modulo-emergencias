var MapaMareaRojaCasosPm = Class({ extends : MapaMareaRojaCasos}, {
    
    /**
     * 
     * @param {object} valor
     * @returns {String}
     */
    coloresIcono : function(valor){
        var icono = "";
        if(valor.resultado == "ND" || parseInt(valor.resultado) <= 80){
            icono = baseUrl + "assets/img/markers/marisco/marcador-verde.png"
        } else {
            icono = baseUrl + "assets/img/markers/marisco/marcador-rojo.png";
        }
        
        return icono;
    },
});


