<div class="col-lg-12" data-row="10">
    <table class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th width="10%">Fecha</th>
                <th >Tipo</th>
                <th >Descripción</th>
                <th >Nombre</th>
                <th >Subido por</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0) { ?>
            <?php foreach($lista as $documento) { ?>
            <tr>
                <td  width="10%" valign="top">
                    <?php echo ISODateTospanish($documento["arch_f_fecha"]); ?>
                </td>
                <td valign="top">
                    <?php echo nombreArchivoTipo($documento["arch_c_tipo"]); ?>
                </td>
                <td valign="top">
                    <?php echo $documento["arch_c_descripcion"]; ?>
                </td>
                <td valign="top">
                   <?php echo linkArchivo($documento["arch_ia_id"]); ?>
                </td>
                <td valign="top">
                    <?php echo $documento['usu_c_nombre'].' '.$documento['usu_c_apellido_paterno'].' '.$documento['usu_c_apellido_materno']?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
