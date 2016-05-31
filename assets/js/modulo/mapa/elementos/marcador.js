var lista_markers = [];

var MapaMarcador = Class({
    
    mapa : null,
    
    draggable : false,

    /**
     * Si el elemento tiene clave en BD
     */
    clave_primaria : null,
    
    /**
     * String de relacion con otro elemento (KML u otro)
     */
    relacion: null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * 
     * @param {type} id
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
     * Quita marcadores de acuerdo al parametro que se quiere buscar
     * @param {string} atributo parametro a buscar
     * @param {int} valor valor del parametro a buscar
     * @returns {void}
     */
    removerMarcadores : function(atributo, valor){
        
        var arr = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });
        
        //se quita marcador del mapa
        $.each(arr, function(i, marcador){
           marcador.setMap(null); 
        });
        
        //se borran los marcadores de la lista
        lista_markers = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] != valor){
                return true;
            }
        });

    },
    
     /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMarcador : function(id, capa, lon, lat, propiedades, zona, imagen){
        var yo = this;
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        marker = new google.maps.Marker({
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            position: posicion,
            custom : false,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            tipo: "PUNTO",
            informacion : propiedades,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: imagen
        });  

        this.informacionMarcador(marker);
       
        lista_markers.push(marker);
        google.maps.event.trigger(yo.mapa, 'marcador_cargado');
    },
    

    
    /**
     * Popup con informacion
     * @param {marker} marker
     * @returns {void}
     */
    informacionMarcador : function(marker){
        
        if(marker["infoWindow"]){
            marker["infoWindow"].setMap(null);
        }
        
        
        var yo = this;
        if(marker.informacion_html && marker.informacion_html != ""){
            var markerContent =  marker.informacion_html;
            marker.html = marker.informacion_html;
        } else {
            var markerContent = '<div class="info_content">';
            var propiedades = marker.informacion;

            $.each(propiedades, function(nombre, valor){
                if(valor != ""){
                    markerContent += '<div class="col-xs-12"><strong>' + nombre +':</strong> ' + valor + '</div>';
                }
            });

            markerContent += '</div>';
        }
         
        marker["infoWindow"] = new google.maps.InfoWindow({
            content: markerContent
        }); 
          
        google.maps.event.addListener(marker, 'click', function () {
            marker["infoWindow"].open(yo.mapa, this);
        });
    }
    
    
});


