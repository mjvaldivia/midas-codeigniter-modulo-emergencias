<table id="tblCapas" class="table table-bordered table-striped datatable paginada hidden">
    <thead>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Categoría</th>
            <!--<td>Zona Geográfica</td>-->
            <th class="text-center">Total Items</th>
            <th class="text-center">Ícono o Color</th>
            <!--<td>Propiedades</td>-->
            <!--<td>Nombre Archivo</td>
            <td>Archivo</td>-->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if($lista):?>
        <?php foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td><?php echo $row['geometria_nombre']; ?></td>
            <td><?php echo $row['ccb_c_categoria']; ?></td>
            <td class="text-center"><a href="javascript:void(0);" onclick="Layer.listarItemsSubCapa(<?php echo $row['geometria_id']?>)"><?php echo $row['total_items']?></a></td>
            <!--<td><?php /*echo $row['geozone']; */?></td>-->
            <td align="center">
                <?php if(is_null($row['geometria_icono']) or empty($row['geometria_icono'])):?>
                    <?php echo getCapaPreview($row["cap_ia_id"]); ?>
                <?php else:?>
                    <?php if($row['geometria_tipo'] == 1):?>
                    <img src="<?php echo base_url($row['geometria_icono'])?>" />
                    <?php else:?>
                        <div class="color-capa-preview" style="background-color:<?php echo $row['geometria_icono']?>"></div>
                    <?php endif;?>
                <?php endif;?>

            </td>
            <!--<td><?php /*echo $row['cap_c_propiedades']; */?></td>-->
            <!--<td><?php /*echo basename(FCPATH . $row['capa']); */?></td>-->
            <!--<td><?php /*echo getLinkFileGeozone(FCPATH . $row['capa'], $row['arch_c_hash']); */?> </td>-->
            <td class="text-center">
                <?php if (puedeEditar("capas")) { ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarSubCapa(<?php echo $row['geometria_id']; ?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php } ?>
                
                <?php if (puedeEliminar("capas")) { ?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarSubCapa(<?php echo $row['geometria_id']; ?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <?php endif;?>
    </tbody>
</table> 

