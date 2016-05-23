<?php if ($listado): ?>

    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <?php $i = 0; ?>
        <?php foreach ($listado as $item): ?>
            <?php if ($i == 0): ?>
                <li class="active"><a href="#tab<?php echo $i; ?>" role="tab"
                                      data-toggle="tab"><?php echo $item['gl_nombre_acta'] ?></a></li>
            <?php else: ?>
                <li><a href="#tab<?php echo $i ?>" role="tab" data-toggle="tab"><?php echo $item['gl_nombre_acta'] ?></a>
                </li>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endforeach; ?>

    </ul>
    <!-- TAB CONTENT -->
    <div class="tab-content">
        <?php $i = 0; ?>
        <?php foreach ($listado as $item): ?>
            <?php if ($i == 0): ?>
                <div class="active tab-pane fade in" id="tab<?php echo $i?>">
                    <div class="alert alert-info">Ingresada el <?php echo ISODateTospanish($item['fc_fecha_acta'])?></div>
                    <iframe src="<?php echo base_url('marea_roja/ver_acta/id/' . $item['id_acta'] . '/token/' . $item['gl_sha_acta']) ?>" frameborder="0" height="700" class="col-xs-12"></iframe>
                </div>
            <?php else: ?>
                <div class="tab-pane fade" id="tab<?php echo $i?>">
                    <div class="alert alert-info">Ingresada el <?php echo ISODateTospanish($item['fc_fecha_acta'])?></div>
                    <iframe src="<?php echo base_url('marea_roja/ver_acta/id/' . $item['id_acta'] . '/token/' . $item['gl_sha_acta']) ?>" frameborder="0" height="700" class="col-xs-12"></iframe>
                </div>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endforeach; ?>

    </div>

<?php endif; ?>

<!--
<table class="table table-bordered table-condensed table-hover paginada small">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Ver</th>
    </tr>
    </thead>
    <?php /*if ($listado): */?>
        <tbody>
        <?php /*foreach ($listado as $item): */?>
            <tr>
                <td class="text-center"><?php /*echo ISODateTospanish($item['fc_fecha_acta']) */?></td>
                <td class="text-center"><?php /*echo $item['gl_nombre_acta'] */?></td>
                <td class="text-center">
                    <a href="<?php /*echo base_url('marea_roja/ver_acta/id/' . $item['id_acta'] . '/token/' . $item['gl_sha_acta']) */?>"
                       target="_blank" class="btn btn-sm btn-primary btn-square"><i class="fa fa-search"></i></a>
                </td>
            </tr>
        <?php /*endforeach; */?>
        </tbody>
    <?php /*endif; */?>

</table>-->