var FormTipoEmergenciaRadiologica = Class({
        
    __construct : function() {
        this.bindRadioLugarIncidente();
        
        $(".radio-lugar-incidente").each(function(){
            if($(this).is(':checked')){
                $(this).trigger("click");
            }
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