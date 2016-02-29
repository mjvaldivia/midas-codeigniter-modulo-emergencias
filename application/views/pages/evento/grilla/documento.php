<div class="col-lg-12" data-row="10">
    <table class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th width="10%">Fecha</th>
                <th width="20%">Tipo</th>
                <th width="50%">Descripción</th>
                <th width="40%">Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0) { ?>
            <?php foreach($lista as $documento) { ?>
            <tr>
                <td width="10%" valign="top">
                    <?php echo ISODateTospanish($documento["arch_f_fecha"]); ?>
                </td>
                <td width="20%" valign="top">
                    <?php echo nombreArchivoTipo($documento["arch_c_tipo"]); ?>
                </td>
                <td width="50%" valign="top">
                    <?php echo $documento["arch_c_descripcion"]; ?>
                </td>
                <td width="40%" valign="top">
                   <?php echo linkArchivo($documento["arch_ia_id"]); ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
