$(document).ready(function() {
    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-dengue").serializeArray();
       $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "publico/guardar_dengue", 
            error: function(xhr, textStatus, errorThrown){},
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    document.location.href = siteUrl + "publico/dengue";
                } else {
                    $("#form_error").removeClass("hidden");
                    procesaErrores(data.error);
                }
            }
        }); 
    });
    
    var mapa = new EventoFormMapa("mapa");
    
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    
    mapa.inicio();
    mapa.cargaMapa(); 
});
