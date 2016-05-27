$(document).ready(function() {
    $("#buscar").click(function(e){
        recargaGrilla();
    });
    
    $(".validar").livequery(function(){
        $(this).unbind("click");
        $(this).click(function(){
            var id = $(this).data("rel");
            bootbox.dialog({
                message: "<div id=\"contenido-popup\" class=\"text-center\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Validar resultado",
                className: "modal70",
                buttons: {
                    guardar: {
                        label: "<i class=\"fa fa-check\"></i> Validar",
                        className: "btn-success",
                        callback: function(e) {
                            
                            var boton = e.currentTarget;
                            $(boton).children("i").removeClass("fa-save");
                            $(boton).children("i").addClass("fa-spin fa-spinner");
                            $(boton).prop("disabled", true);
                            
                            var parametros = $("#form-resultado").serializeArray();
                            $.ajax({         
                                dataType: "json",
                                cache: false,
                                async: true,
                                data: parametros,
                                type: "post",
                                url: siteUrl + "marea_roja_derivar/guardar_validar", 
                                error: function(xhr, textStatus, errorThrown){
                                    notificacionError("Ha ocurrido un problema", errorThrown);
                                },
                                success:function(data){
                                    if(data.correcto == true){
                                        $("#form_error").addClass("hidden");
                                        procesaErrores(data.error);
                                        recargaGrilla();
                                        bootbox.hideAll();
                                    } else {
                                        $("#form_error").removeClass("hidden");
                                        procesaErrores(data.error);
                                    }  
                                    $(boton).children("i").removeClass("fa-spin fa-spinner");
                                    $(boton).children("i").addClass("fa-save");
                                    $(boton).prop("disabled", false);
                                }
                            });
                            
                            return false;
                        }
                    },
                    cerrar: {
                        label: "<i class=\"fa fa-close\"></i> Cerrar ventana",
                        className: "btn-white",
                        callback: function() {}
                    }
                }
            });

            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: {"id" : id},
                type: "post",
                url: siteUrl + "marea_roja_derivar/validar", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup").html(data);
                }
            }); 
        });
    });
    
    $(".editar-marea-roja").livequery(function(){
        $(this).unbind("click");
        $(this).click(function(){
            var id = $(this).data("rel");
            bootbox.dialog({
                message: "<div id=\"contenido-popup\" class=\"text-center\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>",
                title: "<i class=\"fa fa-arrow-right\"></i> Ingreso resultados",
                className: "modal70",
                buttons: {
                    guardar: {
                        label: "<i class=\"fa fa-save\"></i> Guardar",
                        className: "btn-success",
                        callback: function(e) {
                            
                            var boton = e.currentTarget;
                            $(boton).children("i").removeClass("fa-save");
                            $(boton).children("i").addClass("fa-spin fa-spinner");
                            $(boton).prop("disabled", true);
                            
                            var parametros = $("#form-resultado").serializeArray();
                            $.ajax({         
                                dataType: "json",
                                cache: false,
                                async: true,
                                data: parametros,
                                type: "post",
                                url: siteUrl + "marea_roja_resultado/guardar", 
                                error: function(xhr, textStatus, errorThrown){
                                    notificacionError("Ha ocurrido un problema", errorThrown);
                                },
                                success:function(data){
                                    if(data.correcto == true){
                                        $("#form_error").addClass("hidden");
                                        procesaErrores(data.error);
                                        recargaGrilla();
                                        bootbox.hideAll();
                                    } else {
                                        $("#form_error").removeClass("hidden");
                                        procesaErrores(data.error);
                                    }  
    
                                    $(boton).children("i").removeClass("fa-spin fa-spinner");
                                    $(boton).children("i").addClass("fa-save");
                                    $(boton).prop("disabled", false);
                                }
                            });
                            
                            return false;
                        }
                    },
                    cerrar: {
                        label: "<i class=\"fa fa-close\"></i> Cerrar ventana",
                        className: "btn-white",
                        callback: function() {}
                    }
                }
            });

            $.ajax({         
                dataType: "html",
                cache: false,
                async: true,
                data: {"id" : id},
                type: "post",
                url: siteUrl + "marea_roja_resultado/editar", 
                error: function(xhr, textStatus, errorThrown){
                    notificacionError("Ha ocurrido un problema", errorThrown);
                },
                success:function(data){
                    $("#contenido-popup").html(data);
                }
            }); 
        });
    });
});


function recargaGrilla(){
    $("#resultados").html(
        "<div class=\"col-lg-12 text-center\" style=\"height: 100px;\">"
        + "<i class=\"fa fa-4x fa-spin fa-spinner\"></i>"
        + "</div>"
    );
    $("#pResultados").removeClass("hidden");
    $.ajax({         
        dataType: "html",
        cache: false,
        async: true,
        data: {
            "region" : $("#region").val(), 
            "comuna" : $("#comuna").val(),
            "numero_acta" : $("#numero_muestra").val(),
            "validado" : $("#validado").val()
        },
        type: "post",
        url: siteUrl + "marea_roja_resultado/ajax_lista", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(html){
            $("#resultados").html(html);
        }
    });
}