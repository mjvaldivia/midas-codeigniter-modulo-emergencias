var marea_roja_marcador = [];

var MapaMareaRojaCasos = Class({  
    
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
        if(marea_roja_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Marea roja </strong> <br> Ok',
                errorMessage: '<strong> Marea roja </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Marea roja </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_marea_roja", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                          
                            
                            if(valor.resultado > 1000){
                                var icono = baseUrl + "assets/img/markers/marisco/rojo.png"
                            }
                            
                            if(valor.resultado <= 1000 && valor.resultado > 200){
                                var icono = baseUrl + "assets/img/markers/marisco/amarillo.png"
                            }
                            
                            if(valor.resultado <= 200){
                                var icono = baseUrl + "assets/img/markers/marisco/azul.png"
                            }
                            
                            var marcador = new MapaMarcadorLabel();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("marea_roja_" + valor.id, valor.semana , valor.lng, valor.lat, null, valor.propiedades, icono);
                            marea_roja_marcador.push("marea_roja_" + valor.id);
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
        $.each(marea_roja_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        marea_roja_marcador = [];
    }
});
