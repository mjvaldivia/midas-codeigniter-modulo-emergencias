var MapaLayoutFormCasosFebrilesFecha = Class({
    
    mapa : null,

    __construct : function(div) {
        this.html();
    },
    
    /**
     * Agrega el buscador al mapa
     * @param {type} map
     * @returns {undefined}
     */
    addToMap : function(map){
        this.mapa = map;
        map.controls[google.maps.ControlPosition.LEFT_CENTER].push(document.getElementById('formulario-casos-rango'));
        $("#formulario-casos-rango").css("top", "60px");
    },

     /**
     * Carga el HTML del buscador
     * @returns {undefined}
     */
    html : function(){
        
        var yo = this;
      $("body").append("<div id=\"formulario-casos-rango\" class=\"form-busqueda hidden\">"
                     + "<div class=\"panel panel-primary panel-mapa\">"
                        + "<div class=\"panel-heading\">Rangos de fecha</div>"
                            + "<div class=\"panel-body\">"
                                + "<div class=\"form-group clearfix\">"
                                     + "<label for=\"fecha_desde_casos\" class=\"col-sm-4 text-right control-label required\">Desde :</label>"
                                     + "<div class=\"col-sm-8\">"
                                     + "<input id=\"fecha_desde_casos\" type\"text\" class=\"form-control datepicker-date\" />"
                                     + "<span class=\"help-block hidden\"></span>"
                                     + "</div>"
                                + "</div>"
                                + "<div class=\"form-group clearfix\">"
                                     + "<label for=\"fecha_hasta_casos\" class=\"col-sm-4 text-right control-label required\">Hasta :</label>"
                                     + "<div class=\"col-sm-8\">"
                                     + "<input id=\"fecha_hasta_casos\" type\"text\" value=\"\" class=\"form-control datepicker-date\" />"
                                     + "<span class=\"help-block hidden\"></span>"
                                     + "</div>"
                                + "</div>"
                                + "<div class=\"form-group clearfix\">"
                                + "<div class=\"col-sm-4\"></div>"
                                + "<div class=\"col-sm-8\"><input type\"button\" id=\"btn-buscar-casos-febriles\" class=\"btn btn-xs btn-primary\" value=\"Filtrar\" /></div>"
                                + "</div>"
                            + "</div>"
                        + "</div>"
                     + "</div>"
                     + "</div>");
             
             
        $("#btn-buscar-casos-febriles").click(function(){
           
           var rapanui_casos = new MapaIslaDePascuaCasos();
           var rapanui_zonas = new MapaIslaDePascuaZonas();
           
           rapanui_casos.seteaMapa(yo.mapa);
           rapanui_zonas.seteaMapa(yo.mapa);
           
           rapanui_casos.remove();
           rapanui_zonas.remove();
           
           if($("#importar_rapanui_casos").is(":checked")){
               rapanui_casos.load();
           }
           
           if($("#importar_rapanui_zonas").is(":checked")){
               rapanui_zonas.load();
           }
           
        });
    }

});

