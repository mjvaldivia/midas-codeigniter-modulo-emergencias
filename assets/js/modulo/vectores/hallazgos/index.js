$(document).ready(function(){

    $('.revisar-hallazgo').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('hallazgo');
            location.href = siteUrl + 'vectores_hallazgos/revisar/id/'+vector;
        });

    });

    $('.revisar-hallazgo-entomologo').livequery(function(){

        $(this).click(function(){
            var vector = $(this).data('hallazgo');
            location.href = siteUrl + 'vectores_hallazgos/revisarDenuncia/id/'+vector;
        });

    });


    $("#grilla-inspecciones").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url : siteUrl + 'vectores_hallazgos/ajax_lista/',
            type: 'POST'
        },
        "language":
        {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });
});