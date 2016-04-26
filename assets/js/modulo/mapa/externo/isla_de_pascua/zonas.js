var casos_febriles_zonas = [];

var MapaIslaDePascuaZonas = Class({ extends : MapaIslaDePascuaCasos}, {
    
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
        if(casos_febriles_zonas.length == 0){ //si ya esta cargado no se vuelve a cargar
            
            var parametros = {"desde" : $("#fecha_desde_casos").val(),
                              "hasta" : $("#fecha_hasta_casos").val(),
                              "estado" : $("#estado_casos").val()};
            
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
                            
                            var lista_id_enfermedades = [];
                            
                            switch(valor.id_estado){
                                case "1":
                                    
                                    $.each(valor.enfermedades, function(i, enfermedad){
                                        lista_id_enfermedades.push(enfermedad.id);
                                    });
                                    
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
                                                       
                                var fecha_inicio = moment(valor.propiedades["FECHA DE INICIO DE SINTOMAS"], "DD/MM/YYYY", true);
                                var fecha_ingreso = moment(valor.fecha_ingreso, "DD/MM/YYYY", true);
                                var fecha_confirmacion = moment(valor.propiedades["CONCLUSION FECHA"], "DD/MM/YYYY", true);

                                casos_febriles_zonas.push(
                                    {
                                        "identificador" : identificador,
                                        "fecha_inicio" : fecha_inicio,
                                        "fecha_ingreso" : fecha_ingreso,
                                        "fecha_confirmacion" : fecha_confirmacion,
                                        "estado" : valor.id_estado,
                                        "enfermedades" : lista_id_enfermedades
                                    }
                                );
                            }
                        });
                        yo.filtrar();
                    } else {
                        notificacionError("", "No es posible encontrar la información de los casos febriles.");
                    }
                    $("#formulario-casos-rango").removeClass("hidden");
               }
            });
        }
    },
    
    /**
     * 
     * @returns {undefined}
     */
    filtrar : function(){
        var yo = this;
        $.each(casos_febriles_zonas, function(i, marker){
            var ok = yo.verFiltros(marker);
            if(!ok){
                jQuery.grep(lista_poligonos, function( a ) {
                    if(a["identificador"] == marker.identificador){
                        a.setMap(null);
                    }
                });
            } else {
                jQuery.grep(lista_poligonos, function( a ) {
                    if(a["identificador"] == marker.identificador){
                        a.setMap(yo.mapa);
                    }
                });
            }
        });
    },
    
    /**
     * Quita los marcadores
     * @returns {undefined}
     */
    remove : function(){        
        var poligono = new MapaPoligono();
        $.each(casos_febriles_zonas, function(i, zona){
            poligono.removerPoligono("clave", zona.identificador);
        });
        casos_febriles_zonas = [];
    }
});

