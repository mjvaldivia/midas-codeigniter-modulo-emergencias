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
     * Crea el menu de ambitos
     * @returns {undefined}
     */
    render : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: "id=" + yo.id_emergencia,
            type: "POST",
            url:  siteUrl + "mapa_capas/ajax_capas_disponibles_emergencia", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                //$(".capas-columna").html("");
                $.each(data.lista, function(i, valores){
                    
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
            }
        });
    },
    
    renderCapas : function(lista, columna){
        var yo = this;
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
    },
    
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
                + "<input class=\"menu-capa-checkbox\" type=\"checkbox\" value=\"" + valores.id + "\" /> "
                + preview + " "
                + valores.nombre 
                + "</a>"
              + "</li>"
            );
        });
        
    },
    
    getColor : function(color){
      return "<span class=\"color-capa-preview\" style=\"background-color:" + color + ";\"></span>";  
    },
    
    /**
     * 
     * @param {string} icono
     * @returns {String}
     */
    getIcono : function(icono){
        return "<img src=\"" +  baseUrl + icono + "\" title=\"Icono de capa\" style=\"height: 15px;\"  >";
    }
});


