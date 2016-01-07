<div class="col-lg-12" data-row="5">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <?php if (puedeEditar("emergencia") && puedeEliminar("alarma")) { ?>
                <th></th>
                <?php } ?>
                <!--<th></th>-->
                <th>Nombre alarma</th>
                <th>Tipo alarma</th>
                <th>Comunas afectadas</th>
                <th>Fecha alarma</th>
                <th>Lugar</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <?php if (puedeActivarAlarma("alarma") || puedeEliminar("alarma")) { ?>
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
                                    
                                  <?php if (puedeActivarAlarma("alarma")) { ?>
                                  <li>
                                      <a data="<?php echo $row["ala_ia_id"]; ?>" class="emergencia-nueva" href="#">
                                          <i class="fa fa-bullhorn"></i> Generar emergencia
                                      </a>
                                  </li>
                                  <li class="divider"></li>
                                  <?php } ?>
                                  
                                  <?php if (puedeEliminar("alarma")) { ?>
                                  
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
                   
                </td>
                <?php } ?>
                
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
            <?php } ?>
        </tbody>
    </table>
</div>