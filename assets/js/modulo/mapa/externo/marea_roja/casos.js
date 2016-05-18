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
         var tareas = new MapaLoading();
        var yo = this;
        if(marea_roja_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            
            $("#marea_roja").attr("disabled", true);
            $("#marea_roja_pm").attr("disabled", true);
            
            tareas.push(1);
            $.ajax({        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_marea_roja", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            var icono = yo.coloresIcono(valor);
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("marea_roja_" + valor.id, null, valor.lng, valor.lat, valor.propiedades, null, icono);
                            
                            var fecha_muestra = moment(valor.fecha_muestra, "DD-MM-YYYY", true);
                            
                            marea_roja_marcador.push(
                                {
                                    "identificador" : "marea_roja_" + valor.id,
                                    "fecha_muestra" : fecha_muestra,
                                    "recurso": valor.propiedades["RECURSO"],
                                    "resultados": valor.propiedades["RESULTADO"]
                                }
                            );

                        });
                        
                        $("#formulario-marea-roja-contenedor").waitUntilExists(function(){
                            yo.filtrar();
                        });
                        
                    } else {
                        notificacionError("", "No es posible encontrar la información de la marea roja.");
                    }
                    
                    //$("#formulario-marea-roja-contenedor").waitUntilExists(function(){
                        $("#formulario-marea-roja-contenedor").removeClass("hidden");
                    //});
                    
                    $("#marea_roja").attr("disabled", false);
                    $("#marea_roja_pm").attr("disabled", false);
                    
                     tareas.remove(1);
               }
            });
        }
    },
    
    /**
     * 
     * @param {object} valor
     * @returns {String}
     */
    coloresIcono : function(valor){
        var icono = "";
        if(valor.resultado == "ND" || valor.resultado == "nd"){
            icono = baseUrl + "assets/img/markers/marisco/marcador-verde.png"
        } else {
            
            if(50 > parseInt(valor.resultado)){
                icono = baseUrl + "assets/img/markers/marisco/marcador-azul.png";
            }
            
            if( 80 > parseInt(valor.resultado) && parseInt(valor.resultado) >= 50){
                icono = baseUrl + "assets/img/markers/marisco/marcador-amarillo.png";
            }
            
            if(parseInt(valor.resultado) >= 80){
                icono = baseUrl + "assets/img/markers/marisco/marcador-rojo.png";
            }
            
        }
        
        return icono;
    },
    
    /**
     * 
     * @param {type} marker
     * @returns {Boolean}
     */
    verFiltros : function(marker){
        var yo = this;
        var ok = true;
            
        if($("#marea_roja_fecha_muestra_desde").val() != ""){
            if(marker["fecha_muestra"].isValid()){
                var fecha_desde = moment($("#marea_roja_fecha_muestra_desde").val(), "DD/MM/YYYY", true);
                if(fecha_desde.isValid() && marker["fecha_muestra"].isBefore(fecha_desde)){
                    ok = false;
                }
            } else {
                ok = false;
            }
        }
        
        if(ok){
            if($("#marea_roja_fecha_muestra_hasta").val() != ""){
                if(marker["fecha_muestra"].isValid()){
                    var fecha_hasta = moment($("#marea_roja_fecha_muestra_hasta").val(), "DD/MM/YYYY", true);
                    if(fecha_hasta.isValid() && marker["fecha_muestra"].isAfter(fecha_hasta)){
                        ok = false;
                    }
                } else {
                    ok = false;
                }
            }
        }
        
        if(ok && marker["resultados"]){
            var slider = $("#marea_roja_resultados").data("ionRangeSlider");
            //console.log(marker["resultados"]);
            if(slider.result.from != 0 && marker["resultados"] == "ND"){
                ok = false;
            } else {
                if(marker["resultados"] != "ND"){
                    if(slider.result.from > parseInt(marker["resultados"])){
                        ok = false;
                    }
                    
                    if(slider.result.to < parseInt(marker["resultados"])){
                        ok = false;
                    }
                }
                
            }
        }
        
        if(ok){
            
            //console.log($("#formulario-marea-roja").serializeArray());
            //no funciona el $(this).val() para el plugin chosen, se efectua parche
            var recursos_seleccionados = jQuery.grep($("#formulario-marea-roja").serializeArray(), function( a ) {
                if(a.name == "marea_roja_recurso[]"){
                    return true;
                }
            });

            if(recursos_seleccionados.length > 0){

                var encontrados = jQuery.grep(recursos_seleccionados, function( a ) {
                    if(a.value == marker["recurso"].toUpperCase()){
                        return true;
                    }
                });

                if(encontrados.length == 0){
                    ok = false;
                }
            }        
        }
        
        if(ok && marker["resultados"]){
            var retorno = false;
            $(".marea-roja-color").each(function(i, obj){
                if($(obj).is(":checked")){
                    if($(obj).data("only")){
                        if(marker["resultados"].toUpperCase() == $(obj).data("only")){
                            retorno = true;
                        }
                    } else {
                        
                        if($(obj).data("add")){
                            if(marker["resultados"].toUpperCase() == $(obj).data("add")){
                                retorno = true;
                            }
                        }
                        
                        
                        if($(obj).data("to") && $(obj).data("to")!=""){
                            if(parseInt(marker["resultados"]) >= parseInt($(obj).data("from")) && parseInt(marker["resultados"]) <= parseInt($(obj).data("to"))){
                                retorno = true;
                            }
                        } else {
                            if(parseInt(marker["resultados"]) >= parseInt($(obj).data("from"))){
                                retorno = true;
                            }
                        }
                    }
                }
            });
            
            ok = retorno;
        }
        
        
        return ok;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    filtrar : function(){
        var yo = this;
        $.each(marea_roja_marcador, function(i, marker){
            
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
        $.each(marea_roja_marcador, function(i, marker){
            marcador.removerMarcadores("identificador", marker.identificador);
        });
        
        marea_roja_marcador = [];
    }
});
