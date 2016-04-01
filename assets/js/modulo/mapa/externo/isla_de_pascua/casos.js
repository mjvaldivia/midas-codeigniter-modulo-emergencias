var rapanui_ebola_marcador = [];

var MapaIslaDePascuaCasos = Class({  
    
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
        if(rapanui_ebola_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            
            var parametros = {"desde" : $("#fecha_desde_casos").val(),
                              "hasta" : $("#fecha_hasta_casos").val(),
                              "estado" : $("#estado_casos").val()};
            
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Casos febriles </strong> <br> Ok',
                errorMessage: '<strong> Casos febriles <strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Casos febriles </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "mapa/info_rapanui_dengue", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            var con_label = false;
                            
                            switch(valor.id_estado){
                                case "1":
                                    var label = "";
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/confirmado.png"
                                    con_label = true;
                                    
                                    $.each(valor.enfermedades, function(i, enfermedad){
                                        if(label != ""){
                                            label = label + "|";
                                        }
                                        label = label + enfermedad;
                                    });

                                    break;
                                case "2":
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/descartado.png"
                                    break;
                                case "3":
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/no_concluyente.png"
                                    break;
                                default:
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/caso_sospechoso.png"
                                    break;
                            }
                            
                            if(con_label){
                                var marcador = new MapaMarcadorLabel();
                                marcador.seteaMapa(yo.mapa);
                               
                                marcador.posicionarMarcador("rapanui_dengue_" + valor.id, label , valor.lng, valor.lat, null, valor.propiedades, icono);
                            } else {
                                var marcador = new MapaMarcador();
                                marcador.seteaMapa(yo.mapa);
                                marcador.posicionarMarcador("rapanui_dengue_" + valor.id, null, valor.lng, valor.lat, valor.propiedades, null, icono);
                            }
                            rapanui_ebola_marcador.push("rapanui_dengue_" + valor.id);
                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los casos febriles.");
                    }
                    
                    $("#formulario-casos-rango").removeClass("hidden");
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
        $.each(rapanui_ebola_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        rapanui_ebola_marcador = [];
    }
});

