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
                    Identificación del caso <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                        <div class="col-md-6">
                            <div id="mapa" style="height: 400px"></div>
                            <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación del caso</div>
                            
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
                        <div class="col-md-6">
                            <div class="row">
                               
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="fecha" class="control-label">Fecha(*):</label>
                                        <input value="<?php echo $fecha; ?>" class="form-control datepicker-date" name="fecha" id="fecha">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    
                                </div>
                             
                                <div class="col-xs-2">
                              
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="recurso" class="control-label">Recurso (*):</label>
                                        <input value="<?php echo $recurso; ?>" class="form-control" name="recurso" id="recurso">
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
                                        <label for="fecha_de_nacimiento" class="control-label">Comuna (*):</label>
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
                                        <input value="<?php echo $laboratorio; ?>" class="form-control" name="laboratorio" id="laboratorio">
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