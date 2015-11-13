<form  id="form_nueva_emergencia" name="form_nueva_emergencia" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    <div class="row">
        <div class="col-md-12 text-left">
            <div class="form-group clearfix">
                
                <label for="nueva-nombre-informante" class="control-label col-sm-4">Nombre del informante (*):</label>
                <div class="input-group col-sm-8">
                    <input value="<?php echo $nombre_informante; ?>" class="form-control" name="nueva_nombre_informante" id="nueva_nombre_informante">
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
                <label for="nueva-telefono-informante" class="control-label col-sm-4">Teléfono del informante:</label>
                <div class="input-group col-sm-8">
                    <input value="<?php echo $telefono_informante; ?>" class="form-control" name="nueva_telefono_informante" id="nueva_telefono_informante">
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
                <label for="nueva-nombre-emergencia" class="control-label col-sm-4">Nombre de la emergencia (*):</label>
                <div class="input-group col-sm-8">
                    <input value="<?php echo $nombre_emergencia; ?>" class="form-control" name="nueva_nombre_emergencia" id="nueva_nombre_emergencia">
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
                <label for="nueva_tipo_emergencia" class="control-label col-sm-4">Tipo de la emergencia (*):</label>
                <div class="input-group col-sm-8">
                    <?php echo formElementSelectEmergenciaTipo("nueva_tipo_emergencia", $id_tipo_emergencia, array("class" => "form-control")); ?>
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
                <label for="nueva_nombre_lugar" class="control-label col-sm-4">Lugar o dirección de la emergencia (*):</label>
                <div class="input-group col-sm-8">
                    <textarea  class="form-control" name="nueva_nombre_lugar" id="nueva_nombre_lugar"><?php echo $nombre_lugar; ?></textarea>
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
                <label for="nueva_observacion" class="control-label col-sm-4">Observación:</label>
                <div class="input-group col-sm-8">
                    <textarea  class="form-control" name="nueva_observacion" id="nueva_observacion"><?php echo $observacion; ?></textarea>
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
                <label for="nueva_fecha_emergencia" class="control-label col-sm-4">Fecha/Hora de la emergencia:</label>
                <div class="input-group col-sm-4" id="div-fecha" type="datetime">
                    <input value="<?php echo $fecha_emergencia; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="nueva_fecha_emergencia" id="nueva_fecha_emergencia">
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
                <label for="nueva_fecha_recepcion" class="control-label col-sm-4">Fecha/Hora de recepción:</label>
                <div class="input-group col-sm-4" id="div-fecha" type="datetime">
                    <input value="<?php echo $fecha_recepcion; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="nueva_fecha_recepcion" id="nueva_fecha_recepcion">
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
                <label for="nueva_nombre_lugar" class="control-label col-sm-4">Comuna(s) afectada(s) (*):</label>
                <div class="input-group col-sm-8">
                    <?php echo formElementSelectComunaUsuario("nueva_comunas[]", $lista_comunas); ?>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="col-sm-4"></div>
                <span class="help-block hidden col-sm-8"></span>
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

