var rapanui_embarazadas_marcador = [];

var MapaIslaDePascuaEmbarazadas = Class({  
    
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
        if(rapanui_embarazadas_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Embarazadas </strong> <br> Ok',
                errorMessage: '<strong> Embarazadas </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Embarazadas </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: baseUrl + getController() + "/info_rapanui_embarazadas", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            var icono = baseUrl + "assets/img/markers/otros/embarazada.png"
                            var marcador = new MapaMarcadorLabel();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("rapanui_embarazadas_" + valor.id, valor.semana , valor.lng, valor.lat, null, valor.propiedades, icono);
                            rapanui_embarazadas_marcador.push("rapanui_embarazadas_" + valor.id);
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
        $.each(rapanui_embarazadas_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        rapanui_embarazadas_marcador = [];
    }
});
