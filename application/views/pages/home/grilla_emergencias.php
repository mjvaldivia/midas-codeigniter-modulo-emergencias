<div class="col-lg-12" data-row="5">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <th>Código</th>
                <th>Nombre emergencia</th>
                <th>Tipo emergencia</th>
                <th>Comunas afectadas</th>
                <th>Fecha emergencia</th>
                <th>Lugar</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="10%" align="center">
                    
                    <div style="width: 90px">
                        <div class="row">
                            <div class="btn-group">
                               
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Acciones
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                </button>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a class="expediente" href="javascript:void(0);" onclick="xModal.open('<?php echo base_url('alarma/expediente/id/'.$row['ala_ia_id'])?>','Expediente Alarma/Emergencia','lg');">
                                            <i class="fa fa-files-o"></i> Expediente
                                        </a>
                                    </li>
                                    
                                  <?php if (puedeEditar("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-editar" href="#">
                                          <i class="fa fa-edit"></i> Editar
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if(puedeAbrirVisorEmergencia("emergencia")) { ?>
                                  <li>
                                      <a onclick="window.open(siteUrl + 'mapa/index/id/<?php echo $row["eme_ia_id"]; ?>', '_self');" href="#">
                                          <i class="fa fa-globe"></i> Abrir visor
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if (puedeFinalizarEmergencia()) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-cerrar" href="#">
                                          <i class="fa fa-check"></i> Finalizar emergencia
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if(puedeVerReporteEmergencia("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" data-rel="<?php echo $row["ala_ia_id"] ?>" class="emergencia-reporte" href="#">
                                          <i class="fa fa-file-text-o"></i> Reporte
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if (puedeEliminar("emergencia")) { ?>
                                  <li class="divider"></li>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" href="#" class="emergencia-eliminar">
                                          <i class="fa fa-trash"></i> Eliminar
                                      </a>
                                  </li>
                                  <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </td>
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
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>