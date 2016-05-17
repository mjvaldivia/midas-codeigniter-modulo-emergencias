<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de Vigilancia de Vectores :: Inspecciones</h1>
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

                <form class="form-horizontal" role="form">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                    <div class="row">
                        <div class="col-xs-12">
                            <legend>Revisión de la inspección

                            </legend>


                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <input type="hidden" class="mapa-coordenadas" id="latitud" name="latitud"
                                   value="<?php echo $latitud ?>"/>
                            <input type="hidden" class="mapa-coordenadas" id="longitud" name="longitud"
                                   value="<?php echo $longitud ?>"/>

                            <div id="mapa" style="height: 500px;" class="col-xs-12"></div>
                            <p></p>
                            <div class="alert alert-info top-spaced" style="margin-top:20px">Puede mover el marcador
                                para ajustar la ubicación
                                del caso
                                <?php if($id > 0 and $cambiar_coordenadas):?>
                                    <button type="button" class="btn btn-sm btn-info pull-right btn-square" onclick="Hallazgos.cambiarCoordenadas(<?php echo $id?>);">Cambiar coordenadas</button>
                                <?php endif;?>
                            </div>

                            <div class="top-spaced">
                                <div class="col-xs-12" id="contenedor_imagenes">
                                    <?php if ($imagenes): ?>
                                        <div class="row">
                                            <?php foreach ($imagenes as $imagen): ?>
                                                <div class="col-xs-6 col-md-3"
                                                     style="padding:5px;border:1px solid #111;">
                                                    <img
                                                        src="<?php echo base_url($imagen['ruta'] . '/' . $imagen['nombre']) ?>"
                                                        class="img-responsive" style="height: 150px;cursor:pointer;"
                                                        onclick="xModal.open('<?php echo base_url('hallazgos/verImagenInspeccion/id/' . $imagen['id'] . '/sha/' . $imagen['sha'] . '/otra/true') ?>','Imagen Inspección H-<?php echo $id ?>','lg');"/>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Nombres(*)</label>
                                    <input type="text" name="nombres" id="nombres" class="form-control disabled"
                                           value="<?php echo $nombres ?>" disabled/>

                                    <label class="control-label">Apellidos(*)</label>
                                    <input type="text" name="apellidos" id="apellidos" class="form-control disabled"
                                           value="<?php echo $apellidos ?>" disabled/>

                                    <!--<label class="control-label">RUN o Pasaporte(*)</label>
                                    <input type="text" name="cedula" id="cedula" class="form-control disabled"
                                           value="<?php /*echo $cedula */ ?>" disabled/>-->

                                    <label class="control-label">Telefóno(s) de contacto</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control disabled"
                                           value="<?php echo $telefono ?>" disabled/>

                                    <label class="control-label">Correo electrónico(*)</label>
                                    <input type="text" name="correo" id="correo" class="form-control disabled"
                                           value="<?php echo $correo ?>" disabled/>

                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <?php /*if ($id > 0): */ ?><!--
                                        <div class="portlet portlet-dark-blue" style="margin-top:25px">
                                            <div class="portlet-heading text-center">
                                                <h3>Número Denuncia</h3>
                                                <span style="font-size:96px"><?php /*echo $id */ ?></span>
                                            </div>
                                        </div>

                                    --><?php /*endif; */ ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="control-label">Dirección/Lugar de Hallazgo del mosquito(*)</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control disabled"
                                           value="<?php echo $direccion ?>" disabled />
                                </div>
                                <div class="col-xs-12">
                                    <label class="control-label">Referencias de la dirección</label>
                                    <input type="text" name="referencias" id="referencias" class="form-control"
                                           value="<?php echo $referencias ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-md-6">
                                    <label class="control-label">Fecha de hallazgo(*)</label>
                                    <input type="text" name="fecha_hallazgo" id="fecha_hallazgo"
                                           class="form-control datepicker-date disabled"
                                           value="<?php echo $fecha_hallazgo ?>" disabled/>
                                </div>
                                <!--<div class="col-xs-12 col-md-6">
                                    <label class="control-label">Fecha de entrega(*)</label>
                                    <input type="text" name="fecha_entrega" id="fecha_entrega"
                                           class="form-control datepicker-date disabled"
                                           value="<?php /*echo $fecha_hallazgo */ ?>" disabled/>
                                </div>-->

                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="">Comentarios de la inspección</label>
                                    <textarea class="form-control" rows="5" id="comentarios_ciudadano"
                                              name="comentarios_ciudadano"
                                              disabled><?php echo $comentarios_ciudadano ?></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label class="control-label text-bold">Resultado</label>
                                </div>
                                <div class="col-xs-12 ">
                                    <label class="control-label col-xs-12 col-md-2">Aedes aegypti</label>
                                    <div class="col-xs-12 col-md-4">
                                        <select name="resultado_laboratorio" id="resultado_laboratorio"
                                                class="form-control">
                                            <option value=""></option>
                                            <option value="1">Positivo</option>
                                            <option value="2">Negativo</option>
                                            <option value="3">No concluyente</option>
                                        </select>
                                    </div>
                                    <label class="control-label col-xs-12 col-md-3">Estado desarrollo</label>
                                    <div class="col-xs-12 col-md-3">
                                        <select name="estado_desarrollo" id="estado_desarrollo"
                                                class="form-control">
                                            <option value=""></option>
                                            <option value="1">Larva</option>
                                            <option value="2">Pupa</option>
                                            <option value="3">Adulto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 ">
                                    <label class="control-label col-xs-12 col-md-2">Observaciones</label>
                                    <div class="col-xs-12">
                                        <textarea class="form-control" rows="10" name="observaciones_resultado"
                                                  id="observaciones_resultado"><?php echo $contenido?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="text-right">
                                <?php if ($id > 0): ?>
                                    <button type="button" class="btn btn-success btn-square"
                                            onclick="Hallazgos.guardarResultado(this.form,this);">
                                        <i class="fa fa-send"></i> Guardar y enviar respuesta
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

