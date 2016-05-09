$(document).ready(function(){

    $('.revisar-hallazgo').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('hallazgo');
            location.href = siteUrl + 'hallazgos/revisar/id/'+vector;
        });

    });

    $('.revisar-hallazgo-entomologo').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('hallazgo');
            location.href = siteUrl + 'hallazgos/revisarDenuncia/id/'+vector;
        });

    });
});