$(document).ready(function() {
    
    
    $("#fecha_de_nacimiento").mask('99/99/9999');
    
    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-dengue").serializeArray();
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
    });
    
    var mapa = new MapaFormulario("mapa");
    mapa.seteaPlaceInput("direccion");
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    
    mapa.inicio();
    mapa.cargaMapa(); 
});
