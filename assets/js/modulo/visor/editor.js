var VisorEditor = Class({ extends : MapaEditor}, {
    
    /**
     * Boton para mostrar instalaciones
     * @param {type} map
     * @returns {undefined}
     */
    controlInstalaciones : function (map) {
        var menu = new VisorLayoutAmbitoCapa();
        menu.seteaMapa(map);
        menu.render();
    }
    
});

