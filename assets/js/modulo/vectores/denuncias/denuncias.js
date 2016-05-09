$(document).ready(function(){
    if($("#mapa").length > 0){
    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/epidemiologico/descartado.png");
    mapa.seteaPlaceInput("direccion");
    if($("#id").val() ==""){
        $("#longitud").val(-70.2075248);
        $("#latitud").val(-18.3640923);
    }
    mapa.seteaLongitud($("#longitud").val());
    mapa.seteaLatitud($("#latitud").val());

    mapa.inicio();
    mapa.cargaMapa();
    mapa.setMarkerInputs();
    }

});



var Vectores = {

    guardar : function(form,btn){
        $(btn).attr('disabled',true);
        var btnText = $(btn).html();
        $(btn).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        var error = false;
        var error_msg = '';
        if(form.nombres.value == ""){
            error = true;
            error_msg += 'Nombres no puede quedar vacío <br/>';
        }
        if($("#apellidos").val() == ""){
            error = true;
            error_msg += 'Apellidos no puede quedar vacío <br/>';
        }
        if(form.cedula.value == ""){
            error = true;
            error_msg += 'RUN/Pasaporte no puede quedar vacío <br/>';
        }
        if(form.correo.value == ""){
            error = true;
            error_msg += 'Email no puede quedar vacío <br/>';
        }
        if(form.fecha_entrega.value == ""){
            error = true;
            error_msg += 'Fecha de Entrega no puede quedar vacío <br/>';
        }
        if(form.fecha_hallazgo.value == ""){
            error = true;
            error_msg += 'Fecha de Hallazgo no puede quedar vacío <br/>';
        }

        if(error){
            xModal.danger(error_msg,function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var parametros = $(form).serializeArray();

            $.ajax({
                url : siteUrl + 'vectores/guardarDenuncia',
                data : parametros,
                dataType : 'json',
                type : 'post',
                error : function(){
                    xModal.danger('Error Sistema',function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                },
                success : function(response){
                    if(response.estado == true){
                        xModal.success(response.mensaje,function(){
                            location.href = siteUrl + 'vectores/index';
                        });
                    }else{
                        xModal.danger(response.mensaje,function(){
                            $(btn).html(btnText).attr('disabled',false);
                        });
                    }
                }
            });
        }

    },


    guardarResultado : function(form,btn){
        $(btn).attr('disabled',true);
        var btnText = $(btn).html();
        $(btn).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        var error = false;
        var error_msg = '';
        if(form.resultado_laboratorio.value == ""){
            error = true;
            error_msg += 'Debe seleccionar una opción para el resultado <br/>';
        }
        if(form.resultado_laboratorio.value == 1 && form.estado_desarrollo.value == ""){
            error = true;
            error_msg += 'Debe seleccionar una opción para el estado de desarrollo <br/>';
        }

        if(error){
            xModal.danger(error_msg,function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var parametros = $(form).serializeArray();

            $.ajax({
                url : siteUrl + 'vectores/guardarResultado',
                data : parametros,
                dataType : 'json',
                type : 'post',
                error : function(){
                    xModal.danger('Error Sistema',function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                },
                success : function(response){
                    if(response.estado == true){
                        xModal.success(response.mensaje,function(){
                            location.href = siteUrl + 'vectores/index';
                        });
                    }else{
                        xModal.danger(response.mensaje,function(){
                            $(btn).html(btnText).attr('disabled',false);
                        });
                    }
                }
            });
        }
    },


    enviarInforme : function(form,btn){
        $(btn).attr('disabled',true);
        var btnText = $(btn).html();
        $(btn).html('Enviando... <i class="fa fa-spin fa-spinner"></i>');
        var parametros = $(form).serializeArray();

        $.ajax({
            url : siteUrl + 'vectores/enviarResultado',
            data : parametros,
            dataType : 'json',
            type : 'post',
            error : function(){
                xModal.danger('Error Sistema',function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            },
            success : function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje,function(){
                        location.href = siteUrl + 'vectores/index';
                    });
                }else{
                    xModal.danger(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            }
        });
    },


    agregarAdjunto : function(){
        var totalAdjuntos = $(".adjunto").length;
        var num_item = parseInt(totalAdjuntos) + 1;
        var item = '<div class="adjunto" id="adjunto_'+num_item+'"><div class="input-group"><input type="file" name="adjuntos[]" class="form-control"><div class="input-group-btn"><button type="button" class="btn btn-danger" onclick="Vectores.removerAdjunto('+num_item+');"><i class="fa fa-remove"></i></button></div></div></div>';

        $("#contenedor-adjuntos").append(item);

    },


    removerAdjunto : function(item){
        $("#adjunto_"+item).remove();
    },


    eliminarImagen : function(imagen,denuncia){
        xModal.confirm('Desea eliminar esta imagen?',function(){
            $.post(siteUrl + 'vectores/eliminarImagen/',{imagen:imagen,denuncia:denuncia},function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje,function(){
                        location.href = siteUrl + 'vectores/adjuntarImagenesDenuncia/id/'+denuncia;
                    })
                }else{
                    xModal.danger(response.mensaje);
                }
            },'json').fail(function(){
                xModal.danger('Error en sistema. Intentar nuevamente');
            })
        });
    },


    cambiarCoordenadas : function(id){
        xModal.confirm('Desea actualizar las coordenadas de la denuncia?',function(){
            var lon = $("#longitud").val();
            var lat = $("#latitud").val();

            $.post(siteUrl + 'vectores/cambiarCoordenadas',{lat:lat,lon:lon,id:id},function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje);
                }else{
                    xModal.danger(response.mensaje);
                }
            },'json').fail(function(){
                xModal.danger('Error en sistema. Por favor vuelva a intentarlo');
            });
        });
    }

};