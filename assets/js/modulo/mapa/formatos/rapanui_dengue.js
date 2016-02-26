var rapanui_ebola = [];

var MapaRapanuiDengue = Class({  
    
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
        if(rapanui_ebola.length == 0){ //si ya esta cargado no se vuelve a cargar
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
                url: siteUrl + "mapa/info_rapanui_dengue", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            switch(valor.id_estado){
                                case "1":
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/confirmado.png"
                                    var zona = {
                                       0 : 
                                        {
                                            "radio" : 100,
                                            "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                             "ESTADO" : "CONFIRMADO",
                                                             "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                            "color" : "#ff0000"
                                        }
                                    };
                                    break;
                                case "2":
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/descartado.png"
                                    var zona = {};
                                    break;
                                case "3":
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/no_concluyente.png"
                                    var zona = {
                                       0 : 
                                        {
                                            "radio" : 100,
                                            "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                             "ESTADO" : "NO CONCLUYENTE",
                                                             "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                            "color" : "#486ff0"
                                        }
                                    };
                                    break;
                                default:
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/caso_sospechoso.png"
                                    var zona = {
                                       0 : 
                                        {
                                            "radio" : 100,
                                            "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                             "ESTADO" : "SOSPECHOSO",
                                                             "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                            "color" : "#ffff00"
                                        }
                                    };
                                    break;
                            }

                           
                            var marcador = new MapaMarcadorLugarEmergencia();
                            marcador.seteaMapa(yo.mapa);
                            marcador.seteaCustom(false);
                            marcador.posicionarMarcador("rapanui_dengue_" + valor.id, valor.lng, valor.lat, zona, valor.propiedades, icono);
                            rapanui_ebola.push("rapanui_dengue_" + valor.id);
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
        $.each(rapanui_ebola, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        var poligono = new MapaPoligono();
        $.each(rapanui_ebola, function(i, identificador){
            poligono.removerPoligono("id", identificador);
        });
        
        rapanui_ebola = [];
    }
});

