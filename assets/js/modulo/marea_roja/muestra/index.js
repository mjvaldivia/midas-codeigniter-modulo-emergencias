$(document).ready(function() {
    
    
    $("#buscar").click(function(e){
        recargaGrilla();
    });
    
    $(".editar-marea-roja").livequery(function(){
        $(this).unbind("click");
        $(this).click(function(){
            var id = $(this).data("rel");
            document.location.href = siteUrl + 'marea_roja/editar/?id=' + id;
        });
    });
    
    $("#descargar").click(function(e){
        e.preventDefault();
        bootbox.dialog({
            title: "Descargar excel",
            message: '<div id=\"contenido-popup\"><i class=\"fa fa-4x fa-spin fa-spinner\"></i></div>',
            buttons: {
                success: {
                    label: "<i class=\"fa fa-download\"></i> Descargar",
                    className: "btn-primary",
                    callback: function () {
                        var fecha_desde = $("#fecha_desde").val();
                        var fecha_hasta = $("#fecha_hasta").val();
                        console.log(siteUrl + "marea_roja/excel/fecha_desde/" + fecha_desde.replace(/\//g, "_") + "/fecha_hasta/" + fecha_hasta.replace(/\//g, "_"));
                        window.open(siteUrl + "marea_roja/excel/fecha_desde/" + fecha_desde.replace(/\//g, "_") + "/fecha_hasta/" + fecha_hasta.replace(/\//g, "_"), "_blank");
                    }
                },
                danger: {
                    label: "<i class=\"fa fa-remove\"></i> Cancelar",
                    className: "btn-white"
                }
            }
        });
        
        $.ajax({         
            dataType: "html",
            cache: false,
            async: true,
            data: "",
            type: "post",
            url: siteUrl + "marea_roja/ajax_form_excel", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contenido-popup").html(html);
            }
        });
    });
    
    $(".caso-eliminar").livequery(function(){
        $(this).unbind( "click" );
        $(this).click(function(e){
           e.preventDefault();
           var id = $(this).attr("data");
           
           bootbox.dialog({
                title: "Eliminar elemento",
                message: '¿Está seguro que desea eliminar este caso?',
                buttons: {
                    success: {
                        label: "<i class=\"fa fa-trash\"></i> Eliminar",
                        className: "btn-danger",
                        callback: function () {
                            var parametro = {"id" : id};
                            $.ajax({         
                                 dataType: "json",
                                 cache: false,
                                 async: true,
                                 data: parametro,
                                 type: "post",
                                 url: siteUrl + "marea_roja/eliminar", 
                                 error: function(xhr, textStatus, errorThrown){

                                 },
                                 success:function(json){
                                     recargaGrilla();
                                 }
                             });
                        }
                    },
                    danger: {
                        label: "<i class=\"fa fa-remove\"></i> Cancelar",
                        className: "btn-white"
                    }
                }
            });
           
           
           
        }) ;
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
        data: {"region" : $("#region").val(), "comuna" : $("#comuna").val(), "numero_acta" : $("#numero_acta").val()},
        type: "post",
        url: siteUrl + "marea_roja/ajax_lista", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(html){
            $("#resultados").html(html);
        }
    });
}