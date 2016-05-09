$(document).ready(function(){

    var mapa = new MapaFormulario("mapa");
    mapa.seteaIcono("assets/img/markers/firstaid.png");
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




});



var Hallazgos = {

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
        if(form.apellidos.value == ""){
            error = true;
            error_msg += 'Apellidos no puede quedar vacío <br/>';
        }
        if(form.telefono.value == ""){
            error = true;
            error_msg += 'Telefóno no puede quedar vacío <br/>';
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
                url : siteUrl + 'hallazgos/guardarDenuncia',
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
                            location.href = siteUrl + 'hallazgos/index';
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
        if(form.estado_desarrollo.value == ""){
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
                url : siteUrl + 'hallazgos/guardarResultado',
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
                            location.href = siteUrl + 'hallazgos/index';
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
            url : siteUrl + 'hallazgos/enviarResultado',
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
                        location.href = siteUrl + 'hallazgos/index';
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
        var item = '<div class="adjunto" id="adjunto_'+num_item+'"><div class="input-group"><input type="file" name="adjuntos[]" class="form-control"><div class="input-group-btn"><button type="button" class="btn btn-danger" onclick="hallazgos.removerAdjunto('+num_item+');"><i class="fa fa-remove"></i></button></div></div></div>';

        $("#contenedor-adjuntos").append(item);

    },


    removerAdjunto : function(item){
        $("#adjunto_"+item).remove();
    },


    eliminarImagen : function(imagen,denuncia){
        xModal.confirm('Desea eliminar esta imagen?',function(){
            $.post(siteUrl + 'hallazgos/eliminarImagen/',{imagen:imagen,denuncia:denuncia},function(response){
                if(response.estado == true){
                    xModal.success(response.mensaje,function(){
                        location.href = siteUrl + 'hallazgos/adjuntarImagenesInspeccion/id/'+denuncia;
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
        xModal.confirm('Desea actualizar las coordenadas de la inspección?',function(){
            var lon = $("#longitud").val();
            var lat = $("#latitud").val();

            $.post(siteUrl + 'hallazgos/cambiarCoordenadas',{lat:lat,lon:lon,id:id},function(response){
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