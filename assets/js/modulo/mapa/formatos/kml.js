var lista_kml = [];

var MapaKml = Class({
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {int} id identificador emergencias
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
        this.id_emergencia = id;
    },
    
     /**
     * Retorna lista de elementos personalizados
     * @returns {String}
     */
    listKml : function(){
        var lista = {};
        $.each(lista_kml, function(i, kml){
            lista[i] = {"id" : kml.id,
                        "hash" : kml.hash,
                        "tipo" : kml.tipo,
                        "nombre" : kml.nombre,
                        "file" : kml.url};
        });
        return lista;
    },
    
    /**
     * Carga los elementos personalizados
     * @param {googleMaps} mapa
     * @returns {void}
     */
    loadKml : function(mapa){
        var yo = this;

        $.ajax({         
           dataType: "json",
           cache: false,
           async: true,
           data: "id=" + yo.id_emergencia,
           type: "post",
           url: siteUrl + "mapa_kml/ajax_contar_kml_emergencia", 
           error: function(xhr, textStatus, errorThrown){
               notificacionError("Ha ocurrido un problema - ", errorThrown);
           },
           success:function(data){
               if(data.cantidad>0){
                   Messenger().run({
                       action: $.ajax,
                       showCloseButton: true,
                       successMessage: '<strong> KML </strong> <br> Ok',
                       errorMessage: '<strong> KML </strong> <br> Se produjo un error al cargar',
                       progressMessage: '<strong> KML </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
                   }, {         
                       dataType: "json",
                       cache: false,
                       async: true,
                       data: "id=" + yo.id_emergencia,
                       type: "post",
                       url: siteUrl + "mapa_kml/ajax_kml_emergencia", 
                       error: function(xhr, textStatus, errorThrown){
                           notificacionError("Ha ocurrido un problema", errorThrown);
                       },
                       success:function(data){
                           if(data.correcto){
                               $.each(data.resultado.elemento, function(id, elemento){
                                   var kmzLayer = new google.maps.KmlLayer( siteUrl + "mapa_kml/kml/id/" + elemento.id + "/file." + elemento.tipo,{
                                       suppressInfoWindows: false,
                                       preserveViewport: true
                                   });
                                   kmzLayer.setMap(mapa);
                                   kmzLayer.id = elemento.id;
                                   kmzLayer.nombre = elemento.nombre;
                                   lista_kml.push(kmzLayer);
                               });
                           }
                       }
                   });
               }
           }
       });
        
        
        
       
    }
});

