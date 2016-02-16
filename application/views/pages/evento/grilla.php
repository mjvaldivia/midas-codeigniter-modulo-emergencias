<div class="col-lg-12" data-row="10">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>

                <th>Nombre Evento</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Nivel Evento</th>
                <th>Comunas afectadas</th>
                <th>Fecha Evento</th>
                <th>Lugar</th>
                <th>Opciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td>
                    <?php echo $row["eme_c_nombre_emergencia"]; ?>
                </td>
                <td class="text-center">
                    <?php echo nombreAlarmaEstado($row["est_ia_id"]); ?> 
                </td>
                <td class="text-center">
                    <?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> 
                </td>
                <td class="text-center">
                    <?php echo nivelEmergencia($row['eme_nivel']) ?>
                </td>
                <td> 
                    <?php echo textMoreLess(comunasAlarmaConComa($row["eme_ia_id"])); ?>
                </td>
                <td class="text-center">
                    <?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?>
                </td>
                <td>
                    <?php echo textMoreLess($row["eme_c_lugar_emergencia"]); ?>
                </td>
                <td class="text-center">
                    <a class="expediente btn btn-sm btn-info" href="javascript:void(0);" onclick="xModal.open('<?php echo base_url('evento/expediente/id/'.$row['eme_ia_id'])?>','Bitácora',75);" title="Bitácora">
                        <i class="fa fa-files-o"></i>
                    </a>
                <?php if (puedeEditar("emergencia") and $row['est_ia_id'] == 1) { ?>
                        <a data="<?php echo $row["eme_ia_id"]; ?>" class="emergencia-nueva btn btn-sm btn-purple" href="#" title="Activar Emergencia" >
                            <i class="fa fa-bullhorn"></i>
                        </a>

                    <?php }?>

                    <?php if (puedeEditar("emergencia") and $row['est_ia_id'] > 1) { ?>
                        <a title="Reporte" class="btn btn-sm btn-primary emergencia-reporte" type="button" data-rel="<?php echo $row["eme_ia_id"] ?>" href="javascript:void(0)">
                            <i class="fa fa-file-text-o"></i>
                        </a>
                    <?php }?>

                    <?php if (puedeEditar("alarma") and $row['est_ia_id'] < 3) { ?>
                            <a data="<?php echo $row["eme_ia_id"]; ?>" class="editar btn btn-sm btn-success" title="Editar" href="#">
                                <i class="fa fa-edit"></i>
                            </a>
                    <?php } ?>

                    <?php if (puedeEliminar("alarma") and $row['est_ia_id'] < 2) { ?>
                            <a data="<?php echo $row["eme_ia_id"]; ?>" class="alarma-eliminar btn btn-sm btn-danger" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                    <?php } ?>
                    <?php if (puedeEditar("emergencia") and $row['est_ia_id'] == 2) { ?>
                        <a title="Finalizar" class="btn btn-sm btn-warning emergencia-finalizar" type="button" data-rel="<?php echo $row["eme_ia_id"] ?>" href="javascript:void(0)">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                    <?php }?>
                </td>
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>