var MapaLayoutFormCasosFebrilesFecha = Class({
    
    mapa : null,

    __construct : function(div) {

    },

    /**
     * Agrega el buscador al mapa
     * @param {type} map
     * @returns {undefined}
     */
    addToMap : function(map){
        
        var yo = this;
        
        this.mapa = map;
        
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: {},
            type: "post",
            url:  siteUrl + "mapa_capas/ajax_form_filtros_casos_febriles", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("body").append(html);

                
                
                map.controls[google.maps.ControlPosition.LEFT_CENTER].push(document.getElementById('formulario-casos-rango'));
                $("#formulario-casos-rango").css("top", "60px");
                
                $("#configuracion-filtros-casos").click(function(){
                    if ($('#filtros-casos').css("display") == "none") {    // you get the idea...
                        $("#filtros-casos").show("slow");
                    } else {
                        $("#filtros-casos").hide("slow");
                    }
                });
                
                $("#fecha_desde_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_hasta_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#estado_casos").change(function(){
                   if($(this).val()==1){
                       $("#enfermedades_casos").removeClass("hidden");
                   } else {
                       $("#enfermedades_casos").addClass("hidden");
                   }
                });
                
                $("#btn-buscar-casos-febriles").click(function(){
                   yo.filtrar(); 
                });
            }
        });
    },
    
    filtrar : function(){
        var yo = this;
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
        
        var resumen = "";
        
        if($("#fecha_desde_casos").val()!="" || $("#fecha_hasta_casos").val()!=""){
            
            if($("#fecha_desde_casos").val()!=""){
                resumen += "Desde: " + $("#fecha_desde_casos").val();
            }
            
            if($("#fecha_hasta_casos").val()!=""){
                resumen = yo.agregaComa(resumen);
                resumen += "Hasta: " + $("#fecha_hasta_casos").val();
            }
            
        } else {
            resumen += "Fechas: todas";
        }
        
        if($("#estado_casos").val() != ""){
            resumen = yo.agregaComa(resumen);
            resumen += "Estado: " + $("#estado_casos option:selected").text();
        } else {
            resumen = yo.agregaComa(resumen);
            resumen += "Estado: todos";
        }
        
        $("#configuracion-filtros-resumen").html(resumen);
    },
    
    
    agregaComa : function(resumen){
        if(resumen != ""){
            resumen = resumen + ", ";
        }
        return resumen;
    }
});

