<div class="col-lg-12" data-row="5">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <!--<th></th>-->
                <th>Nombre alarma</th>
                <th>Tipo alarma</th>
                <th>Comunas afectadas</th>
                <th>Fecha alarma</th>
                <th>Lugar</th>
                
            </tr>
        </thead>
        <tbody>
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
                                    
                                  <?php if (puedeEditar("emergencia")) { ?>
                                  <li>
                                      <a data="<?php echo $row["ala_ia_id"]; ?>" class="emergencia-nueva" href="#">
                                          <i class="fa fa-bullhorn"></i> Generar emergencia
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                  <?php if (puedeEliminar("alarma")) { ?>
                                  <li class="divider"></li>
                                  <li>
                                      <a data="<?php echo $row["ala_ia_id"]; ?>" class="alarma-eliminar" href="#">
                                          <i class="fa fa-trash"></i> Eliminar
                                      </a>
                                  </li>
                                  <?php } ?>
                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!--<button onclick="javascript:formEditarAlarma(<?php echo $row["ala_ia_id"]; ?>)" class="btn btn-xs btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Editar la alarma">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php if (puedeEditar("emergencia")) { ?>
                    <button data="<?php echo $row["ala_ia_id"]; ?>" class="btn btn-xs btn-blue emergencia-nueva" data-toggle="tooltip" data-toogle-param="arriba" title="Generar emergencia">
                        <i class="fa fa-bullhorn"></i>
                    </button>
                    <?php } ?>-->
                </td>
               <!-- <td width="5%" class="text-center">
                    <?php echo htmlIconoEmergenciaTipo($row["tip_ia_id"]); ?>
                </td>-->
                <td>
                    <?php echo $row["ala_c_nombre_emergencia"]; ?>
                </td>
                <td>
                    <?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> 
                </td>
                <td> 
                    <?php echo textMoreLess(comunasAlarmaConComa($row["ala_ia_id"])); ?>
                </td>
                <td>
                    <?php echo ISODateTospanish($row["ala_d_fecha_emergencia"]); ?>
                </td>
                <td>
                    <?php echo textMoreLess($row["ala_c_lugar_emergencia"]); ?>
                </td>
                
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>