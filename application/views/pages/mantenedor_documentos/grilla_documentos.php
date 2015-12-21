<div data-row="10">
    <table id="grilla-documentos" class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Por</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="5%" align="center">
                    <input type="checkbox" name="seleccion[]" value="<?php echo $row["arch_ia_id"] ?>" />
                </td>
                <td width="40%" align="left">
                    <a href="<?php echo site_url("archivo/download_file/k/" . $row["arch_c_hash"]); ?>" target="_blank">
                        <?php echo basename($row["arch_c_nombre"]); ?>
                    </a>
                </td>
                <td width="15%" align="left">
                    <?php echo ISODateTospanish($row["arch_f_fecha"]); ?>
                </td>
                <td width="20%" align="left">
                    <?php echo $row["arch_c_mime"]; ?>
                </td>
                <td width="15%" align="center">
                    <?php echo nombreUsuario($row["usu_ia_id"]); ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>