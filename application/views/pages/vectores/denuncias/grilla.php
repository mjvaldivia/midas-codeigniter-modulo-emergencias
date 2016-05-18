<table id="grilla" class="table table-hover datatable paginada hidden">
    <thead>
    <tr>
        <th>Código</th>
        <th>Fecha Registro</th>
        <th>Nombre</th>
        <th>RUT / Pasaporte</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Fecha Hallazgo</th>
        <th>Fecha Entrega</th>
        <th>Estado</th>
        <th>Resultado</th>
        <th width="200"></th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($listado) > 0) { ?>
        <?php foreach ($listado as $row) { ?>
            <tr>
                <td class="text-center">D-<?php echo $row["id_vector"]; ?></td>
                <td class="text-center"><?php echo Fechas::formatearHtml($row["fc_fecha_registro_vector"]); ?></td>

                <td class="text-center"><?php echo $row['gl_nombres_vector'] . ' ' . $row['gl_apellidos_vector'] ?></td>

                <td class="text-center"><?php echo $row["gl_run_vector"]; ?></td>

                <td class="text-center"><?php echo $row["gl_direccion_vector"]; ?></td>
                <td class="text-center"><?php echo $row["gl_telefono_vector"]; ?></td>
                <td class="text-center"><?php echo $row["gl_email_vector"]; ?></td>
                <td class="text-center"><?php echo Fechas::formatearHtml($row["fc_fecha_hallazgo_vector"]); ?></td>
                <td class="text-center"><?php echo Fechas::formatearHtml($row["fc_fecha_entrega_vector"]); ?></td>
                <td class="text-center">
                    <?php if ($row['cd_estado_vector'] == 0 and $row['cd_enviado_vector'] == 0): ?>
                        <span class="label label-primary">Ingresado</span>
                    <?php elseif ($row['cd_estado_vector'] > 0 and $row['cd_enviado_vector'] == 0): ?>
                        <span class="label label-info">Revisado -  Respondido</span>
                    <?php elseif ($row['cd_estado_vector'] > 0 and $row['cd_enviado_vector'] == 1): ?>
                        <span class="label label-success">Enviado</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if ($row['cd_estado_vector'] == 0): ?>
                        <span class="label label-default">En Revisión</span>
                    <?php elseif ($row['cd_estado_vector'] == 1): ?>
                        <span class="label label-danger">Positivo</span>
                    <?php elseif ($row['cd_estado_vector'] == 2): ?>
                        <span class="label label-primary">Negativo</span>
                    <?php elseif ($row['cd_estado_vector'] == 3): ?>
                        <span class="label label-info">No concluyente</span>
                    <?php endif; ?>
                </td>
                <td align="center" width="100">
                    <div class="btn-group">
                        <a href="<?php echo base_url('vectores/descargarComprobanteDenuncia/id/' . $row['id_vector']) ?>"
                           title="Descargar Comprobante" class="btn btn-sm btn-square btn-info" target="_blank"
                           download>
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <?php if (!$presidencia): ?>
                            <?php if ($entomologo and $row['cd_estado_vector'] == 0): ?>
                                <button data-rel="<?php echo $row["id_vector"]; ?>" title="Revisar"
                                        class="btn btn-sm btn-success btn-square revisar-vector-entomologo"
                                        type="button"
                                        data-vector="<?php echo $row['id_vector'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php endif; ?>
                            <?php if ($row['cd_estado_vector'] >= 0 and $row['cd_enviado_vector'] == 0): ?>
                                <button data-rel="<?php echo $row["id_vector"]; ?>" title="Enviar Resultado"
                                        class="btn btn-sm btn-success btn-square revisar-vector" type="button"
                                        data-vector="<?php echo $row['id_vector'] ?>">
                                    <i class="fa fa-send"></i>
                                </button>
                                <!--<button title="Eliminar" class="btn btn-sm btn-square btn-danger caso-eliminar"
                                    type="button" data="<?php /*echo $row["id_vector"] */ ?>" href="#">
                                <i class="fa fa-trash"></i>
                            </button>-->
                            <?php endif; ?>
                            <?php if ($row['cd_enviado_vector'] == 1 and !empty($row['gl_ruta_respuesta_vector'])): ?>
                                <a href="<?php echo base_url($row['gl_ruta_respuesta_vector']) ?>" target="_blank"
                                   class="btn btn-primary btn-sm btn-square"><i class="fa fa-file-pdf-o"></i></a>
                            <?php endif; ?>


                            <?php if ($row['cd_estado_vector'] == 0 and !$entomologo): ?>
                                <a href="<?php echo base_url('vectores/adjuntarImagenesDenuncia/id/' . $row['id_vector']) ?>"
                                   title="Adjuntar Imagenes" class="btn btn-sm btn-square btn-warning">
                                    <i class="fa fa-file-image-o"></i>
                                </a>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php if ($row['cd_enviado_vector'] == 1 and !empty($row['gl_ruta_respuesta_vector'])): ?>
                                <a href="<?php echo base_url($row['gl_ruta_respuesta_vector']) ?>" target="_blank"
                                   class="btn btn-primary btn-sm btn-square"><i class="fa fa-file-pdf-o"></i></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>