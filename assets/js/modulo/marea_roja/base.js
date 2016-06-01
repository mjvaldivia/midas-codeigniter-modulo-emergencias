$(document).ready(function() {
    
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
    
    $(".adjuntar-acta").livequery(function(){
        $(this).unbind( "click" );
        $(this).click(function(e){
            e.preventDefault();
            var id = $(this).data("muestra");
            var acta = $(this).data("acta");
            xModal.open(siteUrl + 'marea_roja/adjuntarActa/id/'+id,'Adjuntar Acta Muestra Nº '+acta);
        });
    });
    
    $(".ver-acta").livequery(function(){
        $(this).unbind( "click" );
        $(this).click(function(e){
            e.preventDefault();
            var id = $(this).data("muestra");
            var acta = $(this).data("acta");
            xModal.open(siteUrl + 'marea_roja/verActas/id/'+id,'Actas para Muestra Nº '+acta,'lg');
        });
    });
});

