var MapaKmlSidcoConaf = Class({  
    
    /**
     * Google maps
     */
    mapa : null,
    infoWindow : null,
    
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Carga el KML desde conaf
     * @returns {void}
     */
    loadKml : function(){
        var yo = this;
        
        var kmzLayer = new google.maps.KmlLayer("http://sidco.conaf.cl/mapa/earth-data.php?key=2gTkrf%2FkZkN4pvHtRclb7c%2FUobAO57i0o8AdyhFdAwA%3D",{
            suppressInfoWindows: true,
            preserveViewport: true
        });
        
        kmzLayer.setMap(this.mapa);

        kmzLayer.addListener('click', function(kmlEvent) {
            var parametros = {"nombre" : kmlEvent.featureData.name}
            $.ajax({         
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "mapa_sidco/info", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("", "No se pudo recuperar la información del incendio");
                },
                success:function(json){
                    if(json.correcto){
                        
                        if(yo.infoWindow != null){
                            yo.infoWindow.setMap(null);
                        }
                        
                        yo.infoWindow = new google.maps.InfoWindow({
                            content: "<iframe scrolling=\"no\" frameborder=\"0\" style=\"overflow:hidden\" src=\""+json.url+"\"></iframe>",
                            position: kmlEvent.latLng
                        });
                        
                        yo.infoWindow.open(yo.mapa);

                    } else {
                        notificacionError("", "No se pudo recuperar la información del incendio");
                    }
                }
            }); 
        });
    }
});

