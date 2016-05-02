<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de intoxicaciones </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("intoxicacion/index") ?>"> Intoxicaciones</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                <li class="pull-right"><a href="<?php echo base_url("intoxicacion/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">

            <?php if ($ingresado == "correcto") { ?>
                <div class="col-md-12">
                    <div class="alert alert-success">
                        Se ha ingresado el caso correctamente
                    </div>
                </div>
            <?php } ?>


            <form id="form-intoxicacion" autocomplete="off" class="form-vertical" action="<?php echo base_url("intoxicacion/guardar") ?>" method="post" role="form">
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
                                        <div>
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
                                    <div >
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
                                        <div >
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


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 top-spaced">
                    <legend> Información clínica </legend>
                    <div class="portlet portlet-default">
                        <div class="portlet-body" style="overflow: visible">
                            <div class="row">

                                <div class="col-xs-1">
                                    <div class="form-group clearfix">
                                        <label for="sexo" class="control-label">Enfermo:</label>
                                        <select name="enfermo" id="enfermo" class="form-control">
                                            <option value=""></option>
                                            <option value="si" selected=""> SI </option>
                                            <option value="no"> NO </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>


                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_consulta" class="control-label">Fecha consulta(*):</label>
                                        <input value="<?php echo $fecha_de_consulta; ?>" class="form-control datepicker-date" name="fecha_de_consulta" id="fecha_de_consulta">
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_consulta" class="control-label">Fecha comida implicada:</label>
                                        <input value="<?php echo $fecha_comida; ?>" class="form-control datepicker-date" name="fecha_comida" id="fecha_comida">
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_consulta" class="control-label">Fecha primeros síntomas:</label>
                                        <input value="<?php echo $fecha_sintoma; ?>" class="form-control datepicker-date" name="fecha_sintoma" id="fecha_sintoma">
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-xs-10">
                                    <div class="form-group clearfix">
                                        <table class="table table-bordered table-green class-lg-12">
                                            <thead>
                                                <tr>
                                                    <th>Que Comió?</th>
                                                    <th>Cantidad</th>
                                                    <th>Dónde?</th>
                                                </tr>
                                            </thead>

                                            <tr>
                                                <td ><input class="form-control" id="comida_1_1" name="comida_1_1" /></td>
                                                <td ><input class="form-control" id="comida_1_2" name="comida_1_2" /></td>
                                                <td ><input class="form-control" id="comida_1_3" name="comida_1_3" /></td>
                                            </tr>
                                            <tr>
                                                <td ><input class="form-control" id="comida_2_1" name="comida_2_1" /></td>
                                                <td ><input class="form-control" id="comida_2_2" name="comida_2_2" /></td>
                                                <td ><input class="form-control" id="comida_2_3" name="comida_2_3" /></td>
                                            </tr>
                                            <tr>
                                                <td ><input class="form-control" id="comida_3_1" name="comida_3_1" /></td>
                                                <td ><input class="form-control" id="comida_3_2" name="comida_3_2" /></td>
                                                <td ><input class="form-control" id="comida_3_3" name="comida_3_3" /></td>
                                            </tr>
                                            <tr>
                                                <td ><input class="form-control" id="comida_4_1" name="comida_4_1" /></td>
                                                <td ><input class="form-control" id="comida_4_2" name="comida_4_2" /></td>
                                                <td ><input class="form-control" id="comida_4_3" name="comida_4_3" /></td>
                                            </tr>
                                            <tr>
                                                <td ><input class="form-control" id="comida_5_1" name="comida_5_1" /></td>
                                                <td ><input class="form-control" id="comida_5_2" name="comida_5_2" /></td>
                                                <td ><input class="form-control"id="comida_5_3" name="comida_5_3" /></td>
                                            </tr>

                                        </table>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group clearfix">
                                        <label for="personas_mesa" class="control-label">Cuántas personas comieron en su mesa</label>
                                        <input value="<?php echo $personas_mesa; ?>" class="form-control" name="personas_mesa" id="personas_mesa">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group clearfix">
                                        <label for="origen_mariscos" class="control-label">Origen de los mariscos</label>
                                        <input value="<?php echo $origen_mariscos; ?>" class="form-control" name="origen_mariscos" id="origen_mariscos">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <legend> <small>Síntomas</small> </legend>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">

                                        <input id="nauseas" name="nauseas" type="checkbox" >
                                        <label for="nauseas" class="control-label">Náuseas</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="vomito" name="vomito" type="checkbox" >
                                        <label for="vomito" class="control-label">Vómito</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="diarrea" name="diarrea" type="checkbox" >
                                        <label for="diarrea" class="control-label">Diarrea</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="liquida" name="liquida" type="checkbox" >
                                        <label for="liquida" class="control-label">Líquida</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="mucosa" name="mucosa" type="checkbox" >
                                        <label for="mucosa" class="control-label">Mucosa</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="con_sangre" name="con_sangre" type="checkbox" >
                                        <label for="con_sangre" class="control-label">Con Sangre</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="abdominal" name="abdominal" type="checkbox" >
                                        <label for="abdominal" class="control-label">Dolor Abdominal</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="cabeza" name="cabeza" type="checkbox" >
                                        <label for="cabeza" class="control-label">Dolor Cabeza</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="superiores" name="superiores" type="checkbox" >
                                        <label for="superiores" class="control-label">Dolor en Extremidades Superiores</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="inferiores" name="inferiores" type="checkbox" >
                                        <label for="inferiores" class="control-label">Dolor en Extremidades Inferiores</label>

                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="respiratoria" name="respiratoria" type="checkbox" >
                                        <label for="respiratoria" class="control-label">Dificultad respiratoria</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="tragar" name="tragar" type="checkbox" >
                                        <label for="tragar" class="control-label">Dificultad tragar</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="hablar" name="hablar" type="checkbox" >
                                        <label for="hablar" class="control-label">Dificultad Hablar</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="adorm_superiores" name="adorm_superiores" type="checkbox" >
                                        <label for="adorm_superiores" class="control-label">Adormecimiento extr. superiores</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="adorm_inferiores" name="adorm_inferiores" type="checkbox" >
                                        <label for="adorm_superiores" class="control-label">Adormecimiento extr. inferiores</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group clearfix">
                                        <input id="adorm_boca" name="adorm_boca" type="checkbox" >
                                        <label for="adorm_boca" class="control-label">Adormecimiento boca y/o lengua</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group clearfix">
                                        <label for="otros_sintomas" class="control-label">Otros</label>
                                        <textarea class="form-control" id="otros_sintomas" rows="4" name="otros_sintomas"  ></textarea>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group clearfix">
                                        <input id="derivar" name="derivar" type="checkbox" >
                                        <label for="derivar" class="control-label">Derivación</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="lugar_derivado" class="control-label">Dónde se derivó?</label>
                                        <input value="<?php echo $lugar_derivado; ?>" class="form-control" name="lugar_derivado" id="lugar_derivado">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group clearfix">
                                        <input id="muestras" name="muestras" type="checkbox" >
                                        <label for="muestras" class="control-label">Toma de muestras clínicas al paciente</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="tipo_muestra" class="control-label">Tipo</label>
                                        <input value="<?php echo $tipo_muestra; ?>" class="form-control" name="tipo_muestra" id="tipo_muestra">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group clearfix">
                                        <input id="muestras_mariscos" name="muestras_mariscos" type="checkbox" >
                                        <label for="muestras_mariscos" class="control-label">Toma de muestras de mariscos</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="tipo_muestra_marisco" class="control-label">Tipo</label>
                                        <input value="<?php echo $tipo_muestra_marisco; ?>" class="form-control" name="tipo_muestra_marisco" id="tipo_muestra_marisco">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group clearfix">
                                        <input id="fecha_notificación" name="fecha_notificación" type="checkbox" >
                                        <label for="fecha_notificación" class="control-label datepicker-date">Fecha de notificación del caso</label>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="quien_notificado" class="control-label">a quién?</label>
                                        <input value="<?php echo $quien_notificado; ?>" class="form-control" name="quien_notificado" id="quien_notificado">
                                        <span class="help-block hidden"></span>
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
                                    <button class="btn btn-white" type="reset" onClick="document.location.href = '<?php echo base_url("intoxicacion/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
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
<?= loadJS("assets/js/modulo/intoxicacion/form.js") ?>