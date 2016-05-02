var rabia_vacunacion_marcador = [];

var MapaRabiaVacunacion = Class({  
    
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
        if(rabia_vacunacion_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Vacunación rabia </strong> <br> Ok',
                errorMessage: '<strong> Vacunación rabia </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Vacunación rabia </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_rabia_vacunacion", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            var icono = baseUrl + "assets/img/markers/otros/animal.png"
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("rabia_vacunacion_" + valor.id, null , valor.lng, valor.lat, valor.propiedades, null, icono);
                            rabia_vacunacion_marcador.push("rabia_vacunacion_" + valor.id);
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
        $.each(rabia_vacunacion_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        rabia_vacunacion_marcador = [];
    }
});
