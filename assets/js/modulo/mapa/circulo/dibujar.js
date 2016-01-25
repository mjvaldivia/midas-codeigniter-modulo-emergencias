var MapaCirculoDibujar = Class({  
    
    mapa : null,
    identificador : null,
    
    tipo : "CIRCULO",
    
    editable : false,
    unique_id : null,
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function() {
        this.reloadUniqueId();
    },
    
    /**
     * Setea el tipo de circulo
     * @param {string} tipo
     * @returns {undefined}
     */
    seteaTipo : function(tipo){
        this.tipo = tipo;
    },
    
    /**
     * Regenera el id unico
     * @returns {undefined}
     */
    reloadUniqueId : function(){
        var editor = new MapaEditor();
        this.unique_id = editor.uniqID(20);
    },
    
    /**
     * Setea un nuevo id unico
     * @param {type} unique_id
     * @returns {undefined}
     */
    seteaUniqueId : function(unique_id){
        this.unique_id = unique_id;
    },
    
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
        var editor = new MapaEditor();
        var yo = this;
        var circulo = new google.maps.Circle({
            id : id,
            custom : true,
            tipo : yo.tipo,
            identificador: yo.identificador,
            capa : null,
            informacion: propiedades,
            clave : yo.unique_id,
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

        
        var circuloClickListener = new MapaCirculoClickListener();
        circuloClickListener.addClickListener(circulo, this.mapa);
        
        var circuloClickListener = new MapaCirculoMoveListener();
        circuloClickListener.addMoveListener(circulo, this.mapa);
        
        lista_poligonos.push(circulo);
    }
    
});


