var FormTipoEmergenciaRadiologica = Class({
        
    __construct : function() {
        this.bindRadioLugarIncidente();
        this.bindRadioRiegoPotencial();
        this.bindRadioEvaluacionRadiacion();
        
        $(".radio-lugar-incidente").each(function(){
            if($(this).is(':checked')){
                $(this).trigger("click");
            }
        });
        
        if($("#form_tipo_riesgo_potencial_si").is(':checked')){
            $("#div-riesgo-potencial").removeClass("hidden");
        } else {
            $("#div-riesgo-potencial").addClass("hidden");
        }
        
        if($("#form_tipo_evaluacion_radiacion_si").is(':checked')){
            $("#div-evaluacion-radiacion").removeClass("hidden");
        } else {
            $("#div-evaluacion-radiacion").addClass("hidden");
        }
    },
    
    /**
     * Divs de evaluacion de radiacion
     * @returns {void}
     */
    bindRadioEvaluacionRadiacion : function(){
        $("#form_tipo_evaluacion_radiacion_si").livequery(function(){
            $(this).unbind( "click" );
            $(this).click( function(e){
                if($(this).is(':checked')){
                    $("#div-evaluacion-radiacion").removeClass("hidden");
                }
            });
        });
        
        $("#form_tipo_evaluacion_radiacion_no").livequery(function(){
            $(this).unbind( "click" );
            $(this).click( function(e){
                if($(this).is(':checked')){
                    $("#div-evaluacion-radiacion").addClass("hidden");
                }
            });
        });
    },
    
    /**
     * Divs de riesgo potencial
     * @returns {void}
     */
    bindRadioRiegoPotencial : function(){
        $("#form_tipo_riesgo_potencial_si").livequery(function(){
            $(this).unbind( "click" );
            $(this).click( function(e){
                if($(this).is(':checked')){
                    $("#div-riesgo-potencial").removeClass("hidden");
                }
            });
        });
      
        $("#form_tipo_riesgo_potencial_no").livequery(function(){
            $(this).unbind( "click" );
            $(this).click( function(e){
                if($(this).is(':checked')){
                    $("#div-riesgo-potencial").addClass("hidden");
                }
            });
        });
    },
    
    /**
     * 
     * @returns {undefined}
     */
    bindRadioLugarIncidente : function(){
        $(".radio-lugar-incidente").livequery(function(){
            $(this).unbind( "click" );
            $(this).click( function(e){
                
                $(".radio-lugar-incidente").each(function(){
                    $("#" + $(this).attr("data-toggle")).addClass("hidden");
                });

                if($(this).is(':checked')){
                    $("#" + $(this).attr("data-toggle")).removeClass("hidden");
                }
    
            });
        });
    }
      
});

/**
 * Inicio front-end
 */
$(document).ready(function() {
    var form = new FormTipoEmergenciaRadiologica();	
    
});