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
    
    dibujarRectangulo : function (id, propiedades, coordenadas){
        var rectangle = new google.maps.Rectangle({
            id : id,
            custom : true,
            tipo : "RECTANGULO",
            identificador:null,
            capa : null,
            informacion: propiedades,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#ffff00',
            fillOpacity: 0.35,
            map: this.mapa,
            bounds: coordenadas
        });

        var rectanguloClickListener = new MapaRectanguloClickListener();
        rectanguloClickListener.addClickListener(rectangle);
        lista_poligonos.push(rectangle);
    },
    
    dibujarCirculo : function(id, propiedades, centro, radio){
        var circulo = new google.maps.Circle({
            id : id,
            custom : true,
            tipo : "CIRCULO",
            identificador:null,
            capa : null,
            informacion: propiedades,
            clickable: true,
            editable: true,
            strokeColor: '#000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#ffff00',
            fillOpacity: 0.35,
            map: this.mapa,
            center: centro,
            radius: radio
        });

        var circuloClickListener = new MapaCirculoClickListener();
        circuloClickListener.addClickListener(circulo);
        lista_poligonos.push(circulo);
    },
    
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
                            yo.dibujarCirculo(id, elemento.propiedades,elemento.coordenadas.center,elemento.coordenadas.radio);
                        }
                        
                        if(elemento.tipo == "RECTANGULO"){
                            yo.dibujarRectangulo(id, elemento.propiedades, elemento.coordenadas);
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
                        "id" : elemento.id,
                        "propiedades" : elemento.informacion,
                        "coordenadas" : elemento.getPath().getArray()};
            }
            
            if(elemento.tipo == "RECTANGULO"){
                data = {"tipo" : "RECTANGULO",
                        "id" : elemento.id,
                        "propiedades" : elemento.informacion,
                        "coordenadas" : elemento.getBounds()};
            }
            
            if(elemento.tipo == "CIRCULO"){
                data = {"tipo" : "CIRCULO",
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


