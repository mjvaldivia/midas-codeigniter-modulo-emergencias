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