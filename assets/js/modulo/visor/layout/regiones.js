var VisorLayoutRegiones = Class({
    
    div : "",
    
    __construct : function(div) {
        this.div = div;
        this.html();
    },
    
    /**
     * Carga el HTML del buscador
     * @returns {undefined}
     */
    html : function(){
        var yo = this;
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: {},
            type: "post",
            url:  siteUrl + "usuario/json_regiones", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                   var html = "<div class=\"row hidden\">"
                     + "<div id=\"" + yo.div + "\" class=\"input-group\" style=\"width:20%;padding-right:50px;padding-top: 10px\">"
                     + "<select name=\"regiones\" id=\"regiones\" class=\"form-control\">";

                   $.each(data.regiones, function(i, region){
                       html += "<option value=\"" + region.id + "\">" + region.nombre + "</option>";
                   });

                   html += "</select>"
                        + "</div>"
                        + "</div>";
                
                    $("body").append(html);
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
            }
        });
        
        
      
    },
    
    /**
     * Agrega el buscador al mapa
     * @param {type} map
     * @returns {undefined}
     */
    addToMap : function(map){
        var yo = this;
        $("#" + this.div).parent().removeClass("hidden");
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById(this.div));
        
        $("#regiones").change(function(){
            $.ajax({         
                dataType: "json",
                cache: false,
                async: true,
                data: {"id" : $(this).val()},
                type: "post",
                url:  siteUrl + "region/json_region", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    var posicion = new google.maps.LatLng(parseFloat(data.lat), parseFloat(data.lon));
                    map.setCenter(posicion);
                }
            });
        });
        
        $("#regiones").trigger("change");
    }

});

