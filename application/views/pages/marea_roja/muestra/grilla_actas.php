<table class="table table-bordered table-condensed table-hover paginada small">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Ver</th>
    </tr>
    </thead>
    <?php if ($listado): ?>
        <tbody>
        <?php foreach ($listado as $item): ?>
            <tr>
                <td class="text-center"><?php echo ISODateTospanish($item['fc_fecha_acta']) ?></td>
                <td class="text-center"><?php echo $item['gl_nombre_acta'] ?></td>
                <td class="text-center">
                    <a href="<?php echo base_url('marea_roja/ver_acta/id/' . $item['id_acta'] . '/token/' . $item['gl_sha_acta']) ?>"
                       target="_blank" class="btn btn-sm btn-primary btn-square"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php endif; ?>

</table>