<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Marea roja </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("marea_roja/index") ?>"> Marea roja</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                <li class="pull-right"><a href="<?php echo base_url("marea_roja/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
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
            
            
            <form id="form" autocomplete="off" class="form-vertical" action="<?php echo base_url("marea_roja/guardar") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Identificación Toma de Muestra <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                        <div class="col-md-6">
                            <div id="mapa" style="height: 400px"></div>
                            <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación del caso</div>
                            
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Latitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="latitud" id="latitud" value="<?php echo $latitud; ?>">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Longitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="longitud" id="longitud" value="<?php echo $longitud; ?>">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Calidad de georeferenciación(*):</label>
                                    <select id="calidad_de_georeferenciacion" name="calidad_de_georeferenciacion" class="form-control">
                                        <option value="">-- seleccione un valor --</option>
                                        <option <?php if($calidad_de_georeferenciacion == "GPS (Exacta)") echo "selected"; ?> value="GPS (Exacta)">GPS Exacta</option>
                                        <option <?php if($calidad_de_georeferenciacion == "Aproximación confiable") echo "selected"; ?> value="Aproximación confiable">Aproximación confiable</option>
                                        <option <?php if($calidad_de_georeferenciacion == "Requiere confirmación") echo "selected"; ?> value="Requiere confirmación">Requiere confirmación</option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                               
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="fecha" class="control-label">Fecha de toma de muestra(*):</label>
                                        <input value="<?php echo $fecha; ?>" class="form-control datepicker-date" name="fecha" id="fecha">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="fuente_de_la_informacion" class="control-label">Fuente de la información:</label>
                                        <select name="fuente_de_la_informacion" id="fuente_de_la_informacion" class="form-control">
                                            <option value="">-- Seleccione un valor --</option>
                                            <option <?php if($recurso == "SEREMI Monitoreo") echo "selected"; ?> value="SEREMI Monitoreo"> SEREMI Monitoreo </option>
                                            <option <?php if($recurso == "PSMB") echo "selected"; ?> value="PSMB"> PSMB </option>
                                            <option <?php if($recurso == "SEREMI Control de desembarco") echo "selected"; ?> value="SEREMI Control de desembarco">SEREMI Control de desembarco </option>
                                            <option <?php if($recurso == "IFOP") echo "selected"; ?> value="IFOP"> IFOP </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                             
                                <div class="col-xs-2">
                              
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="recurso" class="control-label">Recurso (*):</label>
                                        <select name="recurso" id="recurso" class="form-control">
                                            <option value="">-- Seleccione un valor --</option>
                                            <option <?php if($recurso == "ALMEJAS") echo "selected"; ?> value="ALMEJAS"> ALMEJAS </option>
                                            <option <?php if($recurso == "CHOLGAS") echo "selected"; ?> value="CHOLGAS"> CHOLGAS </option>
                                            <option <?php if($recurso == "CHORITO") echo "selected"; ?> value="CHORITO"> CHORITO </option>
                                            <option <?php if($recurso == "CHORITOS QUILMAHUE") echo "selected"; ?> value="CHORITOS QUILMAHUE"> CHORITOS QUILMAHUE </option>
                                            <option <?php if($recurso == "CHORO") echo "selected"; ?> value="CHORO"> CHORO </option>
                                            <option <?php if($recurso == "CHORO ZAPATO") echo "selected"; ?> value="CHORO ZAPATO"> CHORO ZAPATO </option>
                                            <option <?php if($recurso == "CULENGUE") echo "selected"; ?> value="CULENGUE"> CULENGUE </option>
                                            <option <?php if($recurso == "LOCO") echo "selected"; ?> value="LOCO"> LOCO </option>
                                            <option <?php if($recurso == "MACHAS") echo "selected"; ?> value="MACHAS"> MACHAS </option>
                                            <option <?php if($recurso == "NAVAJUELA") echo "selected"; ?> value="NAVAJUELA"> NAVAJUELA </option>
                                            <option <?php if($recurso == "OSTRA CH") echo "selected"; ?> value="OSTRA CH"> OSTRA CH </option>
                                            <option <?php if($recurso == "OSTRAS") echo "selected"; ?> value="OSTRAS"> OSTRAS </option>
                                            <option <?php if($recurso == "PIURE") echo "selected"; ?> value="PIURE"> PIURE </option>
                                            <option <?php if($recurso == "TUMBAO") echo "selected"; ?> value="TUMBAO"> TUMBAO </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="origen" class="control-label">Origen (*):</label>
                                        <input value="<?php echo $origen; ?>" class="form-control" name="origen" id="origen">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="row">
                               
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Región (*):</label>
                                        <?php echo formElementSelectRegion("region", array($region), array("class" => "form-control")); ?>
                                        
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                        
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_nacimiento" class="control-label">Comuna:</label>
                                        <?php echo formElementSelectComuna("comuna", $comuna, $region); ?>
                                        
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="profundidad" class="control-label">Profundidad:</label>
                                        <input value="<?php echo $profundidad; ?>" class="form-control" name="profundidad" id="profundidad">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="temperatura" class="control-label">Temperatura:</label>
                                        <input value="<?php echo $temperatura; ?>" class="form-control" name="temperatura" id="temperatura">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="vp" class="control-label">N° VP:</label>
                                        <input value="<?php echo $vp; ?>" class="form-control" name="vp" id="vp">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="resultado" class="control-label">Resultado (*):</label>
                                        <input value="<?php echo $resultado; ?>" class="form-control" name="resultado" id="resultado">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="laboratorio" class="control-label">Laboratorio (*):</label>
                                        <select name="laboratorio" id="laboratorio" class="form-control">
                                            <option value="">-- Seleccione un valor --</option>
                                            <option <?php if($laboratorio == "Puerto Montt") echo "selected" ?> value="Puerto Montt"> Puerto Montt </option>
                                            <option <?php if($laboratorio == "Quellón") echo "selected" ?> value="Quellón"> Quellón  </option>
                                            <option <?php if($laboratorio == "Castro") echo "selected" ?> value="Castro"> Castro </option>
                                        </select>
                                        
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="observaciones" class="control-label ">Observaciones:</label>
                                        <textarea name="observaciones" class="form-control" id="observaciones"><?php echo $observaciones; ?></textarea>
                                        <span class="help-block hidden"></span>
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
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("marea_roja/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
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
<?= loadJS("assets/js/modulo/marea_roja/form.js") ?>