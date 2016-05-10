<table id="grilla" class="table table-hover datatable paginada hidden">
    <thead>
    <tr>
        <th>Código</th>
        <th>Fecha Registro</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Fecha Hallazgo</th>
        <th>Estado</th>
        <th>Resultado</th>
        <th width="100"></th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($listado) > 0) { ?>
        <?php foreach ($listado as $row) { ?>
            <tr>
                <td class="text-center">I-<?php echo $row["id_hallazgo"]; ?></td>
                <td class="text-center"><?php echo Fechas::formatearHtml($row["fc_fecha_registro_hallazgo"]); ?></td>

                <td class="text-center"><?php echo $row['gl_nombres_hallazgo'] . ' ' . $row['gl_apellidos_hallazgo'] ?></td>


                <td class="text-center"><?php echo $row["gl_direccion_hallazgo"]; ?></td>
                <td class="text-center"><?php echo $row["gl_telefono_hallazgo"]; ?></td>
                <td class="text-center"><?php echo Fechas::formatearHtml($row["fc_fecha_hallazgo_hallazgo"]); ?></td>
                <td class="text-center">
                    <?php if ($row['cd_estado_hallazgo'] == 0 and $row['cd_enviado_hallazgo'] == 0): ?>
                        <span class="label label-primary">Ingresado</span>
                    <?php elseif ($row['cd_estado_hallazgo'] > 0 and $row['cd_enviado_hallazgo'] == 0): ?>
                        <span class="label label-info">Revisado -  Respondido</span>
                    <?php elseif ($row['cd_estado_hallazgo'] > 0 and $row['cd_enviado_hallazgo'] == 1): ?>
                        <span class="label label-success">Enviado</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if ($row['cd_estado_hallazgo'] == 0): ?>
                        <span class="label label-default">En Revisión</span>
                    <?php elseif ($row['cd_estado_hallazgo'] == 1): ?>
                        <span class="label label-danger">Positivo</span>
                    <?php elseif ($row['cd_estado_hallazgo'] == 2): ?>
                        <span class="label label-primary">Negativo</span>
                    <?php elseif ($row['cd_estado_hallazgo'] == 3): ?>
                        <span class="label label-info">No concluyente</span>
                    <?php endif; ?>
                </td>
                <td align="center" width="100">
                    <div class="btn-group">
                        <?php if ($entomologo and $row['cd_estado_hallazgo'] == 0): ?>
                            <button data-rel="<?php echo $row["id_hallazgo"]; ?>" title="Revisar"
                                    class="btn btn-sm btn-success btn-square revisar-hallazgo-entomologo" type="button"
                                    data-hallazgo="<?php echo $row['id_hallazgo'] ?>">
                                <i class="fa fa-edit"></i>
                            </button>
                        <?php else: ?>
                            <?php if ($admin): ?>
                                <button data-rel="<?php echo $row["id_hallazgo"]; ?>" title="Revisar Inspeccion"
                                        class="btn btn-sm btn-success btn-square revisar-hallazgo" type="button"
                                        data-hallazgo="<?php echo $row['id_hallazgo']?>">
                                    <i class="fa fa-search"></i>
                                </button>
                            <?php endif; ?>
                            <?php /*if (!$entomologo and $row['cd_estado_hallazgo'] > 0 and $row['cd_enviado_hallazgo'] == 0): */ ?><!--
                                <button data-rel="<?php /*echo $row["id_hallazgo"]; */ ?>" title="Enviar Resultado"
                                        class="btn btn-sm btn-success btn-square revisar-hallazgo" type="button"
                                        data-hallazgo="<?php /*echo $row['id_hallazgo'] */ ?>">
                                    <i class="fa fa-send"></i>
                                </button>
                                <button title="Eliminar" class="btn btn-sm btn-square btn-danger caso-eliminar"
                                        type="button" data="<?php /*echo $row["id_hallazgo"] */ ?>" href="#">
                                    <i class="fa fa-trash"></i>
                                </button>
                            <?php /*elseif ($row['cd_enviado_hallazgo'] == 1 and !empty($row['gl_ruta_respuesta_hallazgo'])): */ ?>
                                <a href="<?php /*echo base_url($row['gl_ruta_respuesta_hallazgo'])*/ ?>" target="_blank" class="btn btn-primary btn-sm btn-square"><i class="fa fa-file-pdf-o"></i></a>
                            --><?php /*endif; */ ?>


                        <?php endif; ?>

                        <?php if ($row['cd_estado_hallazgo'] == 0 and !$entomologo): ?>
                            <a href="<?php echo base_url('vectores_hallazgos/adjuntarImagenesInspeccion/id/' . $row['id_hallazgo']) ?>"
                               title="Adjuntar Imagenes" class="btn btn-sm btn-square btn-warning">
                                <i class="fa fa-file-image-o"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>