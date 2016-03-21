<table id="tblCapas" class="table table-bordered table-striped datatable paginada hidden small">
    <thead>
    <tr>
        <th class="text-center">Nombre</th>
        <th class="text-center">Categoría</th>
        <th class="text-center">Ícono</th>
        <th class="text-center">Propiedades</th>
        <th class="text-center">Región</th>
        <th class="text-center">Subida por</th>
        <!--<td>Nombre Archivo</td>-->
        <!--<td>Archivo</td>-->
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lista as $row) { ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td><?php echo $row['cap_c_nombre']; ?></td>
            <td class="text-center"><?php echo $row['ccb_c_categoria']; ?></td>
            <td align="center"><?php echo getCapaPreview($row["cap_ia_id"]); ?></td>
            <td><?php echo textMoreLess($row['cap_c_propiedades']) ?></td>
            <td class="text-center">
                <?php if (empty($row['nombre_region'])): ?>
                    Nacional
                <?php else: ?>
                    <?php echo $row['nombre_region']; ?>
                <?php endif; ?>
            </td>
            <td class="text-center"><?php echo $row['nombre_usuario'] ?></td>
            <td class="text-center">
                <?php if ($row['existen_errores']): ?>
                    <button type="button" class="btn btn-sm btn-warning btn-square" onclick="Layer.revisarErrores(<?php echo $row['cap_ia_id'] ?>);">
                        <i class="fa fa-question"></i></button>
                <?php endif; ?>
                <button class="btn btn-sm btn-success btn-square" type="button" title="Ver Detalle" onclick="Layer.listarCapasDetalle(<?php echo $row['cap_ia_id'] ?>,'<?php echo $row['cap_c_nombre'] ?>')">
                    <i class="fa fa-bars"></i></button>
                <?php if ($puedeEditar or (!$puedeEditar and $row['id_usuario'] == $usuario)): ?>
                    <button class="btn btn-sm btn-primary btn-square" type="button" title="Ver Detalle" onclick="Layer.editarCapa(<?php echo $row['cap_ia_id'] ?>,'<?php echo $row['cap_c_nombre'] ?>')">
                        <i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-square" type="button" title="Ver Detalle" onclick="Layer.eliminarCapa(<?php echo $row['cap_ia_id'] ?>,'<?php echo $row['cap_c_nombre'] ?>')">
                        <i class="fa fa-trash-o"></i></button>
                <?php endif; ?>

                <button type="button" class="btn btn-sm btn-info btn-square" title="Descargar GEOJSON" onclick="window.open('<?php echo site_url('capas/descargarGeoJSON/id/'.$row['cap_ia_id'])?>','_blank');" target="_blank">
                    <i class="fa fa-download"></i>
                </button>
                <!--
                <?php /*if (puedeEditar("capas")) { */ ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarCapa(<?php /*echo $row['cap_ia_id']; */ ?>);' >
                    <i class='fa fa-edit'></i>
                </a>
                <?php /*} */ ?>
                
                <?php /*if (puedeEliminar("capas")) { */ ?>
                <a class='btn btn-xs btn-danger btn-square' onclick='Layer.eliminarCapa(<?php /*echo $row['cap_ia_id']; */ ?>)'>
                    <i class='fa fa-trash'></i>
                </a>
                <?php /*} */ ?> -->
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table> 

