<form id="form-usuario" name="form_cerrar" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    
    <div class="row">
        <div class="col-lg-7">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h5>
                        Datos personales
                        </h5>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="rut" class="control-label">Rut (*):</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $rut; ?>" class="form-control" placeholder="" name="rut" id="rut">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="sexo" class="control-label">Sexo (*):</label>
                                <div class="input-group col-sm-6">
                                    <?php echo formElementSelectSexo("sexo", $sexo, array("class" => "form-control")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="region" class="control-label">Región (*):</label>
                                <div class="input-group col-sm-12">
                                <?php echo formElementSelectRegion("region", $region, array("class" => "form-control")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="nombre" class="control-label">Nombre (*):</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $nombre; ?>" class="form-control" placeholder="" name="nombre" id="nombre">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="apellido_paterno" class="control-label">Apellido paterno (*):</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $apellido_paterno; ?>" class="form-control" placeholder="" name="apellido_paterno" id="apellido_paterno">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="apellido_materno" class="control-label">Apellido materno (*):</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $apellido_materno; ?>" class="form-control" placeholder="" name="apellido_materno" id="apellido_materno">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h5>
                        Datos de contacto
                        </h5>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="telefono_fijo" class="control-label">Telefono fijo (*):</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $telefono_fijo; ?>" class="form-control" placeholder="" name="telefono_fijo" id="telefono_fijo">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>

                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="telefono_celular" class="control-label">Telefono celular:</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $telefono_celular; ?>" class="form-control" placeholder="" name="telefono_celular" id="telefono_celular">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>

                        <div class="col-md-4 text-left">
                            <div class="form-group clearfix">
                                <label for="email" class="control-label">Correo electrónico:</label>
                                <div class="input-group col-sm-12">
                                    <input value="<?php echo $email; ?>" class="form-control" placeholder="" name="email" id="email">
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            

            
        </div>
        <div class="col-lg-5">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h5>
                        Configuración
                        </h5>
                    </div>
                </div>
                <div class="portlet-body">
            
            
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label for="region" class="control-label">Cargo (*):</label>
                                <div class="input-group col-sm-12">
                                    <?php echo formElementSelectCargo("cargo", $cargo, array("class" => "form-control")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label for="sexo" class="control-label">Activo:</label>
                                <div class="input-group col-sm-6">
                                    
                                    <?php echo formElementSelectActivo("activo", $activo, array("class" => "form-control")) ?>
                      
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="form-group clearfix">
                                <label for="email" class="control-label">Oficinas:</label>
                                <div class="input-group col-sm-12">
                                    <?php echo formElementSelectOficinas("oficinas[]", $lista_oficinas, $region, array("class"    => "form-control select2-tags", 
                                                                                                                       "multiple" => "multiple")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="form-group clearfix">
                                <label for="email" class="control-label">Roles:</label>
                                <div class="input-group col-sm-12">
                                    <?php echo formElementSelectRoles("roles[]", $lista_roles, array("class"    => "form-control select2-tags", 
                                                                                                     "multiple" => "multiple")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="form-group clearfix">
                                <label for="email" class="control-label">Ambito:</label>
                                <div class="input-group col-sm-12">
                                    <?php echo formElementSelectAmbito("ambitos[]", $lista_ambitos, array("class"    => "form-control select2-tags", 
                                                                                                          "multiple" => "multiple")) ?>
                                </div>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    <div class="row">
        <div class="col-md-12">
            <div id="form-usuario-error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
</form>

