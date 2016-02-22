<div class="col-lg-12" data-row="10">
    <table id="grilla" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Usuario Emergencias</th>
                <th>Email</th>
                <th>Region</th>
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
                                      <a data="<?php echo $row["usu_ia_id"]; ?>" class="editar" href="#">
                                          <i class="fa fa-edit"></i> Editar
                                      </a>
                                  </li>
                    
                                  <!--<li class="divider"></li>
                                  <li>
                                      <a disabled data="<?php echo $row["usu_ia_id"]; ?>" class="alarma-eliminar disabled" href="#">
                                          <i class="fa fa-trash"></i> Eliminar
                                      </a>
                                  </li>
                                  -->
                                </ul>
                               
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $row["usu_c_rut"]; ?>
                </td>
                <td>
                    <?php echo $row["usu_c_nombre"]; ?> <?php echo $row["usu_c_apellido_paterno"]; ?> <?php echo $row["usu_c_apellido_materno"]; ?> 
                </td>
                <td>
                    <?php echo $row["usu_c_login"]; ?>
                </td>
                <td> 
                    <?php echo $row["usu_c_email"]; ?>
                </td>
                <td>
                    <?php echo nombreRegionesUsuario($row["usu_ia_id"]); ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>