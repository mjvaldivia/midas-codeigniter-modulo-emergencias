<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class="portlet portlet-blue">
                <div class="portlet-heading">
                    <div class="portlet-title"><h4>Información Alarma</h4></div>
                </div>
                <div class="list-group small" style="margin-bottom: 0;">
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Nombre Alarma</h4>
                        <p class="list-group-item-text"><?php echo $alarma->ala_c_nombre_emergencia?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Nombre Informante</h4>
                        <p class="list-group-item-text"><?php echo $alarma->ala_c_nombre_informante?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Lugar</h4>
                        <p class="list-group-item-text"><?php echo $alarma->ala_c_lugar_emergencia?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Tipo Alarma</h4>
                        <p class="list-group-item-text"><?php echo $tipo_emergencia->aux_c_nombre?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Estado Alarma</h4>
                        <p class="list-group-item-text"><?php echo $estado_alarma->est_c_nombre?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Fecha Alarma</h4>
                        <p class="list-group-item-text"><?php echo ISODateTospanish($alarma->ala_d_fecha_emergencia)?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Comunas afectadas</h4>
                        <p class="list-group-item-text"><?php echo $comunas?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Observaciones Preliminares</h4>
                        <p class="list-group-item-text"><?php echo $alarma->ala_c_observacion?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Fecha Recepción</h4>
                        <p class="list-group-item-text"><?php echo ISODateTospanish($alarma->ala_c_fecha_recepcion)?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-7">

            <div class="portlet portlet-blue">
                <div class="portlet-heading">
                    <div class="portlet-title"><h4>Datos de la emergencia</h4></div>
                </div>
                <?php if(count($datos) > 0):?>
                    <div class="list-group small" style="margin-bottom: 0;">
                        <?php foreach($datos as $item=>$valor):?>
                            <div class="list-group-item">
                                <h4 class="list-group-item-heading"><?php echo $item?></h4>
                                <p class="list-group-item-text"><?php echo $valor?></p>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php else:?>
                <div class="portlet-body">
                    Sin datos
                </div>
                <?php endif;?>
            </div>



        </div>
    </div>

    <div class="portlet portlet-blue">
        <div class="portlet-heading">
            <div class="portlet-title"><h4 class="">Eventos</h4></div>
        </div>
        <div class="portlet-body small ">
        <?php if($historial):?>
            <table class="table table-hover table-condensed table-bordered paginada dataTable" style="margin-bottom: 0;">
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
            <p class="text-bold">Alarma sin registros de eventos</p>
        <?php endif;?>
        </div>
    </div>





</div>

<div class="col-xs-12 text-right">
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".dataTable").DataTable();
    });
</script>