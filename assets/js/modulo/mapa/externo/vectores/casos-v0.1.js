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
     * Parche para corregir mapa en reporte
     * @returns {elementosAnonym$0.controlador.controller|String}
     */
    getController : function(){
        var controller = getController();  
        if(controller == "mapa" || controller == "mapa_publico"){
            return controller;
        } else {
            return "mapa";
        }
    },
    
    /**
     * Carga vectores
     * @returns {void}
     */
    load : function(){
        var tareas = new MapaLoading();
        var yo = this;
        if(vectores_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            tareas.push(1);
            $.ajax({       
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: baseUrl + yo.getController() + "/info_vectores", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            if(valor.propiedades.resultado_final == "POSITIVO"){
                                var icono = baseUrl + "assets/img/markers/otros/radar_rojo.png"
                            } else {
                                var icono = baseUrl + "assets/img/markers/otros/radar.png"
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
                                    "resultado_final" : valor.propiedades["resultado_final"],
                                    "resultado": valor.propiedades["resultado"],
                                    "estadio": valor.propiedades["estado_desarrollo"]
                                }
                            );

                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los vectores.");
                    }
                    
                    yo.loadInspecciones();
               }
            });
            
        }
    },
    
    /**
     * Carga inspecciones
     * @returns {undefined}
     */
    loadInspecciones : function(){
        var tareas = new MapaLoading();
        var yo = this;
        $.ajax({        
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: baseUrl + yo.getController() + "/info_vectores_hallazgos", 
            success:function(json){
                if(json.correcto){
                    $.each(json.lista, function(i, valor){

                        if(valor.propiedades.resultado_final == "POSITIVO"){
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
                                "resultado_final" : valor.propiedades["resultado_final"],
                                "resultado": valor.propiedades["resultado"],
                                "estadio": valor.propiedades["estado_desarrollo"]
                            }
                        );
                    });
                } else {
                    notificacionError("", "No es posible encontrar la información de los vectores.");
                }
                
                $("#contenedor-formulario-vectores").removeClass("hidden");
                yo.filtrar();
                tareas.remove(1);
           }
        });
    },
    
    /**
     * 
     * @param {type} marker
     * @returns {Boolean}
     */
    verFiltros : function(marker){
        
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
            if($("#vectores_resultado").val() == "POSITIVO"){
                if(marker["estadio"]){
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
            }
        }
        
        if(ok){
            if($("#vectores_resultado").val() != ""){
                
                if(marker["resultado_final"] &&  $("#vectores_resultado").val() != marker["resultado_final"].toUpperCase()){
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
