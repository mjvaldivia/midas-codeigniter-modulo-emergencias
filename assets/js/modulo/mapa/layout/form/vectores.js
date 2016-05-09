var MapaLayoutFormVectores = Class({
    
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
            url:  siteUrl + "mapa_capas/ajax_form_filtros_vectores", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("body").append(html);

                map.controls[google.maps.ControlPosition.LEFT_CENTER].push(document.getElementById('contenedor-formulario-vectores'));
                
                $("#contenedor-formulario-vectores").css("top", "60px");
                
                $("#cerrar-filtros-vectores").click(function(){
                    $("#configuracion-filtros-vectores").trigger("click");
                });
                
                $("#configuracion-filtros-vectores").click(function(e){
                    e.preventDefault();
                    if ($('#filtros-vectores').css("display") == "none") {    // you get the idea...
                        $("#filtros-vectores").show("slow");
                    } else {
                        $("#filtros-vectores").hide("slow");
                    }
                });

                
                $("#fecha_hallazgo_desde_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_hallazgo_hasta_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_hallazgo_desde_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_hallazgo_hasta_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#vectores_resultado").change(function(){
                    yo.filtrar(); 
                });

                $("#vectores_estadio").change(function(){
                    yo.filtrar();
                });
            }
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    filtrar : function(){
        var yo = this;
        
        var vectores = new MapaVectores();
        vectores.seteaMapa(yo.mapa);
        vectores.filtrar();
        
        this.resumen();
    },
    
    /**
     * Muestra resumen de los campos de la busqueda realisada
     * @returns {undefined}
     */
    resumen : function(){
       var resumen = "";
       
        if($("#marea_roja_fecha_muestra_desde").val()!="" || $("#marea_roja_fecha_muestra_hasta").val()!=""){
            resumen = this.agregaComa(resumen);
            resumen += "Fecha muestra: "
            if($("#marea_roja_fecha_muestra_desde").val()!=""){
                resumen += $("#marea_roja_fecha_muestra_desde").val();
            } else{
                resumen += "∞";
            }
            
            if($("#marea_roja_fecha_muestra_hasta").val()!=""){
                resumen += " - " + $("#marea_roja_fecha_muestra_hasta").val();
            } else {
                resumen += " - ∞";
            }
            
        } else {
           // resumen += descripcion + ": todas";
        }
        
         var recursos_seleccionados = jQuery.grep($("#formulario-marea-roja").serializeArray(), function( a ) {
            if(a.name == "marea_roja_recurso[]"){
                return true;
            }
        });

        if(recursos_seleccionados.length > 0){
            resumen = this.agregaComa(resumen);
            resumen += "Recurso: " + $("#marea_roja_recurso option:selected").text();
        }

        
        var slider = $("#marea_roja_resultados").data("ionRangeSlider");
        resumen = this.agregaComa(resumen);
        resumen += "Resultados: " + slider.result.from + " a " + slider.result.to;

        $("#configuracion-filtros-marea-roja-resumen").html("<strong>Marea roja:</strong> " + resumen);
    },
       
    /**
     * 
     * @param {type} resumen
     * @returns {String}
     */
    agregaComa : function(resumen){
        if(resumen != ""){
            resumen = resumen + ", ";
        }
        return resumen;
    }
});

