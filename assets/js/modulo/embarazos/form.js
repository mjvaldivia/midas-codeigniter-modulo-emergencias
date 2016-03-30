$(document).ready(function() {
    
    $("#fecha_de_nacimiento").mask('99/99/9999');
    $("#fecha_fur").mask('99/99/9999');
    $("#fecha_fpp").mask('99/99/9999');
    
    $("#fecha_fur").typing({
        stop: function (event, $elem) {
            var valor = $elem.val().split("/");
            if(valor.length == 3){
                if(parseInt(valor[valor.length-1]) > 99){
                    var fecha = moment($elem.val(), "DD/MM/YYYY");
                } else {
                    var fecha = moment($elem.val(), "DD/MM/YY");
                }
                if(fecha.isValid()){
                    fecha.add(280, 'days');
                    $("#fecha_fpp").val(fecha.format("D/M/YYYY"));
                    $("#texto_fecha_fpp").html(fecha.format("D/M/YYYY"));
                }
            }
        },
        delay: 600
    });
    
    $("#fecha_de_nacimiento").typing({
        stop: function (event, $elem) {
            var valor = $elem.val().split("/");
            if(valor.length == 3){
                if(parseInt(valor[valor.length-1]) > 99){
                    var fecha = moment($elem.val(), "DD/MM/YYYY");
                } else {
                    var fecha = moment($elem.val(), "DD/MM/YY");
                }
                if(fecha.isValid()){
                    var years = moment().diff(fecha, 'years');
                    if(years == 0){
                        var months = moment().diff(fecha, 'months');
                        if(months == 0){
                            var days = moment().diff(fecha, 'days');
                            $("#texto_edad").html(days + " días");
                            $("#edad").val(days + " días");
                        } else {
                            $("#texto_edad").html(months + " meses");
                            $("#edad").val(months + " meses");
                        }
                    } else {
                        $("#texto_edad").html(years);
                        $("#edad").val(years);
                    }
                } else {
                    $("#texto_edad").html("");
                    $("#edad").val("");
                }
            }
        },
        delay: 600
    });
    
    $("#guardar").click(function(e){
       e.preventDefault();
       var parametros = $("#form-dengue").serializeArray();
       guardar(parametros);
    });
        
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/otros/embarazada.png");
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
         url: siteUrl + "embarazo/guardar", 
         error: function(xhr, textStatus, errorThrown){},
         success:function(data){
             if(data.correcto == true){
                 procesaErrores(data.error);
                 document.location.href = siteUrl + "embarazo/index/ingresado/correcto";
             } else {
                 $("#form_error").removeClass("hidden");
                 procesaErrores(data.error);
             }
         }
     }); 
}