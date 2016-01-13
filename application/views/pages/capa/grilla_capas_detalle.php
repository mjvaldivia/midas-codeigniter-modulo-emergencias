<table id="tblCapas" class="table table-bordered table-striped datatable paginada hidden">
    <thead>
        <tr>
            <td>Nombre</td>
            <td>Categoría</td>
            <!--<td>Zona Geográfica</td>-->
            <td>Ícono o Color</td>
            <!--<td>Propiedades</td>-->
            <!--<td>Nombre Archivo</td>
            <td>Archivo</td>-->
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td><?php echo $row['geometria_nombre']; ?></td>
            <td><?php echo $row['ccb_c_categoria']; ?></td>
            <!--<td><?php /*echo $row['geozone']; */?></td>-->
            <td align="center">
                <?php if(is_null($row['geometria_icono']) or empty($row['geometria_icono'])):?>
                    <?php echo getCapaPreview($row["cap_ia_id"]); ?>
                <?php else:?>
                    <img src="<?php echo base_url($row['geometria_icono'])?>" />
                <?php endif;?>

            </td>
            <!--<td><?php /*echo $row['cap_c_propiedades']; */?></td>-->
            <!--<td><?php /*echo basename(FCPATH . $row['capa']); */?></td>-->
            <!--<td><?php /*echo getLinkFileGeozone(FCPATH . $row['capa'], $row['arch_c_hash']); */?> </td>-->
            <td>
                <?php if (puedeEditar("capas")) { ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarSubCapa(<?php echo $row['geometria_id']; ?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php } ?>
                
                <?php if (puedeEliminar("capas")) { ?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarCapa(<?php echo $row['cap_ia_id']; ?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table> 

