var lista_poligonos = [];


var MapaPoligono = Class({
    
    /**
     * Google map
     */
    mapa : null,
    custom : false,
    editable : false,
    
    /**
     * Si el elemento tiene clave en BD
     */
    clave_primaria : null,
    
    /**
     * String de relacion con otro elemento (KML u otro)
     */
    relacion: null,
    
    /**
     * Si esta habilitado o no el popup
     * con informacion del poligono
     */
    bo_informacion_poligonos : true,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Habilita o no popup con datos de poligono 
     */
    seteaPopupPoligono : function(booleano){
        this.bo_informacion_poligonos = booleano;
    },
    
    /**
     * 
     * @param {int} id
     * @returns {undefined}
     */
    seteaClavePrimaria : function(id){
        this.clave_primaria = id;  
    },
    
    /**
     * @param {int} id
     */
    seteaRelacion : function(relacion){
        this.relacion = relacion;
    },
    
    /**
     * 
     * @param {type} custom
     * @returns {undefined}
     */
    seteaCustom : function(custom){
        this.custom = custom;
    },
    
    /**
     * 
     * @param {type} editable
     * @returns {undefined}
     */
    seteaEditable : function(editable){
        this.editable = editable;
    },
    
    /**
     * Quita el poligono del mapa
     * @param {string} atributo
     * @param {string} valor
     * @returns {void}
     */
    removerPoligono : function(atributo, valor){
        var arr = jQuery.grep(lista_poligonos, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });
        
        $.each(arr, function(i, poligono){
           poligono.setMap(null); 
        });
        
        //se quita el poligono de la lista
        lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });
    },
    
    /**
     * Dubuja poligono en el mapa
     * @param {mixed} capa si es null el poligono no pertenece a capa
     * @param {object} geometry
     * @param {string} zona
     * @param {string} color
     * @returns {void}
     */
    dibujarPoligono : function(id, nombre, capa, geometry, propiedades, zona, color){

        var yo = this;
        
       
        $.each(geometry, function(i, coordenadas){
            
            var puntos = [];
            $.each(coordenadas, function(j, valores){
                
                puntos.push(new google.maps.LatLng(parseFloat(valores[1]), parseFloat(valores[0])));
            });
           
            var poligono = new google.maps.Polygon({
                clave_primaria : yo.clave_primaria,
                relacion: yo.relacion,
                paths: puntos,
                identificador: id,
                nombre: nombre,
                clave : "poligono_" + id,
                capa: capa,
                editable: yo.editable,
                custom: yo.custom,
                tipo: "POLIGONO",
                informacion: propiedades,
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: color,
                fillOpacity: 0.35,
                popup_poligono: yo.bo_informacion_poligonos
            });

            poligono.setMap(yo.mapa);
          
            //se agrega evento de click para ver instalaciones
            //dentro de poligono
            yo.addClickListener(poligono, yo.mapa);

            lista_poligonos.push(poligono);
        });

    },
    
    /**
     * 
     * @param {google.maps.Polygon} elemento
     * @returns {void}
     */
    addClickListener : function(elemento, mapa){
        
        var informacion = new MapaPoligonoInformacion();
        informacion.addRightClickListener(elemento, mapa);
        
    }
    
});


