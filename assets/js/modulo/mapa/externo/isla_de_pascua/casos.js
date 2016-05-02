var casos_febriles_marcador = [];

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
        if(casos_febriles_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            
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
                            var lista_id_enfermedades = [];
                            
                            switch(valor.id_estado){
                                case "1":
                                    var label = "";
                                    var icono = baseUrl + "assets/img/markers/epidemiologico/confirmado.png"
                                    con_label = true;
                                    
                                    $.each(valor.enfermedades, function(i, enfermedad){
                                        if(label != ""){
                                            label = label + "|";
                                        }
                                        label = label + enfermedad.letra;
                                        lista_id_enfermedades.push(enfermedad.id);
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
                            
                           
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("rapanui_dengue_" + valor.id, null, valor.lng, valor.lat, valor.propiedades, null, icono);
                            
                            var fecha_inicio = moment(valor.propiedades["FECHA DE INICIO DE SINTOMAS"], "DD/MM/YYYY", true);
                            var fecha_ingreso = moment(valor.fecha_ingreso, "DD/MM/YYYY", true);
                            var fecha_confirmacion = moment(valor.propiedades["CONCLUSION FECHA"], "DD/MM/YYYY", true);
                            
                            casos_febriles_marcador.push(
                                {
                                    "identificador" : "rapanui_dengue_" + valor.id,
                                    "fecha_inicio" : fecha_inicio,
                                    "fecha_ingreso" : fecha_ingreso,
                                    "fecha_confirmacion" : fecha_confirmacion,
                                    "estado" : valor.id_estado,
                                    "enfermedades" : lista_id_enfermedades
                                }
                            );
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
     * @param {boolean} ok
     * @param {object} marker
     * @param {int} id
     * @returns {Boolean}
     */
    filtroFechas : function(ok, marker, id){
        
        if($("#" + id + "_desde_casos").val() != ""){
            if(marker[id].isValid()){
                var fecha_desde = moment($("#" + id + "_desde_casos").val(), "DD/MM/YYYY", true);
                if(fecha_desde.isValid() && marker[id].isBefore(fecha_desde)){
                    ok = false;
                }
            } else {
                ok = false;
            }
        }

        if($("#" + id + "_hasta_casos").val() != ""){
            if(marker[id].isValid()){
                var fecha_hasta = moment($("#" + id + "_hasta_casos").val(), "DD/MM/YYYY", true);
                if(fecha_hasta.isValid() && marker[id].isAfter(fecha_hasta)){
                    ok = false;
                }
            } else {
                ok = false;
            }
        }
        
        return ok;
    },
    
    verFiltros : function(marker){
        var yo = this;
        var ok = true;
            
        ok = yo.filtroFechas(ok, marker, "fecha_inicio");
        ok = yo.filtroFechas(ok, marker, "fecha_ingreso");
        

        if($("#estado_casos").val()!=""){
            switch($("#estado_casos").val()){
                case "NULL":
                    if(marker.estado != null){
                        ok = false;
                    }
                    break;
                default:
                    if(marker.estado != $("#estado_casos").val()){
                        ok = false;
                    }
                    break;
            }
        }

        if($("#estado_casos").val() == 1){
            ok = yo.filtroFechas(ok, marker, "fecha_confirmacion");

            //no funciona el $(this).val() para el plugin chosen, se efectua parche
            var enfermedades_seleccionadas = jQuery.grep($("#formulario-casos").serializeArray(), function( a ) {
                if(a.name == "enfermedades_casos[]"){
                    return true;
                }
            });

            if(enfermedades_seleccionadas.length > 0){

                var enfermedades = jQuery.grep(marker.enfermedades , function( e ) {

                    var encontrados = jQuery.grep(enfermedades_seleccionadas, function( a ) {
                        if(a.value == e){
                            return true;
                        }
                    });

                    if(encontrados.length > 0){
                        return true;
                    }
                });

                if(enfermedades.length == 0){
                    ok = false;
                }
            }
        }
        
        return ok;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    filtrar : function(){
        var yo = this;
        $.each(casos_febriles_marcador, function(i, marker){

            var ok = yo.verFiltros(marker);

            if(!ok){
                jQuery.grep(lista_markers, function( a ) {
                    if(a["identificador"] == marker.identificador){
                        a.setVisible(false);
                    }
                });
            } else {
                jQuery.grep(lista_markers, function( a ) {
                    if(a["identificador"] == marker.identificador){
                        a.setVisible(true);
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
        var marcador = new MapaMarcador();
        $.each(casos_febriles_marcador, function(i, marker){
            marcador.removerMarcadores("identificador", marker.identificador);
        });
        
        casos_febriles_marcador = [];
    }
});

