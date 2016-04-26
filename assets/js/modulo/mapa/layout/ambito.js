
var instalaciones_agregadas = [];

var MapaLayoutAmbitoCapa = Class({
    
    /**
     * Url de la ubicacion del servicio del modulo de programacion
     */
    url_programacion : "http://200.55.194.54/programacion/rest.php/",
   // url_programacion : "http://development.programacion.midas.cl/sipresa/rest.php/",
    
    mapa : null,
    id_emergencia : null,
    
    /**
     * 
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
      this.mapa = mapa;  
    },
    
    /**
     * 
     * @param {type} id
     * @returns {undefined}
     */
    seteaEmergencia : function(id){
      this.id_emergencia = id;  
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindCheck : function(){
        var yo = this;
        $(".menu-ambito-checkbox").click(function(){
            
            var id = $(this).val();

            if($(this).is(":checked")){
                var nombre = "";
                if(id == 1  && (jQuery.type($(this).attr("data")) === "undefined" || $(this).attr("data") == "")){  
                    
                    $(".menu-ambito-checkbox").each(function(i){
                        if($(this).val() == 1){
                            if(jQuery.type($(this).attr("data")) !== "undefined"){
                                $(this).prop('checked', true);
                            }
                        }
                    });
                    
                    
                    $(".menu-ambito-checkbox").each(function(i){
                        if($(this).val() == 1){
                            if(jQuery.type($(this).attr("data")) !== "undefined"){
                                yo.loadMarkers(id, nombre, $(this).attr("data"), false);
                            }
                        }
                    });
                    
                } else {
                    if(jQuery.type($(this).attr("data")) === "undefined"){
                        var tipos = "";
                    } else {
                        var tipos = $(this).attr("data");
                    }
                    yo.loadMarkers(id, nombre, tipos, true);
                }
            } else {
                
                if(id == 1  && (jQuery.type($(this).attr("data")) === "undefined" || $(this).attr("data") == "")){
                    
                    $(".menu-ambito-checkbox").each(function(i){
                        if($(this).val() == 1){
                            if(jQuery.type($(this).attr("data")) !== "undefined"){
                                $(this).prop('checked', false);
                                var identificador = "instalacion_ambito_" + id + "_" + $(this).attr("data");
                                var marcador = new MapaMarcador();
                                marcador.removerMarcadores("identificador", identificador);
                                
                                instalaciones_agregadas = jQuery.grep(instalaciones_agregadas, function( a ) {
                                    if(a["identificador"] != identificador){
                                        return true;
                                    }
                                });
                            }
                        }
                    });
                    
                } else {
                    
                    if(jQuery.type($(this).attr("data")) === "undefined"){
                        var identificador = "instalacion_ambito_" + id;
                    } else {
                        var identificador = "instalacion_ambito_" + id + "_" + $(this).attr("data");
                    }

                    var marcador = new MapaMarcador();
                    marcador.removerMarcadores("identificador", identificador);
                    
                    instalaciones_agregadas = jQuery.grep(instalaciones_agregadas, function( a ) {
                        if(a["identificador"] != identificador){
                            return true;
                        }
                    });
                }
            }
        });
    },
    
    /**
     * 
     * @returns {com.com_c_nombre}
     */
    loadComunas : function(){
        var yo = this;
        var comunas = {};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: {"id" : yo.id_emergencia},
            type: "post",
            url:  siteUrl + "evento/ajax_comunas_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    $.each(data.comunas, function(i, com){
                        comunas[i] = com.com_c_nombre;
                    });
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
            }
        });
        
        return comunas;
    },
    
    
    
    /**
     * Carga marcadores
     * @param {type} id_ambito
     * @returns {undefined}
     */
    loadMarkers : function(id_ambito, nombre_ambito, tipos_instalacion, loading){
        var yo = this;
        
        var comunas = this.loadComunas();
        var icono = yo.icono(id_ambito);
        
        var parametros = {"ambito" : id_ambito,
                          "comunas" : comunas};
                      
        var identificador = "instalacion_ambito_" + id_ambito;
        if(tipos_instalacion != ""){
            parametros["tipo"] = tipos_instalacion;
            identificador = identificador + "_" + tipos_instalacion;
        }        
        
        if(loading){
            var box = bootbox.dialog({
                message: '<div id=\"ambito-cargando\" class=\"row\"><div class=\"col-xs-12 text-center\"><i class="fa fa-3x fa-spin fa-spinner"></i> <br/> Procesando información </div> </div>',
                buttons: {}
            });
        }
        
        var carga = function(){
            $.ajax({         
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "get",
                url: yo.url_programacion + "emergencia", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    if(data.error == 0){
                        $.each(data.retorno, function(i, instalacion){
                            if(instalacion.ins_c_longitud != null && instalacion.ins_c_latitud != null){
                                
                                var arr = jQuery.grep(instalaciones_agregadas, function( a ) {
                                    if(a["id"] == instalacion.ins_ia_id){
                                        return true;
                                    }
                                });
                                
                                if(arr.length == 0){
                                    var propiedades = {
                                        "NOMBRE" : instalacion.ins_c_nombre_fantasia,
                                        "TIPO" : "INSTALACIÓN",
                                        "AMBITO" : nombre_ambito,
                                        "RUT RAZÓN SOCIAL" : instalacion.ins_c_rut,
                                        "NOMBRE RAZÓN SOCIAL": instalacion.ins_c_razon_social,
                                        "RUT REPRESENTANTE" : instalacion.ins_c_rut_representante,
                                        "NOMBRE REPRESENTANTE" : instalacion.ins_c_nombre_representante,
                                        "DIRECCIÓN" : instalacion.ins_c_nombre_direccion + " " + instalacion.ins_c_numero_direccion
                                    };

                                    var marcador = new MapaMarcador();
                                    marcador.seteaMapa(yo.mapa);
                                    marcador.posicionarMarcador(
                                        identificador, 
                                        null, 
                                        instalacion.ins_c_longitud, 
                                        instalacion.ins_c_latitud, 
                                        propiedades, 
                                        null, 
                                        icono
                                    );
                            
                                    instalaciones_agregadas.push(
                                        {
                                        "id" : instalacion.ins_ia_id,
                                        "identificador" : identificador
                                        }
                                    );
                                }
                        
                            }
                        });
                    } else {
                        notificacionError("Ha ocurrido un problema", data.mensaje);
                    }
                    if(loading){
                        bootbox.hideAll();
                    }
                }
            });
        }
        
        if(loading){
            box.on("shown.bs.modal", function() {
                carga();
            });
        } else {
            carga();
        }
    },
    
    renderTiposInstalacion : function(ambito, columna){
        var yo = this;
        var icono = this.icono(ambito);
        var html = "<li class=\"divider\"></li>";
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: "ambito=" + ambito,
            type: "get",
            url: yo.url_programacion + "tipoinstalacion", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                 if(data.error == 0){

                    $.each(data.retorno, function(i, valores){
                        $("#" + columna).append("<li><a href=\"#\"><input data=\"" + valores.aux_ia_id + "\" type=\"checkbox\" class=\"menu-ambito-checkbox\" value=\"" + ambito + "\"> " + valores.aux_c_nombre + "</a></li>");
                    });

                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
            }
        });
        return html;
    },
    
    /**
     * Crea el menu de ambitos
     * @returns {undefined}
     */
    render : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "",
            type: "get",
            url: yo.url_programacion + "ambito", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.error == 0){
                    $(".instalaciones-columna").html("");
                    $.each(data.retorno, function(i, valores){
                        var icono = yo.icono(valores.amb_ia_id);
                        
                        var columna = "instalaciones-columna-1";
                        $(".instalaciones-columna").each(function(){
                            if($("#" + $(this).attr("id") + " li").length < $("#" + columna + " li").length){
                                columna = $(this).attr("id");
                            }
                        });
                        
                        if($("#" + columna + " li").length != 0){
                            $("#" + columna).append("<li class=\"divider\"></li>");
                        }
                        
                        $("#" + columna).append(
                            "<li class=\"dropdown-header\"> <img src=\"" + icono + "\" /> " 
                            + valores.amb_c_nombre 
                            + " <input type=\"checkbox\" class=\"menu-ambito-checkbox\" value=\"" + valores.amb_ia_id + "\"> </li>");
                        
                        //if(valores.amb_ia_id == 1){
                            yo.renderTiposInstalacion(valores.amb_ia_id, columna);
                        //}

                    });
                    
                    yo.bindCheck();
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
                
                var height = $(window).height();

                $("#instalaciones-menu").css("height", height - 150);
            }
        });
    },
        
    /**
     * 
     * @param {int} id
     * @returns {String}
     */
    icono : function(id){
        switch(id){
            case "1":
                var icono = baseUrl + "assets/img/markers/ambitos/alimentos.png";
                break;
            case "2":
                var icono = baseUrl + "assets/img/markers/ambitos/agua.png";
                break;
            case "3":
                var icono = baseUrl + "assets/img/markers/ambitos/zoonosis.png";
                break;
            case "4":
                var icono = baseUrl + "assets/img/markers/ambitos/profesiones_medicas.png";
                break;
            case "5":
                var icono = baseUrl + "assets/img/markers/ambitos/quimica.png";
                break;
            case "6":
                var icono = baseUrl + "assets/img/markers/ambitos/aire.png";
                break;
            case "7":
                var icono = baseUrl + "assets/img/markers/ambitos/residuos.png";
                break;
            case "8":
                var icono = baseUrl + "assets/img/markers/ambitos/farmaceutica.png";
                break;
            case "9":
                var icono = baseUrl + "assets/img/markers/ambitos/salud.png";
                break;
            case "10":
                var icono = baseUrl + "assets/img/markers/ambitos/uso_comunitario.png";
                break;
            default:
                var icono = baseUrl + "assets/img/markers/spotlight-poi.png";
                break;
        }
        return icono;
    }
    
});

