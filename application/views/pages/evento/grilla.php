<div class="col-lg-12" data-row="10">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th width="20%">Nombre Evento</th>
                <th width="10%">Estado</th>
                <th width="10%">Tipo</th>
                <th width="10%">Nivel Evento</th>
                <th width="20%">Comunas afectadas</th>
                <th width="10%">Fecha Evento</th>
                <th width="10%">Lugar</th>
                <th width="10%">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="20%">
                    <?php echo $row["eme_c_nombre_emergencia"]; ?>
                </td>
                <td width="10%" class="text-center">
                    <?php echo badgeNombreAlarmaEstado($row["est_ia_id"]); ?> 
                </td>
                <td width="10%" class="text-center">
                    <?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> 
                </td>
                <td width="10%" class="text-center">
                    <?php echo nivelEmergencia($row['eme_nivel']) ?>
                </td>
                <td width="20%"> 
                    <?php echo textMoreLess(comunasAlarmaConComa($row["eme_ia_id"])); ?>
                </td>
                <td width="10%" class="text-center">
                    <?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?>
                </td>
                <td width="10%">
                    <?php echo textMoreLess($row["eme_c_lugar_emergencia"]); ?>
                </td>
                <td width="10%" class="text-center">
                    <div style="width: 200px">
                        
                    <?php if(puedeVerReporteEmergencia("emergencia")) { ?>
                    <a class="expediente btn btn-sm btn-info" href="javascript:void(0);" onclick="xModal.open('<?php echo base_url('evento/expediente/id/'.$row['eme_ia_id'])?>','Bitácora',75);" title="Bitácora">
                        <i class="fa fa-files-o"></i>
                    </a>
                    <?php }?>    
                        
                    <?php if(puedeAbrirVisorEmergencia("emergencia")) { ?>

                       <button title="Abrir visor" class="btn btn-sm btn-default" type="button"  onclick="window.open(siteUrl + 'mapa/index/id/<?php echo $row["eme_ia_id"]; ?>', '_self');" href="#">
                           <i class="fa fa-globe"></i> 
                       </button>

                    <?php } ?>
                    

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

                    <?php if (puedeEditar("emergencia") and $row['est_ia_id'] == 1) { ?>
                        <a data="<?php echo $row["eme_ia_id"]; ?>" class="emergencia-nueva btn btn-sm btn-purple" href="#" title="Activar Emergencia" >
                            <i class="fa fa-bullhorn"></i>
                        </a>
                    <?php }?>
                        
                    <?php if (puedeEditar("emergencia") and $row['est_ia_id'] == 2) { ?>
                        <a title="Finalizar" class="btn btn-sm btn-warning emergencia-finalizar" type="button" data-rel="<?php echo $row["eme_ia_id"] ?>" href="javascript:void(0)">
                            <i class="fa fa-thumb-tack"></i>
                        </a>
                    <?php }?>
                        
                    <?php if (puedeEliminar("alarma") and $row['est_ia_id'] < 2) { ?>
                            <a data="<?php echo $row["eme_ia_id"]; ?>" class="alarma-eliminar btn btn-sm btn-danger" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                    <?php } ?>
                    </div>
                </td>
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>