<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de Vigilancia de Vectores :: Inspecciones </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Vectores</li>
                <li class="active"><i class="fa fa-bell"></i> Inspecciones</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div id="pResultados" class="portlet portlet-default">
            <div class="portlet-body">

                <form class="form-horizontal" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                    <div class="row">
                        <div class="col-xs-12">
                            <legend>Identificación de la inspección
                                <div class="pull-right">
                                    <small>(*) Campos obligatorios</small>
                                </div>
                            </legend>


                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <input type="hidden" class="mapa-coordenadas" id="latitud" name="latitud"
                                   value="<?php echo $latitud ?>" <?php if ($enviado): ?> disabled <?php endif; ?> />
                            <input type="hidden" class="mapa-coordenadas" id="longitud" name="longitud"
                                   value="<?php echo $longitud ?>"/>

                            <div id="mapa" style="height: 500px;" class="col-xs-12"></div>
                            <p></p>
                            <div class="alert alert-info top-spaced" style="margin-top:20px">Puede mover el marcador
                                para ajustar la ubicación
                                del caso
                                <?php if ($id > 0 and !$presidencia): ?>
                                    <button type="button" class="btn btn-sm btn-info pull-right btn-square"
                                            onclick="Hallazgos.cambiarCoordenadas(<?php echo $id ?>);">Cambiar
                                        coordenadas
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Nombres(*)</label>
                                    <input type="text" name="nombres" id="nombres" class="form-control"
                                           value="<?php echo $nombres ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Apellidos(*)</label>
                                    <input type="text" name="apellidos" id="apellidos" class="form-control"
                                           value="<?php echo $apellidos ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">RUN o Pasaporte(*)</label>
                                    <input type="text" name="cedula" id="cedula" class="form-control"
                                           value="<?php /*echo $cedula */ ?>"/>
                                </div>
                                <?php /*if ($id > 0): */ ?>
                                    <div class="col-xs-12 col-md-6">
                                        <label class="control-label">Número Denuncia</label>
                                        <input type="text" name="apellidos" id="apellidos" class="form-control"
                                               value="<?php /*echo $id */ ?>" disabled/>
                                    </div>
                                <?php /*endif; */ ?>
                            </div>-->
                            <div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Telefóno(s) de contacto</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                           value="<?php echo $telefono ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Correo electrónico(*)</label>
                                    <input type="text" name="correo" id="correo" class="form-control"
                                           value="<?php echo $correo ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="control-label">Dirección/Lugar de Hallazgo del mosquito(*)</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                           value="<?php echo $direccion ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                                <div class="col-xs-12">
                                    <label class="control-label">Referencias de la dirección</label>
                                    <input type="text" name="referencias" id="referencias" class="form-control"
                                           value="<?php echo $referencias ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Fecha de hallazgo(*)</label>
                                    <input type="text" name="fecha_hallazgo" id="fecha_hallazgo"
                                           class="form-control datepicker-date"
                                           value="<?php echo $fecha_hallazgo ?>" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>/>
                                </div>
                                <!--<div class="col-xs-12 col-md-6">
                                    <label class="control-label">Fecha de entrega(*)</label>
                                    <input type="text" name="fecha_entrega" id="fecha_entrega"
                                           class="form-control datepicker-date"
                                           value="<?php /*if(empty($fecha_entrega)) echo date('d/m/Y'); else echo $fecha_entrega; */ ?>"/>
                                </div>-->

                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="">Comentarios de la inspección</label>
                                    <textarea class="form-control" rows="5" id="comentarios_ciudadano"
                                              name="comentarios_ciudadano" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>><?php echo $comentarios_ciudadano ?></textarea>
                                </div>
                            </div>

                            <?php if ($id > 0 and $estado > 0): ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label class="control-label text-bold">Resultado</label>
                                    </div>
                                    <div class="col-xs-12 ">
                                        <label class="control-label col-xs-12 col-md-2">Aedes aegypti</label>
                                        <div class="col-xs-12 col-md-4">
                                            <select name="resultado_laboratorio" id="resultado_laboratorio"
                                                    class="form-control" disabled>
                                                <option value=""></option>
                                                <option value="1" <?php if ($estado == 1): ?> selected <?php endif ?> >
                                                    Positivo
                                                </option>
                                                <option value="2" <?php if ($estado == 2): ?> selected <?php endif ?> >
                                                    Negativo
                                                </option>
                                                <option value="3" <?php if ($estado == 3): ?> selected <?php endif ?> >
                                                    No concluyente
                                                </option>
                                            </select>
                                        </div>
                                        <label class="control-label col-xs-12 col-md-3">Estado desarrollo</label>
                                        <div class="col-xs-12 col-md-3">
                                            <select name="estado_desarrollo" id="estado_desarrollo"
                                                    class="form-control" disabled>
                                                <option value=""></option>
                                                <option
                                                    value="1" <?php if ($estado_desarrollo == 1): ?> selected <?php endif; ?> >
                                                    Larva
                                                </option>
                                                <option
                                                    value="2" <?php if ($estado_desarrollo == 2): ?> selected <?php endif; ?> >
                                                    Pupa
                                                </option>
                                                <option
                                                    value="3" <?php if ($estado_desarrollo == 3): ?> selected <?php endif; ?> >
                                                    Adulto
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 ">
                                        <label class="control-label col-xs-12 col-md-2">Observaciones</label>
                                        <div class="col-xs-12">
                                            <?php if ($contenido != ""): $rows = 15;
                                            else: $rows = 5; endif; ?>
                                            <textarea class="form-control" rows="<?php echo $rows; ?>"
                                                      id="observaciones_resultado"
                                                      name="observaciones_resultado" <?php if ($enviado or $presidencia): ?> disabled <?php endif; ?>><?php echo $contenido ?></textarea>
                                        </div>
                                    </div>

                                </div>

                                <!--<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="well well-sm" style="overflow:hidden">
                                            <label class="col-xs-12">Adjuntar archivos
                                                <button type="button" class="btn btn-sm btn-squere btn-orange" onclick="Vectores.agregarAdjunto();"><i
                                                        class=" fa fa-plus"></i></button>
                                            </label>
                                            <div class="col-xs-12 top-spaced" id="contenedor-adjuntos"></div>
                                        </div>
                                    </div>

                                </div>-->

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="text-right">
                                <?php if ($enviado or $presidencia): ?>
                                    <button type="button" class="btn btn-primary btn-square"
                                            onclick="javascript:history.back();">Volver
                                    </button>
                                <?php else: ?>
                                    <?php if ($id > 0 and $estado > 0): ?>
                                        <button type="button" class="btn btn-success btn-square"
                                                onclick="Hallazgos.enviarInforme(this.form,this);">
                                            <i class="fa fa-send"></i> Guardar y informar a persona
                                        </button>

                                    <?php else: ?>
                                        <button type="button" class="btn btn-success btn-square"
                                                onclick="Hallazgos.guardar(this.form,this);">
                                            <i class="fa fa-send"></i> Guardar y enviar a encargado de vectores
                                        </button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-primary btn-square"
                                            onclick="javascript:history.back();">Volver
                                    </button>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>

<?= loadJS("assets/js/modulo/mapa/formulario.js"); ?>
<?= loadJS("assets/js/modulo/vectores/hallazgos/denuncias.js"); ?>