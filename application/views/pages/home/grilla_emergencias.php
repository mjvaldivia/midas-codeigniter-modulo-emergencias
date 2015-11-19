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
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="10%" align="center">
                    
                    <!--<button data-style='width:80%;' class="btn btn-xs btn-blue modal-sipresa" data-href="<?= site_url("visor/reporte/id/" .  $row["eme_ia_id"] . "/ala_ia_id/" . $row["ala_ia_id"]); ?>" data-title='Administracion del Reporte' data-success='exportarMapa(<?php echo $row["ala_ia_id"] ?>);' data-target='#modal_<?php echo $row["ala_ia_id"] ?>'>
                        <i class="fa fa-fa2x fa-file-text-o"></i>
                    </button>-->
                    <!--
                    <?php if (puedeEditar("emergencia")) { ?>
                    <button data="<?php echo $row["eme_ia_id"] ?>" class="btn btn-xs btn-blue emergencia-editar" data-toggle="tooltip" data-toogle-param="arriba" title="Editar la emergencia">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    
                    <button onclick="window.open(siteUrl + 'visor/index/id/<?php echo $row["eme_ia_id"]; ?>', '_blank');" class="btn btn-xs btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Abrir el visor">
                        <i class="fa fa-globe"></i>
                    </button>
                    
                    <?php if (puedeEditar("emergencia")) { ?>
                    <button data="<?php echo $row["eme_ia_id"] ?>" class="btn btn-xs btn-blue emergencia-cerrar" data-toggle="tooltip" data-toogle-param="arriba" title="Cerrar emergencia">
                        <i class="fa fa-check"></i>
                    </button>
                    <?php } ?>
                    -->
                    <div style="width: 90px">
                        <div class="row">
                            <div class="btn-group">
                               
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Acciones
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                </button>

                                <ul class="dropdown-menu" role="menu">
                                    
                                  <?php if (puedeEditar("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-editar" href="#">
                                          <i class="fa fa-edit"></i> Editar
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <li>
                                      <a onclick="window.open(siteUrl + 'visor/index/id/<?php echo $row["eme_ia_id"]; ?>', '_blank');" href="#">
                                          <i class="fa fa-globe"></i> Abrir visor
                                      </a>
                                  </li>
                                  <?php if (puedeEditar("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-cerrar" href="#">
                                          <i class="fa fa-check"></i> Finalizar emergencia
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
        </tbody>
    </table>
</div>