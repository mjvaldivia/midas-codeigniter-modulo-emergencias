$(document).ready(function() {
    
    $("#fecha_de_nacimiento").mask('99/99/9999');
    
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
                    $("#texto_edad").html(years);
                    $("#edad").val(years);
                } else {
                    $("#texto_edad").html("");
                    $("#edad").val("");
                }
            }
        },
        delay: 600
    });
    
    $("#antecedentes_de_dengue_previo_fecha").datetimepicker({
        format: " YYYY", // Notice the Extra space at the beginning
        viewMode: "years", 
        locale: "es"
    });
    

    
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
    
    $("#fecha_de_inicio_de_sintomas").datetimepicker({
        format: "DD/MM/YYYY",
        locale: "es"
    }).on("dp.change", function(e) {
        if(e.date){
            $("#texto_semana_epidemiologica").html(e.date.isoWeek() + "° Semana");
            $("#semana_epidemiologica").val(e.date.isoWeek() + "° Semana");
        }
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