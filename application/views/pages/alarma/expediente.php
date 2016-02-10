<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet portlet-dark-blue">
                <div class="portlet-heading">
                    <div class="portlet-title"><h4>Información Evento</h4></div>
                </div>
                <table class="table table-condensed table-hover table-bordered" style="margin-bottom: 0;">
                    <tbody>
                    <tr>
                        <td class="text-right text-bold bg-primary bg-primary" width="25%" >Nombre Evento</td>
                        <td class="text-left active active" width="25%" ><?php echo $emergencia->eme_c_nombre_emergencia?></td>

                        <td class="text-right text-bold bg-primary" width="25%" >Estado Evento</td>
                        <td class="text-left active" width="25%" ><?php echo $estado_alarma->est_c_nombre?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Nombre Informante</td>
                        <td class="text-left active" ><?php echo $emergencia->eme_c_nombre_informante?></td>

                        <td class="text-right text-bold bg-primary" >Fecha Evento</td>
                        <td class="text-left active" ><?php echo ISODateTospanish($emergencia->eme_d_fecha_emergencia)?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Lugar</td>
                        <td class="text-left active" ><?php echo $emergencia->eme_c_lugar_emergencia?></td>

                        <td class="text-right text-bold bg-primary" >Comunas afectadas</td>
                        <td class="text-left active" ><?php echo $comunas?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Tipo Evento</td>
                        <td class="text-left active" ><?php echo $tipo_emergencia->aux_c_nombre?></td>

                        <td class="text-right text-bold bg-primary" >Fecha recepción</td>
                        <td class="text-left active" ><?php echo ISODateTospanish($emergencia->eme_d_fecha_recepcion)?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <hr/>

    <div class="top-spaced">
        <!-- TAB NAVIGATION -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Reportes</a></li>
            <li><a href="#tab2" role="tab" data-toggle="tab">Actividades</a></li>
        </ul>
        <!-- TAB CONTENT -->
        <div class="tab-content">
            <div class="active tab-pane fade in small" id="tab1">
                <div class="col-xs-12 top-spaced">
                    <?php if($documentos):?>
                        <table class="table table-hover table-condensed table-bordered tabla-expediente" style="margin-bottom: 0;">
                            <thead>
                            <tr>
                                <th width="25%">Fecha</th>
                                <th>Archivo</th>
                                <th>Usuario</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($documentos as $item):?>
                                <tr>
                                    <td class="text-center" width="25%"><?php echo ISODateTospanish($item['fecha'])?></td>
                                    <td><?php echo $item['nombre']?></td>
                                    <td class="text-center"><?php echo $item['usuario']?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url("archivo/download_file/k/" . $item['hash'])?>" class="btn btn-sm btn-primary btn-square" target="_blank"><i class="fa fa-file-o"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach;?>
                            </tbody>
                        </table>

                    <?php else:?>
                        <div class="top-spaced">
                            <p class="text-bold">Evento sin documentos</p>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="tab-pane fade small" id="tab2">
                <div class="col-xs-12 top-spaced">
                    <?php if($historial):?>
                        <table class="table table-hover table-condensed table-bordered tabla-expediente" style="margin-bottom: 0;">
                            <thead>
                            <tr>
                                <th width="25%">Fecha</th>
                                <th>Evento</th>
                                <th>Usuario</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($historial as $item):?>
                                <tr>
                                    <td class="text-center" width="25%"><?php echo ISODateTospanish($item['historial_fecha'])?></td>
                                    <td><?php echo $item['historial_comentario']?></td>
                                    <td class="text-center"><?php echo $item['nombre_usuario']?></td>
                                </tr>

                            <?php endforeach;?>
                            </tbody>
                        </table>

                    <?php else:?>
                        <div class="top-spaced">
                            <p class="text-bold">Alarma sin registros de eventos</p>
                        </div>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 text-right top-spaced">
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".tabla-expediente").dataTable({
            language:
            {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>