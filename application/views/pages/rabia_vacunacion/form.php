<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>  Vacunación Antirrábica <small> <i class="fa fa-arrow-right"></i> Certificado de Vacunación Antirrábica  </small> </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("rabia_vacunacion/index") ?>"> Vacunación Antirrábica</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario  </li>
                <li class="pull-right"><a href="<?php echo base_url("rabia_vacunacion/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
                        
            <form id="form" autocomplete="off" class="form-vertical" action="<?php echo base_url("rabia_vacunacion/guardar") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Formulario  <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                        <div class="col-md-6">
                            <div id="mapa" style="height: 400px"></div>
                            <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación</div>
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
                                <div class="col-xs-12">
                                    <legend> Propietario </legend>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="run" class="control-label">RUN(*):</label>
                                        <input value="<?php echo $run; ?>" class="form-control rut" name="run" id="run">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">

                                </div>
                            </div>
                            
                            <div class="row">
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
                                <div class="col-xs-2">
                              
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="form-group clearfix">
                                        <label for="direccion" class="control-label">Dirección (*):</label>
                                        <input value="<?php echo $direccion; ?>" class="form-control" name="direccion" id="direccion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Teléfono(s) de contacto:</label>
                                        <input value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <legend> Animal </legend>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="nombre_animal" class="control-label">Nombre animal(*):</label>
                                        <input value="<?php echo $nombre_animal; ?>" class="form-control" name="nombre_animal" id="nombre_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group clearfix">
                                        <label for="sexo_animal" class="control-label">Sexo:</label>
                                        <select name="sexo_animal" id="sexo_animal" class="form-control">
                                            <option value=""></option>
                                            <option value="M" <?php if($sexo_animal == "M") echo "selected" ?>> M </option>
                                            <option value="H" <?php if($sexo_animal == "H") echo "selected" ?>> H </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group clearfix">
                                        <label for="edad_animal" class="control-label">Edad:</label>
                                        <input value="<?php echo $edad_animal; ?>" class="form-control" name="edad_animal" id="nombre_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                 <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="especie_animal" class="control-label">Especie(*):</label>
                                        <input value="<?php echo $especie_animal; ?>" class="form-control" name="especie_animal" id="especie_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="raza_animal" class="control-label">Raza:</label>
                                        <input value="<?php echo $raza_animal; ?>" class="form-control" name="raza_animal" id="raza_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="tamano_animal" class="control-label">Tamaño:</label>
                                        <input value="<?php echo $tamano_animal; ?>" class="form-control" name="tamano_animal" id="tamano_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="color_animal" class="control-label">Color:</label>
                                        <input value="<?php echo $color_animal; ?>" class="form-control" name="color_animal" id="color_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="identificacion_animal" class="control-label">N° Identificación:</label>
                                        <input value="<?php echo $identificacion_animal; ?>" class="form-control" name="identificacion_animal" id="identificacion_animal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <legend> Vacunación </legend>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vacuna_tipo" class="control-label">Vacuna Aplicada(*):</label>
                                    <?php echo formElementSelectVacuna("vacuna_tipo", $vacuna_tipo, array("class" => "form-control")); ?>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vacuna_laboratorio" class="control-label">Laboratorio(*):</label>
                                    <div class="clearfix"></div>
                                    <div id="texto_vacuna_laboratorio" class="label blue"><?php echo $vacuna_laboratorio; ?></div>
                                    <input type="hidden" value="<?php echo $vacuna_laboratorio; ?>" class="form-control" name="vacuna_laboratorio" id="vacuna_laboratorio">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vacuna_numero_serie" class="control-label">Numero serie(*):</label>
                                    <div class="clearfix"></div>
                                    <div id="texto_vacuna_numero_serie" class="label blue"><?php echo $vacuna_numero_serie; ?></div>
                                    <input type="hidden" value="<?php echo $vacuna_numero_serie; ?>" class="form-control" name="vacuna_numero_serie" id="vacuna_numero_serie">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vacuna_fecha" class="control-label">Fecha vacunación(*):</label>
                                    <input value="<?php echo $vacuna_fecha; ?>" class="form-control datepicker-date" name="vacuna_fecha" id="vacuna_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vacuna_fecha_revacunacion" class="control-label">Fecha revacunación(*):</label>
                                    <input value="<?php echo $vacuna_fecha_revacunacion; ?>" class="form-control datepicker-date" name="vacuna_fecha_revacunacion" id="vacuna_fecha_revacunacion">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                               
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
<?= loadJS("assets/js/modulo/rabia/form.js") ?>