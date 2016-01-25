<div class="col-xs-12">
    <?php if($historial):?>
        <table class="table table-hover table-condensed table-bordered small">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Evento</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($historial as $item):?>
                <tr>
                    <td class="text-center"><?php echo ISODateTospanish($item['historial_fecha'])?></td>
                    <td><?php echo $item['historial_comentario']?></td>
                    <td class="text-center"><?php echo $item['nombre_usuario']?></td>
                </tr>

            <?php endforeach;?>
            </tbody>
        </table>

    <?php else:?>
        <div class="alert alert-warning">
            <p>Alarma sin registros de expediente</p>
        </div>
    <?php endif;?>

</div>

<div class="col-xs-12 text-right">
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>