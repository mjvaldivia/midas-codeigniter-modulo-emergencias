$(document).ready(function() {
    
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

