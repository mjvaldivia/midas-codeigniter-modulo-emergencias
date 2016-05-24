<div class="col-lg-12" data-row="5">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre emergencia</th>
                <th>Tipo emergencia</th>
                <th>Comunas afectadas</th>
                <th>Fecha emergencia</th>
                <th>Lugar</th>
                <th>Opciones</th>				
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>

                <td width="5%" class="text-center">
                    <?php // echo htmlIconoEmergenciaTipo($row["tip_ia_id"]); ?>
                </td>
                <td><?php echo textMoreLess($row["eme_c_nombre_emergencia"]); ?></td>
                <td><?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> </td>
                <td>
                    <?php echo textMoreLess(comunasEmergenciaConComa($row["eme_ia_id"])); ?>
                </td>
                <td><?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?></td>
                <td><?php echo textMoreLess($row["eme_c_lugar_emergencia"]); ?></td>
                <td width="10%" align="center">
                    
                    <div style="width: 220px">
                        <div class="row">
						
                            <?php if(permisoEvento("bitacora")) { ?>
                            <button title="Bitácora" class="btn btn-sm btn-primary" type="button" onclick="xModal.open('<?php echo base_url('evento/expediente/id/'.$row['eme_ia_id'])?>','Bitácora',75);">
                                    <i class="fa fa-files-o"></i>
                            </button>
                            <?php } ?>
                                    
                            <?php if (permisoEvento("editar")) { ?>
                                <button title="Editar" class="btn btn-sm btn-success emergencia-editar" type="button"  data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-editar" href="#">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php } ?>

                            <?php if(permisoEvento("visor")) { ?>
                                <button title="Abrir visor" class="btn btn-sm btn-default" type="button"  onclick="window.open(baseUrl + 'mapa/index/id/<?php echo $row["eme_ia_id"]; ?>', '_self');" href="#">
                                    <i class="fa fa-globe"></i> 
                                </button>
                            <?php } ?>

                            <?php if (permisoEvento("finalizar")) { ?>

                                <button title="Finalizar emergencia" class="btn btn-sm btn-warning emergencia-cerrar" type="button" data="<?php echo $row["eme_ia_id"] ?>" href="#">
                                    <i class="fa fa-thumb-tack"></i> 
                                </button>

                            <?php } ?>

                            <?php if(permisoEvento("reporte")) { ?>

                                <button title="Reporte" class="btn btn-sm btn-info emergencia-reporte" type="button"  data="<?php echo $row["eme_ia_id"] ?>" data-rel="<?php echo $row["ala_ia_id"] ?>" href="#">
                                    <i class="fa fa-file-text-o"></i>
                                </button>

                            <?php } ?>
                        </div>
                    </div>
                </td>                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>