$(document).ready(function(){

    $('.revisar-vector').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('vector');
            location.href = siteUrl + 'vectores/revisar/id/'+vector;
        });

    });

    $('.revisar-vector-entomologo').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('vector');
            location.href = siteUrl + 'vectores/revisarDenuncia/id/'+vector;
        });

    });
});