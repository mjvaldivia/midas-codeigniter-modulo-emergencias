<div data-row="10">
    <table id="grilla-documentos" class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Por</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="5%" align="center">
                    <input type="checkbox" name="seleccion[]" value="<?php echo $row["arch_ia_id"] ?>" class="seleccion-archivo" />
                </td>
                <td width="30%" align="left">
                    <a href="<?php echo site_url("archivo/download_file/hash/" . $row["arch_c_hash"]); ?>" target="_blank">
                        <?php echo basename($row["arch_c_nombre"]); ?>
                    </a>
                </td>
                <td width="5%" align="left">
                    <?php echo ISODateTospanish($row["arch_f_fecha"]); ?>
                </td>
                <td width="10%" align="left">
                    <?php echo nombreArchivoTipo($row["arch_c_tipo"]); ?>
                </td>
                <td width="15%" align="center">
                    <?php echo nombreUsuario($row["usu_ia_id"]); ?>
                </td>
                <td width="30%">
                    <?php echo $row["arch_c_descripcion"]; ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>