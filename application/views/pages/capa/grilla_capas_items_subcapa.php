<table class="table table-bordered table-striped " id="tabla_items_subcapa">
    <thead>
        <tr>
            <th class="text-center">Comuna</th>
            <th class="text-center">Provincia</th>
            <th class="text-center">Región</th>
            <?php foreach($cabeceras as $cabecera):?>
            <th class="text-center"><?php echo $cabecera?></th>
            <?php endforeach;?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php //foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <!-- <tr>
            <td class="text-center"><?php echo $row['comuna']; ?></td>
            <td class="text-center"><?php echo $row['provincia']; ?></td>
            <td class="text-center"><?php echo $row['region']?></td>
            <?php //foreach($row['propiedades'] as $prop):?>
            <td class="text-center"><?php echo $prop;?></td>
            <?php //endforeach;?>
            <td class="text-center">
                <?php //if (puedeEditar("capas")) { ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarItemSubcapa(<?php echo $row['id']; ?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php //} ?>
                
                <?php //if (puedeEliminar("capas")) { ?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarItemSubcapa(<?php echo $row['id']; ?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php //} ?>
            </td>
        </tr> -->
        <?php //} ?>
        
    </tbody>
</table> 


<script type="text/javascript">
$(document).ready(function(){
    $('#tabla_items_subcapa').dataTable({
        language:
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
        "bProcessing": true,          
        "bServerSide": true,          
        "sServerMethod": "POST",
        "sAjaxSource": siteUrl + "capas/ajax_grilla_items_subcapas_server/subcapa/<?php echo $subcapa?>",
        "iDisplayLength": 10,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
        "aaSorting": [[0, 'asc']]
        /*"aoColumns": [
            { "bVisible": true, "bSearchable": true, "bSortable": true },
            { "bVisible": true, "bSearchable": true, "bSortable": true },
            { "bVisible": true, "bSearchable": true, "bSortable": true }
        ]*/
    }); 
});
</script>

