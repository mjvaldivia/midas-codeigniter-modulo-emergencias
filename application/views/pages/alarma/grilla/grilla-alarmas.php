<div class="col-lg-12" data-row="10">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <?php if (puedeEditar("emergencia") && puedeEliminar("alarma")) { ?>
                <th></th>
                <?php } ?>
                <!--<th></th>-->
                <th>Nombre Evento</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Nivel Evento</th>
                <th>Comunas afectadas</th>
                <th>Fecha Evento</th>
                <th>Lugar</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <?php if (puedeEditar("emergencia") && puedeEliminar("alarma")) { ?>
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
                                        <a class="expediente" href="javascript:void(0);" onclick="xModal.open('<?php echo base_url('alarma/expediente/id/'.$row['eme_ia_id'])?>','Bitácora',75);">
                                            <i class="fa fa-files-o"></i> Bitácora
                                        </a>
                                    </li>
                                  <?php if (puedeEditar("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"]; ?>" class="emergencia-nueva" href="#">
                                          <i class="fa fa-bullhorn"></i> Generar emergencia
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if (puedeEditar("alarma")) { ?>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"]; ?>" class="editar" href="#">
                                          <i class="fa fa-edit"></i> Editar
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if (puedeEliminar("alarma") and $row["est_ia_id"] != 1) { ?>
                                  <li class="divider"></li>
                                  <li>
                                      <a data="<?php echo $row["eme_ia_id"]; ?>" class="alarma-eliminar" href="#">
                                          <i class="fa fa-trash"></i> Eliminar
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                </ul>
                               
                            </div>
                        </div>
                    </div>
                   
                </td>
                <?php } ?>
                
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
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>