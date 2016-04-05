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
                
                $("#cerrar-filtros-casos-febriles").click(function(){
                    $("#configuracion-filtros-casos").trigger("click");
                });
                
                $("#configuracion-filtros-casos").click(function(e){
                    e.preventDefault();
                    if ($('#filtros-casos').css("display") == "none") {    // you get the idea...
                        $("#filtros-casos").show("slow");
                    } else {
                        $("#filtros-casos").hide("slow");
                    }
                });
                
                $("#fecha_inicio_desde_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_inicio_hasta_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_ingreso_desde_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_ingreso_hasta_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_confirmacion_desde_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_confirmacion_hasta_casos").datetimepicker({
                    format: "DD/MM/YYYY",
                    locale: "es"
                });
                
                $("#fecha_inicio_desde_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_inicio_hasta_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_ingreso_desde_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_ingreso_hasta_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_confirmacion_desde_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#fecha_confirmacion_hasta_casos").on("dp.change", function(){
                    yo.filtrar(); 
                });
                
                $("#estado_casos").change(function(){
                    if($(this).val()==1){
                       $("#enfermedades_casos").removeClass("hidden");
                    } else {
                       $("#enfermedades_casos").addClass("hidden");
                    }
                    yo.filtrar(); 
                });
                
                $("#enfermedades_casos").on('change', function(evt, params) {
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
        var rapanui_casos = new MapaIslaDePascuaCasos();
        var rapanui_zonas = new MapaIslaDePascuaZonas();

        rapanui_casos.seteaMapa(yo.mapa);
        rapanui_zonas.seteaMapa(yo.mapa);

        //rapanui_casos.remove();
       // rapanui_zonas.remove();

        if($("#importar_rapanui_casos").is(":checked")){
            rapanui_casos.filtrar();
        }

        if($("#importar_rapanui_zonas").is(":checked")){
            rapanui_zonas.filtrar();
        }
        
        
        this.resumen();
        
    },
    
    /**
     * Muestra resumen de los campos de la busqueda realisada
     * @returns {undefined}
     */
    resumen : function(){
       var resumen = "";
       resumen = this.resumenFecha(resumen, "Fecha ingreso", "ingreso");
       resumen = this.resumenFecha(resumen, "Fecha inicio", "inicio");
        
        
        if($("#estado_casos").val() != ""){
            resumen = this.agregaComa(resumen);
            resumen += "Estado: " + $("#estado_casos option:selected").text();
            
            if($("#estado_casos").val() == 1){
               
                resumen = this.resumenFecha(resumen, "Fecha confirmación", "confirmacion");
            }
            
        } else {
            resumen = this.agregaComa(resumen);
            resumen += "Estado: todos";
        }
        
        //no funciona el $(this).val() para el plugin chosen, se efectua parche
        var enfermedades_seleccionadas = jQuery.grep($("#formulario-casos").serializeArray(), function( a ) {
            if(a.name == "enfermedades_casos[]"){
                return true;
            }
        });
        
        if(enfermedades_seleccionadas.length > 0){
            resumen = this.agregaComa(resumen);
            resumen += "Enfermedades: ";
            $.each(enfermedades_seleccionadas, function(i, val){
                resumen += $("#enfermedades_casos option[value='"+val.value+"']").text() + " ";
            });
        }

        $("#configuracion-filtros-resumen").html(resumen);
    },
    
    /**
     * 
     * @param {String} descripcion
     * @param {type} id
     * @returns {String}
     */
    resumenFecha : function(resumen, descripcion, id){
        var yo = this;
        if($("#fecha_" + id + "_desde_casos").val()!="" || $("#fecha_" + id + "_hasta_casos").val()!=""){
            resumen = this.agregaComa(resumen);
            resumen += descripcion + ": "
            if($("#fecha_" + id + "_desde_casos").val()!=""){
                resumen += $("#fecha_" + id + "_desde_casos").val();
            } else{
                resumen += "∞";
            }
            
            if($("#fecha_" + id + "_hasta_casos").val()!=""){
                resumen += " - " + $("#fecha_" + id + "_hasta_casos").val();
            } else {
                resumen += " - ∞";
            }
            
        } else {
           // resumen += descripcion + ": todas";
        }
        return resumen;
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

