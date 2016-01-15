var MapaElementoCustom = Class({
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    emergencia : function(id){
        this.id_emergencia = id;
    },
    
    dibujarPoligono : function(id, propiedades, coordenadas, color){
        var poligono = new google.maps.Polygon({
            paths: coordenadas,
            id : id,
            custom : true,
            tipo : "POLIGONO",
            identificador: null,
            clave : "elemento_" + id,
            capa: null,
            informacion: propiedades,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35
        });
        
        poligono.setMap(this.mapa);
        
        //se agrega evento de click para ver instalaciones
        //dentro de poligono
        var poligonoClickListener = new MapaPoligono();
        poligonoClickListener.addClickListener(poligono, this.mapa);
        
        lista_poligonos.push(poligono);
    },
    
    /**
     * 
     * @param {int} id
     * @param {object} propiedades
     * @param {object} coordenadas
     * @returns {void}
     */
    dibujarRectangulo : function (id, propiedades, coordenadas, color){
        var rectangle = new google.maps.Rectangle({
            id : id,
            custom : true,
            tipo : "RECTANGULO",
            identificador:null,
            clave : "elemento_" + id,
            capa : null,
            informacion: propiedades,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: this.mapa,
            bounds: coordenadas
        });

        var rectanguloClickListener = new MapaRectanguloClickListener();
        rectanguloClickListener.addClickListener(rectangle, this.mapa);
        lista_poligonos.push(rectangle);
    },
    
    /**
     * 
     * @param {int} id
     * @param {object} propiedades
     * @param {object} centro
     * @param {string} radio
     * @returns {void}
     */
    dibujarCirculo : function(id, propiedades, centro, radio, color){
        var circulo = new google.maps.Circle({
            id : id,
            custom : true,
            tipo : "CIRCULO",
            identificador:null,
            capa : null,
            informacion: propiedades,
            clave : "elemento_" + id,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: this.mapa,
            center: centro,
            radius: radio
        });

        var circuloClickListener = new MapaCirculoClickListener();
        circuloClickListener.addClickListener(circulo, this.mapa);
        lista_poligonos.push(circulo);
    },
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadCustomElements : function(mapa){
        this.mapa = mapa;
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "post",
            url: siteUrl + "mapa/ajax_elementos_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    $.each(data.resultado.elemento, function(id, elemento){
                        
                        if(elemento.tipo == "CIRCULO"){
                            yo.dibujarCirculo(id, elemento.propiedades,elemento.coordenadas.center,elemento.coordenadas.radio, elemento.color);
                        }
                        
                        if(elemento.tipo == "RECTANGULO"){
                            yo.dibujarRectangulo(id, elemento.propiedades, elemento.coordenadas, elemento.color);
                        }
                        
                        if(elemento.tipo == "POLIGONO"){
                            yo.dibujarPoligono(id, elemento.propiedades, elemento.coordenadas, elemento.color);
                        }
                    });
                } else {
                    notificacionError("Ha ocurrido un problema", data.error);
                }
            }
        });
    },
    
    /**
     * Quita todos los elementos custom
     * @returns {undefined}
     */
    removeCustomElements : function(){
        
        var custom = jQuery.grep(lista_poligonos, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        $.each(custom, function(i, elemento){
           elemento.setMap(null); 
        });
        
        
        lista_poligonos = jQuery.grep(lista_poligonos, function( a ) {
            if(!a.custom){
                return true;
            }
        });
    },
    
    /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listCustomElements : function(){
        
        var parametro = {};
        
        var custom = jQuery.grep(lista_poligonos, function( a ) {
            if(a.custom){
                return true;
            }
        });
        
        $.each(custom, function(i, elemento){
            var data = {};
            
            if(elemento.tipo == "POLIGONO"){
                data = {"tipo" : "POLIGONO",
                        "color" : elemento.fillColor,
                        "id" : elemento.id,
                        "propiedades" : elemento.informacion,
                        "coordenadas" : elemento.getPath().getArray()};
            }
            
            if(elemento.tipo == "RECTANGULO"){
                data = {"tipo" : "RECTANGULO",
                        "color" : elemento.fillColor,
                        "id" : elemento.id,
                        "propiedades" : elemento.informacion,
                        "coordenadas" : elemento.getBounds()};
            }
            
            if(elemento.tipo == "CIRCULO"){
                data = {"tipo" : "CIRCULO",
                        "color" : elemento.fillColor,
                        "id" : elemento.id,
                        "propiedades" : elemento.informacion,
                        "coordenadas" : {"center" : elemento.getCenter(),
                                         "radio"  : elemento.getRadius()}};
            }
            
            parametro[i] = JSON.stringify(data);
        });
        return parametro;
    }
});


