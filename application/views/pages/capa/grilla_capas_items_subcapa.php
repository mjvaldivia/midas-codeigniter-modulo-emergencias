<table id="tblCapas" class="table table-bordered table-striped datatable paginada">
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
        <?php foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td class="text-center"><?php echo $row['comuna']; ?></td>
            <td class="text-center"><?php echo $row['provincia']; ?></td>
            <td class="text-center"><?php echo $row['region']?></td>
            <?php foreach($row['propiedades'] as $prop):?>
            <td class="text-center"><?php echo $prop;?></td>
            <?php endforeach;?>
            <td class="text-center">
                <?php if (puedeEditar("capas")) { ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarItemSubCapa(<?php echo $row['id']; ?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php } ?>
                
                <?php if (puedeEliminar("capas")) { ?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarItemSubcapa(<?php echo $row['id']; ?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table> 

