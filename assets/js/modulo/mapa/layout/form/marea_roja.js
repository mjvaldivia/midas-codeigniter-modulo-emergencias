var MapaLayoutFormMareaRoja = Class({
    
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
            url:  siteUrl + "mapa_capas/ajax_form_filtros_marea_roja", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(html){
                $("body").append(html);

                map.controls[google.maps.ControlPosition.LEFT_CENTER].push(document.getElementById('formulario-marea-roja-contenedor'));
                
                $("#formulario-marea-roja-contenedor").css("top", "60px");
                
                $("#cerrar-filtros-marea-roja").click(function(){
                    $("#configuracion-filtros-marea-roja").trigger("click");
                });
                
                $("#configuracion-filtros-marea-roja").click(function(e){
                    e.preventDefault();
                    if ($('#filtros-marea-roja').css("display") == "none") {    // you get the idea...
                        $("#filtros-marea-roja").show("slow");
                    } else {
                        $("#filtros-marea-roja").hide("slow");
                    }
                });
                
                $("#marea_roja_resultados").ionRangeSlider({
                    type: "double",
                    min: 0,
                    max: 5000,
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
            }
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    filtrar : function(){
        var yo = this;
        var marea_roja = new MapaMareaRojaCasos();

        marea_roja.seteaMapa(yo.mapa);
        
        if($("#marea_roja").is(":checked")){
            marea_roja.filtrar();
        }
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
        
        
        if($("#marea_roja_recurso").val() != ""){
            resumen = this.agregaComa(resumen);
            resumen += "Recurso: " + $("#marea_roja_recurso option:selected").text();
        } else {
            resumen = this.agregaComa(resumen);
            resumen += "Estado: todos";
        }
        
        

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

