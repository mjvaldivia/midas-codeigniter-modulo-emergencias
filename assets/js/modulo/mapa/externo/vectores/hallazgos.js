var vectores_hallazgos_marcador = [];

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
                successMessage: '<strong> Vectores </strong> <br> Ok',
                errorMessage: '<strong> Vectores </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Vectores</strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
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
                                var icono = baseUrl + "assets/img/markers/otros/mosquito-rojo.png"
                            }
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("vectores_hallazgos_" + valor.id, null , valor.lng, valor.lat, valor.propiedades, null, icono);
                            vectores_hallazgos_marcador.push("vectores_hallazgos_" + valor.id);
                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los casos febriles.");
                    }
                    
                    console.log(lista_markers);
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
        $.each(vectores_hallazgos_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        vectores_hallazgos_marcador = [];
    }
});
