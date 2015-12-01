<form  id="<?= $form_name ?>" name="<?= $form_name ?>" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
            <div class="col-md-12">
                    <input type="hidden" id="geozone" name="geozone" value="<?= $geozone ?>" /> 
                    <div id="mapa" class="col-md-12 mapa-alarma" style="height: 400px !important;"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br>
                            <label>Lon:</label>
                            <input id="longitud" name="longitud" type="number" value="<?= $longitud_utm ?>"
                                   class="form-control required mapa-coordenadas" placeholder="longitud (e)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <br>
                            <label>Lat:</label>
                            <input id="latitud" name="latitud" type="number" value="<?= $latitud_utm ?>"
                                   class="form-control required mapa-coordenadas" placeholder="latitud (n)">
                        </div>
                    </div>

            </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">

                        <label for="nombre-informante" class="control-label col-sm-4">Nombre del informante (*):</label>
                        <div class="input-group col-sm-8">
                            <input value="<?php echo $nombre_informante; ?>" class="form-control" name="nombre_informante" id="nombre_informante">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="telefono-informante" class="control-label col-sm-4">Teléfono del informante:</label>
                        <div class="input-group col-sm-8">
                            <input value="<?php echo $telefono_informante; ?>" class="form-control" name="telefono_informante" id="telefono_informante">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="nombre-emergencia" class="control-label col-sm-4">Nombre de la emergencia (*):</label>
                        <div class="input-group col-sm-8">
                            <input value="<?php echo $nombre_emergencia; ?>" class="form-control" name="nombre_emergencia" id="nombre_emergencia">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="tipo_emergencia" class="control-label col-sm-4">Tipo de la emergencia (*):</label>
                        <div class="input-group col-sm-8">
                            <?php echo formElementSelectEmergenciaTipo("tipo_emergencia", $id_tipo_emergencia, array("class" => "form-control")); ?>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="nombre_lugar" class="control-label col-sm-4">Lugar o dirección de la emergencia (*):</label>
                        <div class="input-group col-sm-8">
                            <textarea  class="form-control" name="nombre_lugar" id="nombre_lugar"><?php echo $nombre_lugar; ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="observacion" class="control-label col-sm-4">Observación:</label>
                        <div class="input-group col-sm-8">
                            <textarea  class="form-control" name="observacion" id="observacion"><?php echo $observacion; ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="fecha_emergencia" class="control-label col-sm-4">Fecha/Hora de la emergencia:</label>
                        <div class="input-group col-sm-4" id="div-fecha" type="datetime">
                            <input value="<?php echo $fecha_emergencia; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="fecha_emergencia" id="fecha_emergencia">
                            <div class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="fecha_recepcion" class="control-label col-sm-4">Fecha/Hora de recepción:</label>
                        <div class="input-group col-sm-4" id="div-fecha" type="datetime">
                            <input value="<?php echo $fecha_recepcion; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="fecha_recepcion" id="fecha_recepcion">
                            <div class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="form-group clearfix">
                        <label for="nombre_lugar" class="control-label col-sm-4">Comuna(s) afectada(s) (*):</label>
                        <div class="input-group col-sm-8">
                            <?php echo formElementSelectComunaUsuario("comunas[]", $lista_comunas); ?>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-4"></div>
                        <span class="help-block hidden col-sm-8"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="form-nueva-error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
</form>

