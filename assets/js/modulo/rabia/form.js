$(document).ready(function() {

    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form").serializeArray();
       guardar(parametros);
    });
        
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/otros/animal.png");
    mapa.seteaPlaceInput("direccion");
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    mapa.inicio();
    mapa.cargaMapa(); 
    
    if($("#id").val()!=""){
        mapa.setMarkerInputs();
    }
    
    var opciones = [{"name" : "Perro"},
                    {"name" : "Gato"}];
    
    if($("#especie_animal").val() != ""){
        opciones.push({"name" : $("#especie_animal").val()});
    }
    
    $('#especie_animal').selectize({
        persist: false,
        maxItems: 1,
        create: true,
        valueField: 'name',
        labelField: 'name',
        searchField: ['name'],
        options: opciones
    });
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
         url: siteUrl + "rabia_vacunacion/guardar", 
         error: function(xhr, textStatus, errorThrown){},
         success:function(data){
             if(data.correcto == true){
                 procesaErrores(data.error);
                 document.location.href = siteUrl + "rabia_vacunacion/index/ingresado/correcto";
             } else {
                 $("#form_error").removeClass("hidden");
                 procesaErrores(data.error);
             }
         }
     }); 
}