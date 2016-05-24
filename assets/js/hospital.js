$(document).ready(function() {
    recargaGrilla();
    
    $(".caso-eliminar").livequery(function(){
        $(this).unbind( "click" );
        $(this).click(function(e){
           e.preventDefault();
           var id = $(this).attr("data");
           
           bootbox.dialog({
                title: "Eliminar elemento",
                message: '¿Está seguro que desea eliminar este hospital?',
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
                                 url: siteUrl + "hospital/eliminar", 
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
    $.ajax({         
        dataType: "html",
        cache: false,
        async: true,
        data: "",
        type: "post",
        url: siteUrl + "hospital/ajax_lista", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(html){
            $("#resultados").html(html);
        }
    });
}