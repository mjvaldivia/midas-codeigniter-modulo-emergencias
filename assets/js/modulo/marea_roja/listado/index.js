$(document).ready(function() {
    
    
    $("#buscar").click(function(e){
        recargaGrilla();
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
        url: siteUrl + "marea_roja_listado/ajax_lista", 
        error: function(xhr, textStatus, errorThrown){

        },
        success:function(html){
            $("#resultados").html(html);
        }
    });
}