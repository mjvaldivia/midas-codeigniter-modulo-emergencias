var ReporteEmergencias = Class({
   
   id_mapa : "mapa-reporte", 
   id_emergencia : null,
    
    
   generar : function(id_emergencia){
       this.id_emergencia = id_emergencia;
       this.popupCargando();
   },
   
   
   creaReporte : function(){
        var yo = this;
        console.log(this.id_mapa);
        html2canvas($('#' + this.id_mapa), {
             useCORS: true,
             onrendered: function (canvas) {
                 var dataUrl = canvas.toDataURL("image/jpg");
                 dataUrl = dataUrl.replace(/^data:image\/(png|jpg);base64,/, "");

                 var d = {str: dataUrl, eme_ia_id: yo.id_emergencia, m: yo.microtime()};

                 $.ajax({
                     url: siteUrl + 'visor/getMapImage',
                     dataType: 'json',
                     data: d,
                     type: 'POST',
                     success: function (data) {
                         if (data.k !== 0) {
                             window.open(siteUrl + 'visor/getReporte/id/' + yo.id_emergencia + '/k/' + data.k, "_blank");
                         }
                     }
                 });
             }
        });    
   },
   
   popupCargando : function () {
        var yo = this;
        
        $.ajax({
            url: siteUrl + 'emergencia/popup_generando_reporte/id/' + yo.id_emergencia,
            dataType: 'html',
            data: "",
            type: 'POST',
            success: function (html) {
                bootbox.dialog({
                    message: html,
                    title: "Generando reporte",
                    buttons: {

                    }
                });
                
                yo.bindMapa();
            }
        });  
   },
   
   microtime : function () {
        var now = new Date()
                .getTime();
        var s = parseInt(now, 10);

        return (Math.round((now - s) * 1000) / 1000) + s;
    },
    
    bindMapa : function(){
        
       var yo = this; 
        
       var mapa = new AlarmaMapa("mapa_reporte");
       
       mapa.setCallback(function(mapa){    
            google.maps.event.addListenerOnce(mapa, 'tilesloaded', function () {
                setTimeout(function () {
                    yo.creaReporte();  
                }, 2000);
            });  
       });
       
       console.log($("#latitud_reporte").val());
       mapa.setLongitud($("#longitud_reporte").val());
       mapa.setLatitud($("#latitud_reporte").val());
       mapa.setGeozone($("#geozone_reporte").val());
       mapa.inicio();
       mapa.cargaMapa(); 
    }
    
});
    

