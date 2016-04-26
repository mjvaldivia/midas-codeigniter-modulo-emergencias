<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de embarazos </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("embarazo/index") ?>"> Embarazadas</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                <li class="pull-right"><a href="<?php echo base_url("embarazo/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            
            <?php if($ingresado == "correcto") { ?>
            <div class="col-md-12">
                <div class="alert alert-success">
                    Se ha ingresado el caso correctamente
                </div>
            </div>
            <?php } ?>
            
            
            <form id="form-dengue" autocomplete="off" class="form-vertical" action="<?php echo base_url("embarazo/guardar") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Identificación del caso <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                        <div class="col-md-6">
                            <div id="mapa" style="height: 400px"></div>
                            <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación del caso</div>
                            <div class="hidden">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Latitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="latitud" id="latitud" value="<?php echo $latitud; ?>">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Longitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="longitud" id="longitud" value="<?php echo $longitud; ?>">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="nombre" class="control-label">Nombre(*):</label>
                                        <input value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="apellido" class="control-label">Apellidos(*):</label>
                                        <input value="<?php echo $apellido; ?>" class="form-control" name="apellido" id="apellido">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-xs-2">
                              
                                </div>
                            </div>
                            <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="run" class="control-label">RUN:</label>
                                        <input value="<?php echo $run; ?>" class="form-control rut" name="run" id="run">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="numero_pasaporte" class="control-label">N° Pasaporte:</label>
                                        <input value="<?php echo $numero_pasaporte; ?>" class="form-control" name="numero_pasaporte" id="numero_pasaporte">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Teléfono(s) de contacto:</label>
                                        <input value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_nacimiento" class="control-label">Fecha de nacimiento(*):</label>
                                        <input value="<?php echo $fecha_de_nacimiento; ?>" class="form-control" name="fecha_de_nacimiento" id="fecha_de_nacimiento">
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="edad" class="control-label">Edad:</label>
                                        <div class="clearfix"></div>
                                        <div id="texto_edad" class="label blue"><?php echo $edad; ?></div>
                                        <input type="hidden" value="<?php echo $edad; ?>" class="form-control" name="edad" id="edad">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="direccion" class="control-label">Dirección de residencia/trabajo o de estadía (*):</label>
                                        <input value="<?php echo $direccion; ?>" class="form-control" name="direccion" id="direccion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="fecha_fur" class="control-label">FUR (*):</label>
                                        <input value="<?php echo $fecha_fur; ?>" class="form-control" name="fecha_fur" id="fecha_fur">
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="fecha_fpp" class="control-label">FPP:</label>
                                        <div class="clearfix"></div>
                                        <div id="texto_fecha_fpp" class="label blue"><?php echo $fecha_fpp; ?></div>
                                        <input type="hidden" value="<?php echo $fecha_fpp; ?>" class="form-control" name="fecha_fpp" id="fecha_fpp">                                        
                                    </div>
                                </div>
                            </div>		
   	
                        </div>
                        </div>
                    </div>
                </div>
            </div>
           
                            
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="col-md-12">
                    <div id="form_error" class="alert alert-danger hidden">
                        <strong> Existen problemas con los datos ingresados </strong> <br>
                        Revise y corrija los campos iluminados en rojo.
                    </div>
                    </div>
                </div>
            </div>                
                            
            <div class="row top-spaced">
                <div class="col-xs-12 text-right">
                <div class="form-group">
                    <div class="col-sm-12">
                        <button id="guardar" class="btn btn-green" type="button"><i class="fa fa-floppy-o"></i> Guardar</button>
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("embarazo/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>

<?= loadJS("assets/js/library/jquery.typing-0.2.0/jquery.typing.min.js") ?>
<?= loadJS("assets/js/modulo/mapa/formulario.js") ?>
<?= loadJS("assets/js/modulo/embarazos/form.js") ?>