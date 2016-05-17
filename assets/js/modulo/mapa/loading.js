
/**
 * Cantidad de tareas siendo ejecutadas
 * @type Number
 */
var mapa_tareas = 0;

/**
 * Muestra mensaje con tareas pendientes
 * @type MapaLoading
 */
var MapaLoading = Class({
    
    /**
     * GoogleMaps
     */
    mapa : null,
    
    /**
     * Carga el cuadro de loading al mapa
     * @param {googleMaps} mapa
     * @returns {undefined}
     */
    iniciarLoading : function (mapa){
        $("#mapa").append(
            "<div id=\"contenedor-mapa-tareas-loading\" class=\"hidden\">"
                + "<div style=\"display: inline-block\">"
                    + "<div id=\"mapa-tareas-loading\" style=\"display: inline-block; padding-left:5px\">"
                        + "<i class=\"fa fa-spin fa-spinner\"></i>"
                    + "</div>"
                    + "<div style=\"display: inline-block; padding-left:5px\">" 
                        + "<span id=\"mapa-tareas-cantidad\">3 Tareas restantes... </span>"
                    + "</div>"
                + "</div>"
          + "</div>");
        this.mapa = mapa;
        this.mapa.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(document.getElementById('contenedor-mapa-tareas-loading'));
    },
    
    /**
     * Agrega tarea
     * @param {int} cantidad
     * @returns {undefined}
     */
    push : function(cantidad){
        mapa_tareas += cantidad;
        this.mostrar();
    },
    
    /**
     * Quita la tarea
     * @param {int} cantidad
     * @returns {undefined}
     */
    remove : function(cantidad){
        mapa_tareas -= cantidad;
        this.mostrar();
    },
    
    /**
     * Muestra cuadro con tareas pendientes
     * @returns {undefined}
     */
    mostrar : function(){
      if(mapa_tareas > 0){
          var texto;
          if(mapa_tareas == 1){
              texto = " Tarea restante...";
          } else {
              texto = " Tareas restantes...";
          }
          $("#mapa-tareas-cantidad").html(mapa_tareas + texto);
          $("#contenedor-mapa-tareas-loading").removeClass("hidden");
      }  else {
          $("#contenedor-mapa-tareas-loading").addClass("hidden");
      }
    }
    
});