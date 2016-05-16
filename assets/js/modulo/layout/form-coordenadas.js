$(document).ready(function() {
   $("#form_coordenadas_tipo").change(function(){
        switch($(this).val()){
            case "decimal":
                $(".mapa-coordenadas").removeClass("disabled");
                $(".mapa-coordenadas").prop("disabled", false);
                
                $("#form_coordenadas_gms").addClass("hidden");
                $("#form_coordenadas_utm").addClass("hidden");
                break;
            case "gms":
                $(".mapa-coordenadas").addClass("disabled");
                $(".mapa-coordenadas").prop("disabled", true);
                
                $("#form_coordenadas_gms").removeClass("hidden");
                $("#form_coordenadas_utm").addClass("hidden");
                break;
            case "utm":
                $(".mapa-coordenadas").addClass("disabled");
                $(".mapa-coordenadas").prop("disabled", true);
                
                $("#form_coordenadas_gms").addClass("hidden");
                $("#form_coordenadas_utm").removeClass("hidden");
                break;
              
      } 
   });
   
   $("#form_coordenadas_utm_latitud").mask('00000');
   $("#form_coordenadas_utm_longitud").mask('000000');
   
   $("#form_coordenadas_utm_zona").change(function(){
       utmToCoordenadas();
   });
   
   $(".form_coordenadas_utm_input").typing({
        stop: function (event, $elem) {
            utmToCoordenadas();
        },
        delay: 600
    });
    
    $(".form_coordenadas_gms_input").typing({
        stop: function (event, $elem) {
            gmsToCoordenadas();
        },
        delay: 600
    });
});

/**
 * 
 * @returns {undefined}
 */
function gmsToCoordenadas(){
    $("#longitud").val("");
    $("#latitud").val("");
    
    if($("#form_coordenadas_gms_grados_lng").val()!="" && $("#form_coordenadas_gms_minutos_lng").val()!="" && $("#form_coordenadas_gms_segundos_lng").val()!=""){
        $("#longitud").val(
            formulaGmsToCoordenadas(
                $("#form_coordenadas_gms_grados_lng").val(),
                $("#form_coordenadas_gms_minutos_lng").val(),
                $("#form_coordenadas_gms_segundos_lng").val()
            )
        );
    }
    
    if($("#form_coordenadas_gms_grados_lat").val()!="" && $("#form_coordenadas_gms_minutos_lat").val()!="" && $("#form_coordenadas_gms_segundos_lat").val()!=""){
        $("#latitud").val(
            formulaGmsToCoordenadas(
                $("#form_coordenadas_gms_grados_lat").val(),
                $("#form_coordenadas_gms_minutos_lat").val(),
                $("#form_coordenadas_gms_segundos_lat").val()
            )
        );   
    } 
    
    $("#latitud").trigger("change");
}

/**
 * 
 * @returns {undefined}
 */
function utmToCoordenadas(){
    $("#longitud").val("");
    $("#latitud").val("");
    
    if($("#form_coordenadas_utm_latitud").val() != "" && $("#form_coordenadas_utm_longitud").val() != ""){
        var latLon = GeoEncoder.utmToDecimalDegree(
            $("#form_coordenadas_utm_latitud").val(), 
            $("#form_coordenadas_utm_longitud").val(), 
            $("#form_coordenadas_utm_zona").val()
        );
        $("#latitud").val(latLon[0]);
        $("#longitud").val(latLon[1]);

        $("#latitud").trigger("change");
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