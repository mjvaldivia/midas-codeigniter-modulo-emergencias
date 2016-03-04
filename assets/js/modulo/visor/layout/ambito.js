var VisorLayoutAmbitoCapa = Class({ extends : MapaLayoutAmbitoCapa}, {
    loadComunas : function(){
        var yo = this;
        var comunas = {};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: false,
            data: {"id" : $("#regiones").val()},
            type: "post",
            url:  siteUrl + "comuna/json_comunas_region", 
            error: function(xhr, textStatus, errorThrown){
                notificacionError("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                    $.each(data.comunas, function(i, com){
                        comunas[i] = com.com_c_nombre;
                    });
                } else {
                    notificacionError("Ha ocurrido un problema", data.mensaje);
                }
            }
        });
        
        return comunas;
    },
});


