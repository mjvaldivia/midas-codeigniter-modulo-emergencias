$(document).ready(function() {
    
    
    $("#fecha_de_nacimiento").mask('99/99/9999');
    
    $("#enviar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-dengue").serializeArray();
       parametros.push({"name" : "enviado", value : 1});
       guardar(parametros);
    });
    
    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-dengue").serializeArray();
       guardar(parametros);
    });
    
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/firstaid.png");
    mapa.seteaPlaceInput("direccion");
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    
    mapa.inicio();
    mapa.cargaMapa(); 
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
         url: siteUrl + "formulario/guardar_dengue", 
         error: function(xhr, textStatus, errorThrown){},
         success:function(data){
             if(data.correcto == true){
                 procesaErrores(data.error);
                 document.location.href = siteUrl + "formulario/index/ingresado/correcto";
             } else {
                 $("#form_error").removeClass("hidden");
                 procesaErrores(data.error);
             }
         }
     }); 
}