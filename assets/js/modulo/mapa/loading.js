var mapa_tareas = 0;

var MapaLoading = Class({
   
    mapa : null,
    
    iniciarLoading : function (mapa){
        $("#mapa").append(
            "<div id=\"contenedor-mapa-tareas-loading\" class=\"hidden\" style=\"display: inline-block\">"
          
                + "<div id=\"mapa-tareas-loading\" style=\"display: inline-block; padding-left:5px\"> <i class=\"fa fa-spin fa-spinner\"></i></div><div style=\"display: inline-block; padding-left:5px\"> <span id=\"mapa-tareas-cantidad\">3</span> Tareas restantes... </div>"
        
          + "</div>");
        this.mapa = mapa;
        this.mapa.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(document.getElementById('contenedor-mapa-tareas-loading'));
    },
    
    push : function(cantidad){
        mapa_tareas += cantidad;
        this.mostrar();
    },
    
    remove : function(cantidad){
        mapa_tareas -= cantidad
        this.mostrar();
    },
    
    mostrar : function(){
      if(mapa_tareas > 0){
          $("#mapa-tareas-cantidad").html(mapa_tareas);
          $("#contenedor-mapa-tareas-loading").removeClass("hidden");
      }  else {
          $("#contenedor-mapa-tareas-loading").addClass("hidden");
      }
    }
    
});