<div class="container-fluid">
	<div class="row form-group" >
        <div id="div-pasos" style="display: none;" class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="active"><a href="#step-1">
                    <h4 class="list-group-item-heading">Paso 1</h4>
                    <p class="list-group-item-text">Datos generales</p>
                </a></li>
                <li class="disabled"><a href="#step-2">
                    <h4 class="list-group-item-heading">Paso 2</h4>
                    <p class="list-group-item-text">Datos tipo de emergencia</p>
                </a></li>
            </ul>
        </div>
	</div>
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12 well text-center">
                <form  id="<?= $form_name ?>" name="<?= $form_name ?>" enctype="application/x-www-form-urlencoded" action="" method="post">
                    <input type="hidden" name="eme_id" id="eme_id" value="<?php echo $eme_id; ?>"/>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row">
                            <div class="col-md-12">
                                    <div id="mapa" class="col-md-12 mapa-alarma" style="height: 400px !important;"></div>
                                    <div class="col-xs-12 alert alert-info help-block">
                                        <p><strong>Puede mover el pin si es necesario para una ubicación más exacta</strong></p></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <br>
                                            <!-- <label>Lon:</label> -->
                                            <input id="longitud" name="longitud" type="hidden" value="<?php echo $longitud_utm ?>"
                                                   class="form-control required mapa-coordenadas" placeholder="longitud (e)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <br>
                                            <!-- <label>Lat:</label> -->
                                            <input id="latitud" name="latitud" type="hidden" value="<?php echo $latitud_utm ?>"
                                                   class="form-control required mapa-coordenadas" placeholder="latitud (n)">
                                        </div>
                                    </div>

                            </div>
                            </div>
                        </div>
                        <div class="col-lg-8 text-left">
                            <div class="row">
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group clearfix ">
                                        <label for="fecha_emergencia" class="control-label">Ocurrencia del evento:</label>
                                        <div class="input-group col-sm-12" id="div-fecha">
                                            <input value="<?php echo $fecha_emergencia; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="fecha_emergencia" id="fecha_emergencia">
                                            <div class="input-group-addon" style="cursor: pointer">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="nombre-emergencia" class="control-label">Nombre del Evento (*):</label>
                                        <input value="<?php echo $nombre_emergencia; ?>" class="form-control" name="nombre_emergencia" id="nombre_emergencia">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <label for="fecha_emergencia" class="control-label">Nivel del Evento:</label>
                                        <div class="input-group col-sm-12" id="div-nivel">
                                            <select class="form-control" name="nivel_emergencia" id="nivel_emergencia">
                                                <?php if($nivel_emergencia):?>
                                                    <option value="1" <?php if($nivel_emergencia == 1):?> selected <?php endif;?>>Nivel I</option>
                                                    <option value="2" <?php if($nivel_emergencia == 2):?> selected <?php endif;?>>Nivel II</option>
                                                    <option value="3" <?php if($nivel_emergencia == 3):?> selected <?php endif;?>>Nivel III</option>
                                                    <option value="4" <?php if($nivel_emergencia == 4):?> selected <?php endif;?>>Nivel IV</option>
                                                <?php else:?>
                                                    <option value="1" >Nivel I</option>
                                                    <option value="2" >Nivel II</option>
                                                    <option value="3">Nivel III</option>
                                                    <option value="4" >Nivel IV</option>
                                                <?php endif;?>
                                            </select>
                                        </div>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <label for="tipo_emergencia" class="control-label">Tipo del Evento (*):</label>
                                        <?php echo formElementSelectEmergenciaTipo("tipo_emergencia", $id_tipo_emergencia, array("class" => "form-control")); ?>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <label for="tipo_emergencia" class="control-label">Estado del Evento (*):</label>
                                        <select name="estado_emergencia" id="estado_emergencia" class="form-control">

                                            <?php if($id_estado_emergencia):?>
                                                <option value="1" <?php if($id_estado_emergencia == 1):?> selected <?php endif;?>>En Alerta</option>
                                                <option value="2" <?php if($id_estado_emergencia == 2):?> selected <?php endif;?>>Emergencia Activa</option>
                                                <option value="3" <?php if($id_estado_emergencia == 3):?> selected <?php endif;?>>Emergencia Finalizada</option>
                                            <?php else:?>form-alarm
                                                <option value="" >Seleccione...</option>
                                                <option value="1" >En Alerta</option>
                                                <option value="2" >Emergencia Activa</option>
                                                <option value="3" >Emergencia Finalizada</option>
                                            <?php endif;?>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <label for="nombre-informante" class="control-label">Origen de la información (*):</label>
                                        <input value="<?php echo $nombre_informante; ?>" class="form-control" name="nombre_informante" id="nombre_informante">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <label for="nombre_lugar" class="control-label">Dirección/Ubicación del evento (*):</label>
                                        <input  class="form-control" name="nombre_lugar" id="nombre_lugar" value="<?php echo $nombre_lugar; ?>" />
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-9 text-left">

                                    <div class="form-group clearfix">
                                        <label for="observacion" class="control-label">Comuna(s) afectada(s) (*):</label>
                                        <?php echo formElementSelectComunaUsuario("comunas[]", $lista_comunas); ?>
                                        <span class="help-block hidden"></span>
                                    </div>
                 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    <div class="form-group clearfix">
                                        <label for="observacion" class="control-label">Descripción del Evento (*):</label>
                                        <textarea  class="form-control" rows="5" name="descripcion_emergencia" id="descripcion_emergencia"><?php echo $descripcion; ?></textarea>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 text-left">
                                    <div class="form-group clearfix">
                                        <label for="observacion" class="control-label">Observaciones iniciales:</label>
                                        <textarea  class="form-control" name="observacion" rows="5" id="observacion"><?php echo $observacion; ?></textarea>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-md-12" style="display: none" id="caja_correos_evento">
                                <div class="form-group">
                                    <label class="col-xs-12 control-label">Escriba los correos a los cuales desea hacer llegar este evento</label>
                                    <div class="col-xs-12 ">
                                        <select id="destinatario" class="form-control" multiple="multiple" data-placeholder="Seleccione" name="destinatario[]">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div id="<?php echo $form_name ?>_error" class="alert alert-danger hidden">
                                <strong> Existen problemas con los datos ingresados </strong> <br>
                                Revise y corrija los campos iluminados en rojo.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-12 well">
                <div id="form-tipo-emergencia">
                    
                </div>
            </div>
        </div>
    </div>
 
    
</div>


<?php echo loadCSS("assets/js/library/bootstrap-fileinput/css/fileinput.css") ?>
<?php echo loadJS("assets/js/library/bootstrap-fileinput/js/fileinput.js") ?>
<?php echo loadJS("assets/js/library/bootstrap-fileinput/js/fileinput_locale_es.js") ?>












