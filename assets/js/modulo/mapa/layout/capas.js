var MapaLayoutCapas = Class({
    
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
    callCapas : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + this.id_emergencia,
            type: "POST",
            url:  siteUrl + "mapa_capas/ajax_capas_disponibles_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                yo.renderCategorias(data.lista);
                yo.checkCapasRelacionadas();
            }
        });
    },
    
    checkCapasRelacionadas : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + this.id_emergencia,
            type: "POST",
            url:  siteUrl + "mapa_capas/ajax_capas_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                
                $.each(data.capas, function(i, valor){
                    $('.menu-capa-checkbox').filter(function(){
                        return this.value == valor.id}
                     ).prop('checked', true);
                });
                
                if(data.capas_fijas.conaf == 1){
                    $("#importar_sidco").prop('checked', true);
                }
                
                if(data.capas_fijas.casos_febriles == 1){
                    $("#importar_rapanui_casos").prop('checked', true);
                }
                
                if(data.capas_fijas.casos_febriles_zona == 1){
                    $("#importar_rapanui_zonas").prop('checked', true);
                }
            }
        });
    },
    
    /**
     * Crea el menu de ambitos
     * @returns {undefined}
     */
    render : function(){
        $(".capas-columna").html("");
        this.callCapas();
                
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "POST",
            url:  siteUrl + "mapa_capas/ajax_menu_capas_fijas", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("#capas-columna-4").append(html);
            }
        });
    },
    
    /**
     * 
     * @param {type} lista
     * @returns {undefined}
     */
    renderCategorias : function(lista){
        var yo = this;
        $.each(lista, function(i, valores){

            if(valores.lista.length > 0){

                var columna = "capas-columna-1";
                $(".capas-columna").each(function(){
                    if($("#" + $(this).attr("id") + " li").length < $("#" + columna + " li").length){
                        columna = $(this).attr("id");
                    }
                });

                if($("#" + columna + " li").length != 0){
                    $("#" + columna).append("<li class=\"divider\"></li>");
                }

                $("#" + columna).append(
                    "<li class=\"dropdown-header\">"
                    + valores.nombre 
                    + "</li>"
                );

                yo.renderCapas(valores.lista, columna);
            }
        });   

        var height = $(window).height();
        $("#capas-menu").css("max-height:", height - 150);
    },
    
    /**
     * 
     * @param {type} lista
     * @param {type} columna
     * @returns {undefined}
     */
    renderCapas : function(lista, columna){
        var yo = this;
        
        if(lista.length == 1){
            yo.renderSubcapas(lista[0].lista, columna, lista[0].icono, lista[0].color);
        } else {
            $.each(lista, function(i, valores){
                if(valores.lista.length > 0){
                    if(valores.lista.length == 1){
                        yo.renderSubcapas(valores.lista, columna, valores.icono, valores.color);
                    } else {
                        $("#" + columna).append("<li><a href=\"#\">" + valores.nombre + "</a></li>");
                        yo.renderSubcapas(valores.lista, columna, valores.icono, valores.color);
                    }
                }
            });
        }
    },
    
    /**
     * 
     * @param {type} lista
     * @param {type} columna
     * @param {type} icono
     * @param {type} color
     * @returns {undefined}
     */
    renderSubcapas : function(lista, columna, icono, color){
        var yo = this;
        $.each(lista, function(i, valores){
            
            var preview = "";
            
            if(valores.icono != null){
                preview = yo.getIcono(valores.icono);
            } else {
                if(icono != null){
                    preview = yo.getIcono(icono);
                }
            }
            
            if(valores.color != null){
                preview = yo.getColor(valores.color);
            } else {
                if(color != null){
                    preview = yo.getColor(color);
                }
            }
            
            $("#" + columna).append(
                "<li>"
                + "<a href=\"javascript:void(0)\">" 
                + "<input class=\"menu-capa-checkbox en-linea\" type=\"checkbox\" value=\"" + valores.id + "\" /> "
                + preview + " "
                + valores.nombre 
                + "</a>"
              + "</li>"
            );
        });
        
    },
    
    /**
     * 
     * @param {type} color
     * @returns {String}
     */
    getColor : function(color){
      return "<div class=\"color-capa-preview en-linea\" style=\"background-color:" + color + ";\"></div>";  
    },
    
    /**
     * 
     * @param {string} icono
     * @returns {String}
     */
    getIcono : function(icono){
        return "<img src=\"" +  baseUrl + icono + "\" class=\"en-linea\" title=\"Icono de capa\" style=\"height: 15px;\"  >";
    }
});


