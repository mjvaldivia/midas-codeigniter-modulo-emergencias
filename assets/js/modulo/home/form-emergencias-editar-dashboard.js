var FormEmergenciasEditarDashboard = Class({ extends : FormEmergenciasEditar }, {
    
    /**
     * @var Dashboard
     */
    dashboard : null,
    
    /**
     * Inicia instancia
     * @param int id identificador emergencia
     * @param Dashboard dashboard
     * @returns void
     */
    __construct : function(id, dashboard) {
        this.dashboard = dashboard;
        this.super("__construct", id);
    },
    
    /**
     * Retorno despues de guardar
     * @returns void
     */
    callBackGuardar : function(){
       this.dashboard.loadGridEmergencia();
       notificacionCorrecto("Resultado de la operacion", "Se ha insertado correctamente");
    }
    
});


