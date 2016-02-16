var rapanui_ebola = null;

var MapaRapanuiEbola = Class({  
    
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
    load : function(){
        var yo = this;
        if(rapanui_ebola == null){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: 'Información del casos cargada correctamente',
                errorMessage: 'No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<i class=\"fa fa-spin fa-spinner\"></i> Cargando información de casos...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_rapanui_ebola", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                           var marcador = new MapaMarcador();
                           marcador.seteaMapa(yo.mapa);
                           marcador.posicionarMarcador("rapanui_ebola", null, valor.lng, valor.lat, valor.propiedades, "", baseUrl + "assets/img/firstaid.png");
                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información del incendio.");
                    }
               }
            });
        }
    },
    
    remove : function(){
        var marcador = new MapaMarcador();
        marcador. removerMarcadores("identificador", "rapanui_ebola");
        rapanui_ebola = null;
    }
});

