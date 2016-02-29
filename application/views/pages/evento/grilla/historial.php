<div class="col-lg-12" data-row="10">
    <table class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th width="20%">Fecha</th>
                <th width="60%">Evento</th>
                <th width="20%">Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $historial) { ?>
            <tr>
                <td width="20%" valign="top">
                    <?php echo ISODateTospanish($historial["historial_fecha"]); ?>
                </td>
                <td width="60%" valign="top">
                    <?php echo $historial["historial_comentario"]; ?>
                </td>
                <td width="20%" valign="top">
                    <?php echo nombreUsuario($historial["historial_usuario"]); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
