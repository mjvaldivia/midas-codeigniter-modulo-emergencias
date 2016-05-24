$(document).ready(function() {


    $("#guardar").click(function(e){
        e.preventDefault();
        var parametros = $("#form-trampa").serializeArray();
        guardar(parametros);
    });

    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/otros/radar.png");
    mapa.seteaPlaceInput("direccion");
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());
    mapa.inicio();
    mapa.cargaMapa();

    if($("#id").val()!=""){
        mapa.setMarkerInputs();
    }


    $("#agregar_inspeccion").click(function(e){
        e.preventDefault();
        var parametros = $("#form-inspeccion").serializeArray();
        guardarInspeccion(parametros);
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
        url: siteUrl + "vectores_trampas/guardar",
        error: function(xhr, textStatus, errorThrown){},
        success:function(data){
            if(data.correcto == true){
                procesaErrores(data.error);
                document.location.href = siteUrl + "vectores_trampas/index/ingresado/correcto";
            } else {
                $("#form_error").removeClass("hidden");
                procesaErrores(data.error);
            }
        }
    });
}


function guardarInspeccion(parametros){
    $.ajax({
        dataType: "json",
        cache: false,
        async: false,
        data: parametros,
        type: "post",
        url: siteUrl + "vectores_trampas/guardarInspeccion",
        error: function(xhr, textStatus, errorThrown){},
        success:function(data){
            if(data.correcto == true){
                procesaErrores(data.error);
                //document.location.href = siteUrl + "trampas/index/ingresado/correcto";
                $("#contenedor-grilla-inspecciones").html(data.grilla);
                $("#form-inspeccion .form-control").val('');
            } else {
                $("#form_error").removeClass("hidden");
                procesaErrores(data.error);
            }
        }
    });
}