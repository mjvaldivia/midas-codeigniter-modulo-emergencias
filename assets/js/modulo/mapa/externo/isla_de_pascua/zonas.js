var rapanui_ebola_zonas = [];

var MapaIslaDePascuaZonas = Class({  
    
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
        if(rapanui_ebola_zonas.length == 0){ //si ya esta cargado no se vuelve a cargar
            
            var parametros = {"desde" : $("#fecha_desde_casos").val(),
                              "hasta" : $("#fecha_hasta_casos").val()};
            
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
                data: parametros ,
                type: "post",
                url: siteUrl + "mapa/info_rapanui_dengue", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            switch(valor.id_estado){
                                case "1":
                                    var zona = {
                                        "radio" : 200,
                                        "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                         "NOMBRE" : "CASO FEBRIL N° " + valor.id,
                                                         "ESTADO" : "CONFIRMADO",
                                                         "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                        "color" : "#ff0000"
                                    };
                                    break;
                                case "3":
                                    var zona = {
                                        "radio" : 100,
                                        "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                         "NOMBRE" : "CASO FEBRIL N° " + valor.id,
                                                         "ESTADO" : "NO CONCLUYENTE",
                                                         "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                        "color" : "#486ff0"
                                    };
                                    break;
                                default:
                                    var zona = {
                                            "radio" : 100,
                                            "propiedades" : {"TIPO" : "CASO FEBRIL",
                                                             "NOMBRE" : "CASO FEBRIL N° " + valor.id,
                                                             "ESTADO" : "SOSPECHOSO",
                                                             "DIAGNOSTICO" : valor.propiedades["DIAGNOSTICO CLINICO"]},
                                            "color" : "#ffff00"
                                    };
                                    break;
                            }

                            if(valor.id_estado != 2){ //caso descartado
                                var posicion = new google.maps.LatLng(parseFloat(valor.lat), parseFloat(valor.lng));

                                var editor = new MapaEditor();
                                var identificador = editor.uniqID(20);

                                var circulo = new MapaCirculo();
                                circulo.seteaTipo("CIRCULO LUGAR EMERGENCIA");
                                circulo.seteaMapa(yo.mapa);
                                circulo.seteaCustom(false);
                                circulo.seteaUniqueId(identificador);
                                circulo.seteaEditable(false);
                                circulo.seteaIdentificador(identificador);
                                circulo.dibujarCirculo("rapanui_dengue_" + valor.id, 
                                                       zona.propiedades, 
                                                       posicion, 
                                                       zona.radio, 
                                                       zona.color);


                                rapanui_ebola_zonas.push("rapanui_dengue_" + valor.id);
                            }
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
        var poligono = new MapaPoligono();
        $.each(rapanui_ebola_zonas, function(i, identificador){
            poligono.removerPoligono("id", identificador);
        });
        
        rapanui_ebola_zonas = [];
    }
});

