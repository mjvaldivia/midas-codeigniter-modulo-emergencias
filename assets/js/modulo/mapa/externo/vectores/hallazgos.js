var vectores_marcador = [];

var MapaVectoresHallazgos = Class({  
    
    /**
     * Google maps
     */
    mapa : null,
        
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
    load : function(){
        var yo = this;
        if(vectores_hallazgos_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Inspecciones </strong> <br> Ok',
                errorMessage: '<strong> Inspecciones </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Inspecciones </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_vectores_hallazgos", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            if(valor.propiedades.resultado == "Negativo"){
                                var icono = baseUrl + "assets/img/markers/otros/mosquito-3.png"
                            } else {
                                var icono = baseUrl + "assets/img/markers/otros/mosquito.png"
                            }
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("vectores_inspecciones_" + valor.id, null , valor.lng, valor.lat, valor.propiedades, null, icono);
                            
                            var fecha_hallazgo = moment(valor.propiedades.fecha_hallazgo, "DD/MM/YYYY", true);
                            
                            vectores_marcador.push(
                                {
                                    "identificador" : "vectores_inspecciones_" + valor.id,
                                    "tipo" : "INSPECCION",
                                    "hallazgo" : fecha_hallazgo,
                                    "resultado": valor.propiedades["resultado"],
                                    "estadio": valor.propiedades["estado_desarrollo"]
                                }
                            );
                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los casos febriles.");
                    }
               }
            });
        }
    },
    
    /**
     * Quita los marcadores
     * @returns {undefined}
     */
    remove : function(){
         var marcador = new MapaMarcador();
        $.each(vectores_marcador, function(i, marker){
            marcador.removerMarcadores("identificador", marker.identificador);
        });
        
        vectores_marcador = [];
    }
});
