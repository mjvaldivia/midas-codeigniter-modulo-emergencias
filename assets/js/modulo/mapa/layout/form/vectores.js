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
                    if($(this).val() == "POSITIVO"){
                        $("#contenedor-estadio").removeClass("hidden");
                    } else {
                        $("#contenedor-estadio").addClass("hidden");
                        $("#vectores_estadio").val();
                    }
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
       
        if($("#fecha_hallazgo_desde_casos").val()!="" || $("#fecha_hallazgo_hasta_casos").val()!=""){
            resumen = this.agregaComa(resumen);
            resumen += "Fecha hallazgo: "
            if($("#fecha_hallazgo_desde_casos").val()!=""){
                resumen += $("#fecha_hallazgo_desde_casos").val();
            } else{
                resumen += "∞";
            }
            
            if($("#fecha_hallazgo_hasta_casos").val()!=""){
                resumen += " - " + $("#fecha_hallazgo_hasta_casos").val();
            } else {
                resumen += " - ∞";
            }
            
        } else {
           // resumen += descripcion + ": todas";
        }
        
         var recursos_seleccionados = jQuery.grep($("#formulario-vectores").serializeArray(), function( a ) {
            if(a.name == "vectores_estadio[]"){
                return true;
            }
        });

        if(recursos_seleccionados.length > 0){
            resumen = this.agregaComa(resumen);
            resumen += "Estadío: " + $("#vectores_estadio option:selected").text();
        }

        
        resumen += "Resultados: " + $("#vectores_resultado option:selected").text();
        
       
        $("#configuracion-filtros-vectores-resumen").html("<strong>Vectores:</strong> " + resumen);
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

