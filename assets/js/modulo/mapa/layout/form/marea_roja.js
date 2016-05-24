var MapaLayoutFormMareaRoja = Class({
    
    mapa : null,
    
    posicion: "LEFT_CENTER",
    
    __construct : function(div) {

    },
    
    /**
     * 
     * @param {string} posicion
     * @returns {undefined}
     */
    seteaPosicion : function(posicion){
      this.posicion = posicion;  
    },
    
    addExcelToMap : function(map){
        
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
            url:  siteUrl + "mapa_capas/ajax_form_filtros_marea_roja", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("body").append(html);

                map.controls[google.maps.ControlPosition[yo.posicion]].push(document.getElementById('formulario-marea-roja-contenedor'));
                
                $("#formulario-marea-roja-contenedor").css("top", "60px");
                
                $("#cerrar-filtros-marea-roja").click(function(){
                    $("#configuracion-filtros-marea-roja").trigger("click");
                });
                
                $("#configuracion-filtros-marea-roja").click(function(e){
                    e.preventDefault();
                    if ($('#filtros-marea-roja').css("display") == "none") { 
                        $("#filtros-marea-roja").show("slow");
                    } else {
                        $("#filtros-marea-roja").hide("slow");
                    }
                });
                
                $("#marea_roja_resultados").ionRangeSlider({
                    type: "double",
                    min: 0,
                    max: 30000,
                    grid: true,
                    step: 10,
                    keyboard: true,
                    keyboard_step: 1,
                    onFinish: function (data) {
                        yo.filtrar(); 
                    }
                });
                
                $("#marea_roja_fecha_muestra_desde").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#marea_roja_fecha_muestra_hasta").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#marea_roja_fecha_muestra_desde").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#marea_roja_fecha_muestra_hasta").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#marea_roja_recurso").change(function(){
                    yo.filtrar(); 
                });
                
                $(".marea-roja-color").click(function(){
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
        
        if($("#marea_roja_pm").is(":checked")){
            var marea_roja = new MapaMareaRojaCasosPm();
        } else {
            var marea_roja = new MapaMareaRojaCasos();
        }
        
        
        marea_roja.seteaMapa(yo.mapa);
        
        if($("#marea_roja").is(":checked") || $("#marea_roja_pm").is(":checked") || $("#marea_roja").length == 0){
            marea_roja.filtrar();
        }
        
        console.log("Filtrando");
        
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

