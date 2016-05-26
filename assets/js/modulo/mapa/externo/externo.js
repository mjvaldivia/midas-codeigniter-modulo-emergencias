var MapaExterno = Class({
    
    /**
     * googleMaps
     */
    mapa : null,
    
    /**
     * int
     */
    id_emergencia : null,
    
    /**
     * 
     * @param {googleMaps} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Setea la emergencia
     * @param {int} id_emergencia
     * @returns {externo_L22}
     */
    seteaEmergencia : function(id_emergencia){
        this.id_emergencia = id_emergencia;
    },
    
    /**
     * Carga las capas externas
     * @param {object} data
     * @returns {undefined}
     */
    loadCapasExternas : function(data){ 
        var yo = this;
        // ************ carga de capas de casos febriles *******************
        $("#importar_rapanui_casos").waitUntilExists(function(){
            if(parseInt(data.resultado.casos_febriles) == 1){
                var sidco = new MapaIslaDePascuaCasos();
                    sidco.seteaMapa(yo.mapa);
                    sidco.load();
                    $("#importar_rapanui_casos").prop("checked", true);
            } else {
                    $("#importar_rapanui_casos").prop("checked", false);
            }
        });

        $("#importar_rapanui_zonas").waitUntilExists(function(){
            if(parseInt(data.resultado.casos_febriles_zona) == 1){
                var sidco = new MapaIslaDePascuaZonas();
                sidco.seteaMapa(yo.mapa);
                sidco.load();
                $("#importar_rapanui_zonas").prop("checked", true);
            } else {
                $("#importar_rapanui_zonas").prop("checked", false);
            }
        });

        // ****************************************************************
        //************ carga de capas de marea roja ***********************

        if(parseInt(data.resultado.marea_roja) == 1){
            var marea_roja = new MapaMareaRojaCasos();
            marea_roja.seteaMapa(yo.mapa);
            marea_roja.seteaEmergencia(yo.id_emergencia);
            marea_roja.load(yo.mapa);
            $("#marea_roja").waitUntilExists(function(){
                $("#marea_roja").prop("checked", true);

                $("#marea-roja-contenedor-filtro-colores").waitUntilExists(function(){
                    $("#marea-roja-contenedor-filtro-colores").removeClass("hidden");
                    $("#marea-roja-pm-contenedor-filtro-colores").addClass("hidden");
                    $("#marea-roja-pm-contenedor-filtro-colores").find("input").prop("checked", false);
                });
            });
        } else {
            $("#marea_roja").waitUntilExists(function(){
                $("#marea_roja").prop("checked", false);
            })
        }

        if(parseInt(data.resultado.marea_roja_pm) == 1){
            var marea_roja = new MapaMareaRojaCasosPm();
            marea_roja.seteaMapa(yo.mapa);
            marea_roja.seteaEmergencia(yo.id_emergencia);
            marea_roja.load();
            $("#marea_roja_pm").waitUntilExists(function(){
                $("#marea_roja_pm").prop("checked", true);

                $("#marea-roja-contenedor-filtro-colores").waitUntilExists(function(){
                    $("#marea-roja-contenedor-filtro-colores").addClass("hidden");
                    $("#marea-roja-pm-contenedor-filtro-colores").removeClass("hidden");
                    $("#marea-roja-contenedor-filtro-colores").find("input").prop("checked", false);
                });
            });
        } else {
            $("#marea_roja_pm").waitUntilExists(function(){
                $("#marea_roja_pm").prop("checked", false);
            });
        }

        // ****************************************************************
        //************ carga de capas vectores ***********************

        if(parseInt(data.resultado.vectores) == 1){

            var vectores = new MapaVectores();
            vectores.seteaMapa(yo.mapa);
            vectores.load();
            $("#vectores_marcadores").waitUntilExists(function(){                            
                $("#vectores_marcadores").prop("checked", true);
            });
        } else {
            $("#vectores_marcadores").waitUntilExists(function(){     
                $("#vectores_marcadores").prop("checked", false);
            });
        }


        // ***************************************************************
        //*************** capa de incendios de conaf *********************

        $("#importar_sidco").waitUntilExists(function(){
            if(parseInt(data.resultado.sidco) == 1){
                 var sidco = new MapaKmlSidcoConaf();
                 sidco.seteaMapa(yo.mapa);
                 sidco.loadKml(mensaje_carga);
                 $("#importar_sidco").prop("checked", true);
            } else {
                $("#importar_sidco").prop("checked", false);
            }
        });
    }
});


