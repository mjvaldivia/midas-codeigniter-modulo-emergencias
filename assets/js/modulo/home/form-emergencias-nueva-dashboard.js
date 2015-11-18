var FormEmergenciasNuevaDashboard = Class({ extends : FormEmergenciasNueva}, {
    
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
     * Recarga de grillas de alarma y emergencias
     * @returns {void]
     */
    recargaGrilla : function(){
        this.dashboard.loadGridAlarma();
        this.dashboard.loadGridEmergencia();
    }
    
});
