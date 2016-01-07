<div class="col-lg-12" data-row="10">
    <table id="grilla" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <th>Rol</th>
                <th>Acceso a emergencias</th>
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
                                            <a data="<?php echo $row["rol_ia_id"]; ?>" class="editar-rol" href="#">
                                                <i class="fa fa-edit"></i> Editar rol
                                            </a>
                                        </li>
                                        <!--<li>
                                            <a data="<?php echo $row["rol_ia_id"]; ?>" class="eliminar-rol" href="#">
                                                <i class="fa fa-remove"></i> Eliminar rol
                                            </a>
                                        </li>-->
                                        <li class="divider"></li>
                                        <li>
                                            <a data="<?php echo $row["rol_ia_id"]; ?>" class="editar-permiso" href="#">
                                                <i class="fa fa-edit"></i> Editar permisos
                                            </a>
                                        </li>
                                        <li>
                                            <a data="<?php echo $row["rol_ia_id"]; ?>" class="usuarios" href="#">
                                                <i class="fa fa-users"></i> Usuarios asociados
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php echo $row["rol_c_nombre"]; ?>
                    </td>
                    <td>
                        <?php echo estadoAccesoEmergencias($row["rol_ia_id"]); ?>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>