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
        var yo = this;
        if(marea_roja_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Marea roja </strong> <br> Ok',
                errorMessage: '<strong> Marea roja </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Marea roja </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_marea_roja", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            if(valor.resultado == "ND" || parseInt(valor.resultado) <= 80){
                                var icono = baseUrl + "assets/img/markers/marisco/1.png"
                            } else {
                       
                                if(parseInt(valor.resultado) > 80 && parseInt(valor.resultado) <= 120){
                                    var icono = baseUrl + "assets/img/markers/marisco/6.png";
                                }

                                if(parseInt(valor.resultado) > 120 && parseInt(valor.resultado) <= 200 ){
                                    var icono = baseUrl + "assets/img/markers/marisco/6.png";
                                }

                                if(parseInt(valor.resultado) > 200 && parseInt(valor.resultado) <= 1000){
                                    var icono = baseUrl + "assets/img/markers/marisco/6.png";
                                } 
                                
                                if(parseInt(valor.resultado) > 1000 && parseInt(valor.resultado) <= 3000){
                                    var icono = baseUrl + "assets/img/markers/marisco/6.png";
                                } 
                                
                                if(parseInt(valor.resultado) > 3000){
                                    var icono = baseUrl + "assets/img/markers/marisco/6.png";
                                } 
                            }
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("marea_roja_" + valor.id, null, valor.lng, valor.lat, valor.propiedades, null, icono);
                            
                            var fecha_muestra = moment(valor.propiedades["FECHA"], "DD-MM-YYYY", true);
                            
                            marea_roja_marcador.push(
                                {
                                    "identificador" : "marea_roja_" + valor.id,
                                    "fecha_muestra" : fecha_muestra,
                                    "recurso": valor.propiedades["RECURSO"]
                                }
                            );

                        });
                        
                        yo.filtrar();
                    } else {
                        notificacionError("", "No es posible encontrar la información de la marea roja.");
                    }
                    
                    $("#formulario-marea-roja-contenedor").removeClass("hidden");
               }
            });
        }
    },
    
    
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
