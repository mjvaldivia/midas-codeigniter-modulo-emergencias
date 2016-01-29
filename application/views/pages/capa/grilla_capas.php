<table id="tblCapas" class="table table-bordered table-striped datatable paginada hidden small">
    <thead>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Categoría</th>
            <th class="text-center">Ícono</th>
            <th class="text-center">Propiedades</th>
            <!--<td>Región</td>
            <td># GeoJSON cargados</td>-->
            <!--<td>Nombre Archivo</td>-->
            <!--<td>Archivo</td>-->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td><?php echo $row['cap_c_nombre']; ?></td>
            <td class="text-center"><?php echo $row['ccb_c_categoria']; ?></td>
            <td align="center"><?php echo getCapaPreview($row["cap_ia_id"]); ?></td>
            <td><?php echo textMoreLess($row['cap_c_propiedades'])?></td>
           <!-- <td><?php /*echo $row['nombre_region']; */?></td>-->
            <!--<td class="text-center"><?php /*echo $row['total_geojson']*/?></td>-->
            <!--<td><?php echo basename(FCPATH . $row['capa']); ?></td>-->
            <!--<td><?php echo getLinkFileGeozone(FCPATH . $row['capa'], $row['arch_c_hash']); ?> </td>-->
            <td class="text-center">
                <?php if($row['existen_errores']):?>
                <button type="button" class="btn btn-sm btn-warning btn-square" onclick="Layer.revisarErrores(<?php echo $row['cap_ia_id']?>);"><i class="fa fa-question"></i></button>
                <?php endif;?>
                <button class="btn btn-sm btn-success btn-square" type="button" title="Ver Detalle" onclick="Layer.listarCapasDetalle(<?php echo $row['cap_ia_id']?>,'<?php echo $row['cap_c_nombre']?>')" ><i class="fa fa-bars"></i></button>
                <button class="btn btn-sm btn-primary btn-square" type="button" title="Ver Detalle" onclick="Layer.editarCapa(<?php echo $row['cap_ia_id']?>,'<?php echo $row['cap_c_nombre']?>')" ><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger btn-square" type="button" title="Ver Detalle" onclick="Layer.eliminarCapa(<?php echo $row['cap_ia_id']?>,'<?php echo $row['cap_c_nombre']?>')" ><i class="fa fa-trash-o"></i></button>
                <!--
                <?php /*if (puedeEditar("capas")) { */?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarCapa(<?php /*echo $row['cap_ia_id']; */?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php /*} */?>
                
                <?php /*if (puedeEliminar("capas")) { */?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarCapa(<?php /*echo $row['cap_ia_id']; */?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php /*} */?> -->
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table> 

