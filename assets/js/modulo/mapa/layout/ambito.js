var MapaLayoutAmbitoCapa = Class({
    
    /**
     * Url de la ubicacion del servicio del modulo de programacion
     */
    url_programacion : "http://200.55.194.54/programacion/rest.php/",
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
                var nombre = $(this).parent().parent().children(".nombre-ambito").html();
                yo.loadMarkers(id, nombre);
            } else {
                var marcador = new MapaMarcador();
                marcador.removerMarcadores("identificador", "instalacion_ambito_" + id);
            }
        });
    },
    
    /**
     * Carga marcadores
     * @param {type} id_ambito
     * @returns {undefined}
     */
    loadMarkers : function(id_ambito, nombre_ambito){
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
        
        var icono = yo.icono(id_ambito);
        
        var parametros = {"ambito" : id_ambito,
                          "comunas" : comunas};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "get",
            url: yo.url_programacion + "emergencia/", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.error == 0){
                    $.each(data.retorno, function(i, instalacion){
                        if(instalacion.ins_c_longitud != null && instalacion.ins_c_latitud != null){
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
                                "instalacion_ambito_" + id_ambito, 
                                null, 
                                instalacion.ins_c_longitud, 
                                instalacion.ins_c_latitud, 
                                propiedades, 
                                null, 
                                icono
                            );
                        }
                    });
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
            }
        });
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
                    $("#lista-ambitos").html("</li><li class=\"divider\"></li>");
                    $.each(data.retorno, function(i, valores){
                        var icono = yo.icono(valores.amb_ia_id);
                        $("#lista-ambitos").append(
                            "<li>"
                          + "<a href=\"javascript:void(0)\">"
                          + "<div class=\"row\">"
                            + "<div class=\"col-xs-12\">"
                                + "<div class=\"checkbox checkbox-menu\">"
                                    + "<div class=\"col-xs-12\">"
                                        + "<label>"
                                        + "<div style=\"float:left\">"
                                            + "<input class=\"menu-ambito-checkbox\" type=\"checkbox\" value=\"" + valores.amb_ia_id + "\">"
                                        + "</div>"
                                        + "<div style=\"float:left; margin-left:20px\">"
                                            + "<img height=\"30px\" src=\""+ icono+"\"/>"
                                        + "</div>"
                                        + "<div class=\"nombre-ambito\" style=\"margin-left:70px\">" + valores.amb_c_nombre + "</div>"
                                        + "</label>"
                                    + "</div>"
                                + "</div>"
                            + "</div>"
                            + "</div>"
                          + "</a>"
                          + "</li><li class=\"divider\"></li>");
                    });
                    
                    yo.bindCheck();
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
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

