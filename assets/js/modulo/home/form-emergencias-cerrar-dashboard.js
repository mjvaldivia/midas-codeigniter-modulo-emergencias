/**
 * Control de formulario para cerrar emergencia
 */

var FormEmergenciasCerrarDashboard = Class({ extends : FormEmergenciasCerrar}, {
    
    dashboard : null,
    
    __construct : function(id, dashboard) {
        this.dashboard = dashboard;
        this.super("__construct", id);
    },
     
    //funcion de retorno al guardar formulario
    callBack : function(){
        this.dashboard.loadGridEmergencia();
    }
    
});


