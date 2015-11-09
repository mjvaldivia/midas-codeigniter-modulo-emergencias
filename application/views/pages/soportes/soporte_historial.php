<div class="col-xs-12">
    <div class="portlet portlet-green">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Historial Ticket # <?php echo $soporte->soporte_codigo?></h4>
            </div>
        </div>

        <div class="portlet-body">
            
            <div class="table-responsive small">
                <table class="table table-middle table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Evento</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($historial as $item):?>
                        <tr>
                            <td class="text-center"><?php echo $item->soportehistorial_fecha?></td>
                            <td class="text-center"><?php echo mb_strtoupper($item->nombre_usuario)?></td>
                            <td class="text-center"><?php echo mb_strtoupper($item->soportehistorial_evento)?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-default btn-square" onclick="ModalSipresa.close_modal('modal_historial_soporte');">Cerrar</button>
            </div>
        </div>
    </div>
</div>