<div class="container-fluid">
	<div class="row form-group">
        <div id="div-pasos" class="col-xs-12">
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
                    <input type="hidden" name="ala_id" id="ala_id" value="<?php echo $ala_id; ?>" />
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

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group clearfix">
                                                <label for="nombre-informante" class="control-label">Nombre del informante (*):</label>
                                                <input value="<?php echo $nombre_informante; ?>" class="form-control" name="nombre_informante" id="nombre_informante">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group clearfix">
                                                <label for="telefono-informante" class="control-label">Teléfono del informante:</label>
                                                <input value="<?php echo $telefono_informante; ?>" class="form-control" name="telefono_informante" id="telefono_informante">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-left">

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group clearfix">
                                                <label for="nombre-emergencia" class="control-label">Nombre de la emergencia (*):</label>
                                                <input value="<?php echo $nombre_emergencia; ?>" class="form-control" name="nombre_emergencia" id="nombre_emergencia">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group clearfix">
                                                <label for="tipo_emergencia" class="control-label">Tipo de la emergencia (*):</label>
                                                <?php echo formElementSelectEmergenciaTipo("tipo_emergencia", $id_tipo_emergencia, array("class" => "form-control")); ?>
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7 text-left">
                                    <div class="form-group clearfix">
                                        <label for="nombre_lugar" class="control-label">Lugar o dirección de la emergencia (*):</label>
                                        <input  class="form-control" name="nombre_lugar" id="nombre_lugar" value="<?php echo $nombre_lugar; ?>" />
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                                <div class="col-md-5 text-left">
                                    <div class="form-group clearfix">
                                        <label for="observacion" class="control-label">Observación:</label>
                                        <textarea  class="form-control" name="observacion" id="observacion"><?php echo $observacion; ?></textarea>
                                        <span class="help-block hidden col-sm-8"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7 text-left">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group clearfix">
                                                    <label for="fecha_emergencia" class="control-label">Fecha/Hora de la emergencia:</label>
                                                    <div class="input-group col-sm-12" id="div-fecha">
                                                        <input value="<?php echo $fecha_emergencia; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="fecha_emergencia" id="fecha_emergencia">
                                                        <div class="input-group-addon" style="cursor: pointer">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <span class="help-block hidden"></span>
                                                </div>
                                            </div>
                                            
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
                            <div id="<?= $form_name ?>_error" class="alert alert-danger hidden">
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
                <?php if($eme_id > 0):?>
                    <?php if(isset($adjuntos) and count($adjuntos) > 0):?>
                    <div class="col-xs-12">
                        <div class="alert alert-info">
                            <p><strong>Adjuntos</strong></p>
                            <ul>
                                <?php foreach($adjuntos as $adjunto):?>
                                <li><a href="<?php echo $adjunto['path'];?>" target="_blank"><i class="fa fa-file-o"></i> <?php echo $adjunto['nombre']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php endif;?>
                <div class="col-xs-12">
                    <input type="file" name="adjunto-emergencia" id="adjunto-emergencia" multiple />
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="alert alert-warning text-center">
        <p>Esta Alarma será enviada a los siguientes correos: SEREMI, Jefe DAS, Jefe SP, CRE.</p>
        <span id="correos_alarma" style="display:block;"></span>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        var emergencia = $("#eme_id").val();
        if(emergencia > 0){
            $("#adjunto-emergencia").fileinput({
                language: "es",
                multiple: true,
                uploadAsync: true,
                initialCaption: "Seleccione los adjuntos a la emergencia",
                uploadUrl: siteUrl + "emergencia/subir_AdjuntoEmergenciaTmp/id/"+emergencia
            });
        }

    });

</script>











