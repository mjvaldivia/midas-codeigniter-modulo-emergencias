<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Inicio
                <small><i class="fa fa-arrow-right"></i> Resumen</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Inicio</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <form id="form-dengue" class="form-vertical" action="<?php echo base_url("publico/guardar_dengue") ?>" method="post" role="form">
            <div class="col-md-12">
                <legend>
                    Identificacion del caso
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body">
                        <div class="col-md-4">
                            <div id="mapa" style="height: 400px"></div>
                            <div class="alert alert-info">Puede mover el marcador para ajustar la ubicación del caso</div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Latitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="latitud" id="latitud" value="-27.11299">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre" class="control-label">Longitud(*):</label>
                                    <input type="text" class="form-control mapa-coordenadas" name="longitud" id="longitud" value="-109.34958059999997">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="nombre" class="control-label">Nombre(*):</label>
                                        <input value="" class="form-control" name="nombre" id="nombre">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="apellido" class="control-label">Apellidos(*):</label>
                                        <input value="" class="form-control" name="apellido" id="apellido">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="rut" class="control-label">Rut(*):</label>
                                        <input value="" class="form-control" name="rut" id="rut">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="sexo" class="control-label">Sexo(*):</label>
                                        <input value="" class="form-control" name="sexo" id="sexo">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento(*):</label>
                                        <input value="" class="form-control" name="fecha_de_nacimiento" id="fecha_nacimiento">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="direccion" class="control-label">Dirección(*):</label>
                                        <input value="" class="form-control" name="direccion" id="direccion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="ocupacion" class="control-label">Ocupación(*):</label>
                                        <input value="" class="form-control" name="ocupacion" id="ocupacion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>			
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Teléfono(s)(*):</label>
                                        <input value="" class="form-control" name="telefono" id="telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-6">

                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 top-spaced">
                <legend> Cuadro Clínico </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_consulta" class="control-label">Fecha consulta(*):</label>
                                    <input value="" class="form-control" name="fecha_de_consulta" id="fecha_consulta">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_1er_dia_fiebre" class="control-label">Fecha 1er día fiebre(*):</label>
                                    <input value="" class="form-control" name="fecha_1er_dia_fiebre" id="fecha_1er_dia_fiebre">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="temperatura_axilar" class="control-label">T° Axilar(*):</label>
                                    <input value="" class="form-control" name="temperatura_axilar" id="temperatura_axilar">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="hospitalizacion" name="hospitalizacion" type="checkbox" value="Si"> Hospitalización
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_hospitalizacion" class="control-label">Fecha hospitalización:</label>
                                    <input value="" class="form-control" name="fecha_hospitalizacion" id="fecha_hospitalizacion">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="fallecido" name="fallecido" type="checkbox" value="Si"> Fallecido
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_fallecimiento" class="control-label">Fecha fallecimiento:</label>
                                    <input value="" class="form-control" name="fecha_fallecimiento" id="fecha_fallecimiento">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">

                            </div>
                        </div>
                        <hr>
                        <div class="tile gray">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="fiebre" name="fiebre" type="checkbox" value="Si"> Fiebre
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="escalofrios" name="escalofrios" type="checkbox" value="Si"> Escalofrios
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="sudoracion" name="sudoracion" type="checkbox" value="Si"> Sudoración
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="cefalea" name="cefalea" type="checkbox" value="Si"> Cefalea
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="malgia_artralgia" name="malgia_artralgia" type="checkbox" value="Si"> Malgia / Artralgia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="inyeccion_conjuntival" name="inyeccion_conjuntival" type="checkbox" value="Si"> Inyección conjuntival
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dorsalgia" name="dorsalgia" type="checkbox" value="Si"> Dorsalgia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="nauseas_vomito" name="nauseas_vomito" type="checkbox" value="Si"> Nauseas / Vomito
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="convulsiones_generalizadas" name="convulsiones_generalizadas" type="checkbox" value="Si"> Convulsiones generalizadas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dificultad_respiratoria" name="dificultad_respiratoria" type="checkbox" value="Si"> Dificultad respiratoria
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dolor_retroorbitario" name="dolor_retroorbitario" type="checkbox" value="Si"> Dolor retroorbitario
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="compromiso_de_conciencia" name="compromiso_de_conciencia" type="checkbox" value="Si"> Compromiso de conciencia
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="manifestaciones_hemorragicas" name="manifestaciones_hemorragicas" type="checkbox" value="Si"> Manifestaciones hemorragicas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="petequias" name="petequias" type="checkbox" value="Si"> Petequias
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="erupcion_cutanea" name="erupcion_cutanea" type="checkbox" value="Si"> Erupcion cutanea
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="sintomas_respiratorios" name="sintomas_respiratorios" type="checkbox" value="Si"> Sintomas respiratorios
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="shock" name="shock" type="checkbox" value="Si"> Shock
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="ictericia" name="ictericia" type="checkbox" value="Si"> Ictericia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="compromiso_renal" name="compromiso_renal" type="checkbox" value="Si"> Compromiso renal
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="otros" class="control-label">Otros:</label>
                                    <input value="" class="form-control" name="otros" id="otros">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                             </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="influenza" class="control-label">Influenza:</label>
                                    <input value="" class="form-control" name="influenza" id="influenza">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="adenovirus" class="control-label">Adenovirus:</label>
                                    <input value="" class="form-control" name="adenovirus" id="adenovirus">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vrs" class="control-label">VRS:</label>
                                    <input value="" class="form-control" name="vrs" id="vrs">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="rotavirus" class="control-label">Rotavirus:</label>
                                    <input value="" class="form-control" name="rotavirus" id="rotavirus">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="diagnostico_clinico" class="control-label">Diagnostico clínico:</label>
                                    <input value="" class="form-control" name="diagnostico_clinico" id="diagnostico_clinico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre_medico" class="control-label">Nombre medico:</label>
                                    <input value="" class="form-control" name="nombre_medico" id="nombre_medico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 top-spaced">
                <legend> Investigación epidemiológica </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="ictericia" name="ictericia" type="checkbox" value="Si"> Vive en Isla de Pascua
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="viaje_fuera_de_isla_de_pascua" name="viaje_fuera_de_isla_de_pascua" type="checkbox" value="Si"> Viaje fuera de Isla de Pascua
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_lugar" class="control-label">Lugar:</label>
                                    <input value="" class="form-control" name="viaje_fuera_de_isla_de_pascua_lugar" id="viaje_fuera_de_isla_de_pascua_lugar">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_fecha_salida" class="control-label">Fecha salida:</label>
                                    <input value="" class="form-control" name="viaje_fuera_de_isla_de_pascua_fecha_salida" id="viaje_fuera_de_isla_de_pascua_fecha_salida">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_fecha_llegada" class="control-label">Fecha llegada:</label>
                                    <input value="" class="form-control" name="viaje_fuera_de_isla_de_pascua_fecha_llegada" id="viaje_fuera_de_isla_de_pascua_fecha_llegada">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="viaje_reciente_al_extrangero" name="viaje_reciente_al_extrangero" type="checkbox" value="Si"> Viaje reciente al extrangero
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_pais" class="control-label">País:</label>
                                    <input value="" class="form-control" name="viaje_reciente_al_extrangero_pais" id="viaje_reciente_al_extrangero_pais">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_fecha_salida" class="control-label">Fecha salida:</label>
                                    <input value="" class="form-control" name="viaje_reciente_al_extrangero_fecha_salida" id="viaje_reciente_al_extrangero_fecha_salida">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_fecha_llegada" class="control-label">Fecha llegada:</label>
                                    <input value="" class="form-control" name="viaje_reciente_al_extrangero_fecha_llegada" id="viaje_reciente_al_extrangero_fecha_llegada">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="lugar_de_residencia_hace_30_dias" class="control-label">Lugar de residencia los 30 dias anteriores al inicio de los sintomas:</label>
                                    <input value="" class="form-control" name="lugar_de_residencia_hace_30_dias" id="lugar_de_residencia_hace_30_dias">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="antecedentes_de_dengue_previo" name="antecedentes_de_dengue_previo" type="checkbox" value="Si"> Antecedentes de dengue previo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="antecedentes_de_dengue_previo_fecha" class="control-label">Fecha:</label>
                                    <input value="" class="form-control" name="antecedentes_de_dengue_previo_fecha" id="antecedentes_de_dengue_previo_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="caso_febril_grupo_familiar" name="caso_febril_grupo_familiar" type="checkbox" value="Si"> Caso febril actual en el grupo familiar
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vacunacion_contra_fiebre_amarilla" name="vacunacion_contra_fiebre_amarilla" type="checkbox" value="Si"> Vacunación contra fiebre amarilla
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="vacunacion_contra_fiebre_amarilla_fecha" class="control-label">Fecha vacunacion:</label>
                                    <input value="" class="form-control" name="vacunacion_contra_fiebre_amarilla_fecha" id="vacunacion_contra_fiebre_amarilla_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                            
                            
                            
            <div class="row top-spaced">
                <div class="col-xs-6"></div>
                <div class="col-xs-6 text-right">
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button id="guardar" class="btn btn-green" type="button"><i class="fa fa-floppy-o"></i> Guardar</button>
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("publico/dengue") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>


<?= loadJS("assets/js/modulo/evento/form/mapa/mapa.js") ?>
<?= loadJS("assets/js/form-dengue.js") ?>