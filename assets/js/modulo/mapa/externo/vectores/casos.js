var vectores_marcador = [];

var MapaVectores = Class({  
    
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
        if(vectores_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Vectores </strong> <br> Ok',
                errorMessage: '<strong> Vectores </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Vectores</strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: siteUrl + "mapa/info_vectores", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            if(valor.propiedades.resultado == "Negativo"){
                                var icono = baseUrl + "assets/img/markers/otros/radar.png"
                            } else {
                                var icono = baseUrl + "assets/img/markers/otros/radar_rojo.png"
                            }
                            //var icono = baseUrl + "assets/img/markers/vectores.png"
                            
                            var marcador = new MapaMarcador();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("vectores_" + valor.id, null , valor.lng, valor.lat, valor.propiedades, null, icono);
                            
                            var fecha_hallazgo = moment(valor.propiedades.fecha_hallazgo, "DD/MM/YYYY", true);
                            
                            vectores_marcador.push(
                                {
                                    "identificador" : "vectores_" + valor.id,
                                    "tipo" : "VECTOR",
                                    "fecha_hallazgo" : fecha_hallazgo,
                                    "resultado": valor.propiedades["resultado"],
                                    "estadio": valor.propiedades["estado_desarrollo"]
                                }
                            );

                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los casos febriles.");
                    }
                    
                    yo.loadInspecciones();
               }
            });
            
        }
    },
    
    
    loadInspecciones : function(){
        var yo = this;
        Messenger().run({
            action: $.ajax,
            successMessage: '<strong> Inspecciones </strong> <br> Ok',
            errorMessage: '<strong> Inspecciones </strong> <br> No se pudo recuperar la información de los casos. <br/> Espere para reintentar',
            showCloseButton: true,
            progressMessage: '<strong> Inspecciones </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
        },{        
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "mapa/info_vectores_hallazgos", 
            success:function(json){
                if(json.correcto){
                    $.each(json.lista, function(i, valor){

                        if(valor.propiedades.resultado == "Negativo"){
                            var icono = baseUrl + "assets/img/markers/otros/mosquito-3.png"
                        } else {
                            var icono = baseUrl + "assets/img/markers/otros/mosquito.png"
                        }

                        var marcador = new MapaMarcador();
                        marcador.seteaMapa(yo.mapa);
                        marcador.posicionarMarcador("vectores_inspecciones_" + valor.id, null , valor.lng, valor.lat, valor.propiedades, null, icono);

                        var fecha_hallazgo = moment(valor.propiedades.fecha_hallazgo, "DD/MM/YYYY", true);

                        vectores_marcador.push(
                            {
                                "identificador" : "vectores_inspecciones_" + valor.id,
                                "tipo" : "INSPECCION",
                                "fecha_hallazgo" : fecha_hallazgo,
                                "resultado": valor.propiedades["resultado"],
                                "estadio": valor.propiedades["estado_desarrollo"]
                            }
                        );
                    });
                } else {
                    notificacionError("", "No es posible encontrar la información de los casos febriles.");
                }
                
                $("#contenedor-formulario-vectores").removeClass("hidden");
                yo.filtrar();
           }
        });
    },
    
    /**
     * 
     * @param {type} marker
     * @returns {Boolean}
     */
    verFiltros : function(marker){
        console.log(marker);
        var yo = this;
        var ok = true;
            
        if($("#fecha_hallazgo_desde_casos").val() != ""){
            if(marker["fecha_hallazgo"].isValid()){
                var fecha_desde = moment($("#fecha_hallazgo_desde_casos").val(), "DD/MM/YYYY", true);
                if(fecha_desde.isValid() && marker["fecha_hallazgo"].isBefore(fecha_desde)){
                    ok = false;
                }
            } else {
                ok = false;
            }
        }
        
        if(ok){
            if($("#fecha_hallazgo_hasta_casos").val() != ""){
                if(marker["fecha_hallazgo"].isValid()){
                    var fecha_hasta = moment($("#fecha_hallazgo_hasta_casos").val(), "DD/MM/YYYY", true);
                    if(fecha_hasta.isValid() && marker["fecha_hallazgo"].isAfter(fecha_hasta)){
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
            var recursos_seleccionados = jQuery.grep($("#formulario-vectores").serializeArray(), function( a ) {
                if(a.name == "vectores_estadio[]"){
                    return true;
                }
            });

            if(recursos_seleccionados.length > 0){

                var encontrados = jQuery.grep(recursos_seleccionados, function( a ) {
                    if(a.value == marker["estadio"].toUpperCase()){
                        return true;
                    }
                });

                if(encontrados.length == 0){
                    ok = false;
                }
            }        
        }
        
        if(ok){
            
            if($("#vectores_resultado").val()!=""){
                if(marker["resultado"] &&  $("#vectores_resultado").val() != marker["resultado"].toUpperCase()){
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
        $.each(vectores_marcador, function(i, marker){
            
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
        $.each(vectores_marcador, function(i, marker){
            marcador.removerMarcadores("identificador", marker.identificador);
        });
        
        vectores_marcador = [];
    }
});
