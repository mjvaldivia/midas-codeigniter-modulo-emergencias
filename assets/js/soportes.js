var Soportes = {};

(function() {

    this.init = function(){
        var tablaSoportes = $("#tabla_soportes").DataTable({
            destroy : true,
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            order: [[0, "desc"]]
        });
    },


    this.nuevoSoporte = function() {

        /*$("#modal_nuevo_soporte").load(siteUrl + 'soportes/nuevoSoporte');
       */
        /*$("#modal_nuevo_soporte").modal({backdrop: 'static',keyboard: false});*/
        
        

    },


    this.enviarSoporte = function(form,btn) {
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Enviando...<i class="fa fa-spin fa-spinner"></i>');

        var error = '';
        if(form.asunto_soporte.value == ""){
            error += '- Debe ingresar el asunto del ticket<br/>';
        }
        if(form.texto_soporte.value == ""){
            error += '- Debe ingresar el texto del ticket<br/>';
        }

        if(error != ""){
            bootbox.alert({
                title:'Error',
                message : error
            });
            $(btn).attr('disabled',false).html(btnText);
        }else{
            var formulario = $(form).serialize();
            $.post(siteUrl + 'soportes/enviarSoporte',{data:formulario},function(response){
                if(response.estado == true){
                    bootbox.dialog({
                        title:'Ingreso correcto',
                        message: response.mensaje,
                        buttons: {
                            ok : {
                                callback : function(){
                                    $(btn).attr('disabled',false).html(btnText);
                                    ModalSipresa.close_modal("modal_nuevo_soporte");
                                    $.post(siteUrl + 'soportes/cargarGrillaSoportes',{grilla:'usuario'},function(response){
                                        $("#contenedor-tabla-soportes").html(response);
                                        Soportes.init();
                                    },'html').fail(function(){
                                        bootbox.alert({title:"Error", message:"Hubo un error en el sistema. Intente nuevamente o comuníquese con Administrador"});
                                    });
                                }
                            }
                        }
                    });
                }else{
                    bootbox.alert({
                        title:"Error", 
                        message:response.mensaje
                    });
                    $(btn).attr('disabled',false).html(btnText);
                }
            },'json').fail(function(){
                bootbox.dialog({title:"Error", message:"Hubo un error en el sistema. Intente nuevamente o comuníquese con Administrador"});
                $(btn).attr('disabled',false).html(btnText);
            });
        }
    },


    this.enviarMensaje = function(form,btn) {
        var btnText = $(btn).html();
        $(btn).attr('disabled',true).html('Enviando...<i class="fa fa-spin fa-spinner"></i>');

        var error = '';
        if(form.texto_mensaje.value == ""){
            error += '- Debe ingresar el texto del mensaje<br/>';
        }

        if(error != ""){
            bootbox.alert({
                title:'Error',
                message : error
            });
            $(btn).attr('disabled',false).html(btnText);
        }else{
            var formulario = $(form).serialize();
            $.post(siteUrl + 'soportes/enviarMensaje',{data:formulario},function(response){
                if(response.estado == true){
                    bootbox.dialog({
                        title:'Envio correcto',
                        message: response.mensaje,
                        buttons: {
                            ok : {
                                callback : function(){
                                    $(btn).attr('disabled',false).html(btnText);
                                    ModalSipresa.close_modal("modal_nuevo_mensaje");
                                    ModalSipresa.close_modal("modal_ver_soporte");
                                    /*$.post(siteUrl + 'soportes/cargarGrillaSoportes',{grilla:'usuario'},function(response){
                                        $("#contenedor-tabla-soportes").html(response);
                                        Soportes.init();
                                    },'html').fail(function(){
                                        bootbox.alert({title:"Error", message:"Hubo un error en el sistema. Intente nuevamente o comuníquese con Administrador"});
                                    });*/
                                }
                            }
                        }
                    });
                }else{
                    bootbox.alert({
                        title:"Error", 
                        message:response.mensaje
                    });
                    $(btn).attr('disabled',false).html(btnText);
                }
            },'json').fail(function(){
                bootbox.dialog({title:"Error", message:"Hubo un error en el sistema. Intente nuevamente o comuníquese con Administrador"});
                $(btn).attr('disabled',false).html(btnText);
            });
        }
    }

}).apply(Soportes);