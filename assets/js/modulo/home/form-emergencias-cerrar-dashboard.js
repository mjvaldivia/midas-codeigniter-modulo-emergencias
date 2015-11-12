/**
 * Control de formulario para cerrar emergencia
 */

var FormEmergenciasCerrarDashboard = Class({ extends : FormEmergenciasCerrar}, {
    
    //funcion de retorno al guardar formulario
    callBack : function(){
        reloadGrillaEmergencias();
    }
    
});


