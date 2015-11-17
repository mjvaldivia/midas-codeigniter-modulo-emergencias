<table id="tblCapas" class="table table-bordered table-striped datatable paginada hidden">
    <thead>
        <tr>
            <td>Nombre</td>
            <td>Categoría</td>
            <td>Zona Geográfica</td>
            <td>Ícono</td>
            <td>Propiedades</td>
            <td>Nombre Archivo</td>
            <td>Archivo</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lista as $row){ ?>
        <?php // echo BASEPATH . $row['capa']; ?>
        <tr>
            <td><?php echo $row['cap_c_nombre']; ?></td>
            <td><?php echo $row['ccb_c_categoria']; ?></td>
            <td><?php echo $row['geozone']; ?></td>
            <td><img src="<?php echo base_url($row['icono']) ?>" height="24" /></td>
            <td><?php echo $row['cap_c_propiedades']; ?></td>
            <td><?php echo basename(FCPATH . $row['capa']); ?></td>
            <td><?php echo getLinkFileGeozone(FCPATH . $row['capa'], $row['arch_c_hash']); ?> </td>
            <td>
                <?php if (puedeEditar("capas")) { ?>
                <a class='btn btn-xs btn-default btn-square' onclick='Layer.editarCapa(<?php echo $row['cap_ia_id']; ?>);' >
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

