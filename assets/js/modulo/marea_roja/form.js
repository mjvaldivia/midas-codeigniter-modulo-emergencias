$(document).ready(function() {
    
    $("#region").change(function(){
        if($(this).val()!=""){
           var parametros = {"id" : $(this).val()}
           $.ajax({         
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: siteUrl + "comuna/json_comunas_region", 
                error: function(xhr, textStatus, errorThrown){},
                success:function(data){
                    $("#comuna").html("<option value=\"\"> -- Seleccione un valor -- </option>");
                    $.each(data.comunas, function(i, val){
                        $("#comuna").append("<option value=\"" + val.com_ia_id +"\">" + val.com_c_nombre + "</option>")
                    });
                }
            }); 
        } 
    });
    
    $("#guardar").click(function(e){
        var boton = buttonStartProcess(this, e)
        var parametros = $("#form").serializeArray();
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: parametros,
            type: "post",
            url: siteUrl + "marea_roja/guardar", 
            error: function(xhr, textStatus, errorThrown){
                 buttonEndProcess(boton);
            },
            success:function(data){
                if(data.correcto == true){
                    procesaErrores(data.error);
                    document.location.href = siteUrl + "marea_roja/index/ingresado/correcto";
                } else {
                    $("#form_error").removeClass("hidden");
                    procesaErrores(data.error);
                    buttonEndProcess(boton);
                }
            }
        }); 
    });
        
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/marisco/rojo.png");
    mapa.seteaLatitudInput("form_coordenadas_latitud");
    mapa.seteaLongitudInput("form_coordenadas_longitud");
    mapa.inicio();
    mapa.cargaMapa(); 
    mapa.setMarkerInputs();
    
});