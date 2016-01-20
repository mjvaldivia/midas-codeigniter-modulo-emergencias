var MapaCirculoDibujar = Class({  
    
    mapa : null,
    identificador : null,
    editable : false,
    
    /**
     * 
     */
    seteaIdentificador : function(identificador){
        this.identificador = identificador;
    },
    
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    seteaEditable : function(editable){
        this.editable = editable;
    },
    
    dibujarCirculo : function(id, propiedades, centro, radio, color){
        var yo = this;
        var circulo = new google.maps.Circle({
            id : id,
            custom : true,
            tipo : "CIRCULO",
            identificador: yo.identificador,
            capa : null,
            informacion: propiedades,
            clave : "elemento_" + id,
            clickable: true,
            editable: yo.editable,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: yo.mapa,
            center: centro,
            radius: parseInt(radio)
        });

        console.log(circulo);
        var circuloClickListener = new MapaCirculoClickListener();
        circuloClickListener.addClickListener(circulo, this.mapa);
        lista_poligonos.push(circulo);
    }
    
});


