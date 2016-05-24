$(document).ready(function() {

    $(".formulario-coordenadas").livequery(function(){
        var prefijo = $(this).data("rel");
        
        $("#" + prefijo + "_mensaje").addClass("hidden");
        
        $(this).change(function(){
            switch($(this).val()){
                case "decimal":
                    $("." + prefijo + "_mapa_coordenadas").removeClass("disabled");
                    $("." + prefijo + "_mapa_coordenadas").prop("readonly", false);
                    
                    $("#" + prefijo + "_mensaje").addClass("hidden");
                    
                    $("#" + prefijo + "_contenedor_gms").addClass("hidden");
                    $("#" + prefijo + "_contenedo_utm").addClass("hidden");
                    break;
                case "gms":
                    $("." + prefijo + "_mapa_coordenadas").addClass("disabled");
                    $("." + prefijo + "_mapa_coordenadas").prop("readonly", true);
                    
                    $("#" + prefijo + "_mensaje").removeClass("hidden");
                    
                    $("#" + prefijo + "_contenedor_gms").removeClass("hidden");
                    $("#" + prefijo + "_contenedor_utm").addClass("hidden");
                    break;
                case "utm":
                    $("." + prefijo + "_mapa_coordenadas").addClass("disabled");
                    $("." + prefijo + "_mapa_coordenadas").prop("readonly", true);
                    
                    $("#" + prefijo + "_mensaje").removeClass("hidden");
                    
                    $("#" + prefijo + "_contenedor_gms").addClass("hidden");
                    $("#" + prefijo + "_contenedor_utm").removeClass("hidden");
                    break;
            } 
        });
        
        $("#" + prefijo + "_utm_latitud").mask('000000');
        $("#" + prefijo + "_utm_longitud").mask('0000000');

        $("#" + prefijo + "_utm_zona").change(function(){
            utmToCoordenadas(prefijo);
        });

        $("." + prefijo + "_utm_input").typing({
            stop: function (event, $elem) {
                utmToCoordenadas(prefijo);
            },
            delay: 600
        });

        $("." + prefijo + "_gms_input").typing({
            stop: function (event, $elem) {
                gmsToCoordenadas(prefijo);
            },
            delay: 600
        }); 
        
        $(this).trigger("change");
    });
    
});

/**
 * 
 * @returns {undefined}
 */
function gmsToCoordenadas(prefijo){
    $("#" + prefijo + "_longitud").val("");
    $("#" + prefijo + "_latitud").val("");
    
    if($("#" + prefijo + "_gms_grados_lng").val()!="" && $("#" + prefijo + "_gms_minutos_lng").val()!="" && $("#" + prefijo + "_gms_segundos_lng").val()!=""){
        $("#" + prefijo + "_longitud").val(
            formulaGmsToCoordenadas(
                $("#" + prefijo + "_gms_grados_lng").val(),
                $("#" + prefijo + "_gms_minutos_lng").val(),
                $("#" + prefijo + "_gms_segundos_lng").val()
            )
        );
    }
    
    if($("#" + prefijo + "_gms_grados_lat").val()!="" && $("#" + prefijo + "_gms_minutos_lat").val()!="" && $("#" + prefijo + "_gms_segundos_lat").val()!=""){
        $("#" + prefijo + "_latitud").val(
            formulaGmsToCoordenadas(
                $("#" + prefijo + "_gms_grados_lat").val(),
                $("#" + prefijo + "_gms_minutos_lat").val(),
                $("#" + prefijo + "_gms_segundos_lat").val()
            )
        );   
    } 
    
    $("#" + prefijo + "_latitud").trigger("change");
}

/**
 * 
 * @returns {undefined}
 */
function utmToCoordenadas(prefijo){
    $("#" + prefijo + "_longitud").val("");
    $("#" + prefijo + "_latitud").val("");
    
    if($("#" + prefijo + "_utm_latitud").val() != "" && $("#" + prefijo + "_utm_longitud").val() != ""){
        var latLon = GeoEncoder.utmToDecimalDegree(
            $("#" + prefijo + "_utm_latitud").val(), 
            $("#" + prefijo + "_utm_longitud").val(), 
            $("#" + prefijo + "_utm_zona").val()
        );
        $("#" + prefijo + "_latitud").val(latLon[0]);
        $("#" + prefijo + "_longitud").val(latLon[1]);

        $("#" + prefijo + "_latitud").trigger("change");
    }
}

/**
 * Formula para grados a coordenadas
 * @param {float} grados
 * @param {float} minutos
 * @param {float} segundos
 * @returns {Number}
 */
function formulaGmsToCoordenadas(grados, minutos, segundos){
    return -( parseFloat(grados) + (parseFloat(minutos)/60 + (parseFloat(segundos)/3600)) );
}