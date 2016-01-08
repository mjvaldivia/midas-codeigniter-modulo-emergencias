/**
 * Inicio front-end
 */
$(document).ready(function() {
    var visor = new Visor("mapa");	
    
    $("#sidebar-toggle").click(function(){
        visor.resizeMap();
    });
});


