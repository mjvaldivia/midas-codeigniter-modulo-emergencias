<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de Trampas </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("trampas/index") ?>"> Trampas</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario</li>
                <li class="pull-right"><a href="<?php echo base_url("trampas/index") ?>"> <i class="fa fa-backward"></i>
                        Volver </a></li>
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


            <form id="form-trampa" autocomplete="off" class="form-vertical"
                  action="<?php echo base_url("trampas/guardar") ?>" method="post" role="form">
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                <div class="col-md-12">
                    <legend>
                        Identificación de la trampa
                        <div class="pull-right">
                            <small>(*) Campos obligatorios</small>
                        </div>
                    </legend>
                    <div class="portlet portlet-default">
                        <div class="portlet-body" style="overflow: visible">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="mapa" style="height: 400px"></div>
                                    <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación del
                                        caso
                                    </div>
                                    <div class="hidden">
                                        <div class="col-xs-6">
                                            <div class="form-group clearfix">
                                                <label for="nombre" class="control-label">Latitud(*):</label>
                                                <input type="text" class="form-control mapa-coordenadas" name="latitud"
                                                       id="latitud" value="<?php echo $latitud; ?>">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group clearfix">
                                                <label for="nombre" class="control-label">Longitud(*):</label>
                                                <input type="text" class="form-control mapa-coordenadas" name="longitud"
                                                       id="longitud" value="<?php echo $longitud; ?>">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8">
                                            <div class="form-group clearfix">
                                                <label for="direccion" class="control-label">Dirección de
                                                    residencia/trabajo o de estadía (*):</label>
                                                <input value="<?php echo $direccion; ?>" class="form-control"
                                                       name="direccion" id="direccion">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group clearfix">
                                                <label class="control-label">Fecha instalación (*)</label>
                                                <div class="input-group">
                                                    <input type="text" name="fecha" id="fecha"
                                                           class="form-control datepicker-date"
                                                           value="<?php echo $fecha ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group clearfix">
                                                <label class="control-label">Acciones (*)</label>
                                                <textarea class="form-control col-xs-12" rows="8" name="acciones"
                                                          id="acciones"><?php echo $acciones ?></textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row top-spaced">
                                <div class="col-xs-12 text-right">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button id="guardar" class="btn btn-green" type="button"><i
                                                    class="fa fa-floppy-o"></i>
                                                Guardar
                                            </button>
                                            <button class="btn btn-white" type="reset"
                                                    onClick="document.location.href='<?php echo base_url("trampas/index") ?>'">
                                                <i
                                                    class="fa fa-ban"></i> Cancelar
                                            </button>
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

                        </div>
                    </div>
                </div>


            </form>
        </div>
        <?php if (isset($id) and $id > 0): ?>
            <div class="portlet portlet-default">
                <div class="portlet-body" style="overflow: visible">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" role="form" id="form-inspeccion">
                                <legend>Nueva inspección</legend>
                                <input type="hidden" name="id_trampa" name="id_trampa" value="<?php echo $id?>" />
                                <div class="row">
                                    <div class="col-xs-12 col-md-5">
                                        <div class="form-group clearfix">
                                            <div class="col-xs-12 col-md-5">
                                                <label class="control-label">Fecha Inspección</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker"
                                                           name="fecha_inspeccion" id="fecha_inspeccion"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-xs-12 col-md-3">
                                                <label class="control-label">Hallazgo</label>
                                                <select class="form-control" name="hallazgo_inspeccion"
                                                        id="hallazgo_inspeccion">
                                                    <option value="">------</option>
                                                    <option value="1">Si</option>
                                                    <option value="2">No</option>
                                                </select>

                                            </div>
                                            <div class="col-xs-12 col-md-3">
                                                <label class="control-label">Cantidad</label>
                                                <input type="number" class="form-control" min="0"
                                                       name="cantidad_inspeccion" id="cantidad_inspeccion"/>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-xs-12">
                                                <label class="control-label">Observaciones</label>
                                                    <textarea class="form-control col-xs-12" rows="6"
                                                              name="observaciones_inspeccion"
                                                              id="observaciones_inspeccion"></textarea>

                                            </div>


                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-xs-12" style="margin-top:10px">
                                                <button type="button" class="btn btn-primary" id="agregar_inspeccion">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-7" id="contenedor-grilla-inspecciones">
                                        <?php echo $grilla_inspecciones?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>

<?= loadJS("assets/js/library/jquery.typing-0.2.0/jquery.typing.min.js") ?>
<?= loadJS("assets/js/modulo/mapa/formulario.js") ?>
<?= loadJS("assets/js/modulo/trampas/form.js") ?>