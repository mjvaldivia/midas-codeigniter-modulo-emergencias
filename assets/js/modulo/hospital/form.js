$(document).ready(function() {
    

    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-hospital").serializeArray();
       guardar(parametros);
    });
        
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/hospital-verde.png");
    mapa.seteaPlaceInput("direccion");
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    mapa.inicio();
    mapa.cargaMapa(); 
    
    if($("#id").val()!=""){
        mapa.setMarkerInputs();
    }
});

/**
 * 
 * @returns {undefined}
 */
function guardar(parametros){
    $.ajax({         
         dataType: "json",
         cache: false,
         async: false,
         data: parametros,
         type: "post",
         url: siteUrl + "hospital/guardar", 
         error: function(xhr, textStatus, errorThrown){},
         success:function(data){
             if(data.correcto == true){
                 procesaErrores(data.error);
                 document.location.href = siteUrl + "hospital/index/ingresado/correcto";
             } else {
                 $("#form_error").removeClass("hidden");
                 procesaErrores(data.error);
             }
         }
     }); 
}