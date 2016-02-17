<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de casos febriles
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("publico/index") ?>"> Casos febriles </a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <form id="form-dengue" class="form-vertical" action="<?php echo base_url("publico/guardar_dengue") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
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
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="nombre" class="control-label">Nombre(*):</label>
                                        <input value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="apellido" class="control-label">Apellidos(*):</label>
                                        <input value="<?php echo $apellido; ?>" class="form-control" name="apellido" id="apellido">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="rut" class="control-label">Rut(*):</label>
                                        <input value="<?php echo $rut; ?>" class="form-control" name="rut" id="rut">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="sexo" class="control-label">Sexo(*):</label>
                                        <input value="<?php echo $sexo; ?>" class="form-control" name="sexo" id="sexo">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento(*):</label>
                                        <input value="<?php echo $fecha_nacimiento; ?>" class="form-control" name="fecha_de_nacimiento" id="fecha_nacimiento">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="direccion" class="control-label">Dirección(*):</label>
                                        <input value="<?php echo $direccion; ?>" class="form-control" name="direccion" id="direccion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="ocupacion" class="control-label">Ocupación(*):</label>
                                        <input value="<?php echo $ocupacion; ?>" class="form-control" name="ocupacion" id="ocupacion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>			
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Teléfono(s)(*):</label>
                                        <input value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono">
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
                                    <input value="<?php echo $fecha_consulta; ?>" class="form-control datepicker-date" name="fecha_de_consulta" id="fecha_consulta">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_1er_dia_fiebre" class="control-label">Fecha 1er día fiebre(*):</label>
                                    <input value="<?php echo $fecha_1er_dia_fiebre; ?>" class="form-control datepicker-date" name="fecha_1er_dia_fiebre" id="fecha_1er_dia_fiebre">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="temperatura_axilar" class="control-label">T° Axilar(*):</label>
                                    <input value="<?php echo $temperatura_axilar; ?>" class="form-control" name="temperatura_axilar" id="temperatura_axilar">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="hospitalizacion" name="hospitalizacion" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $hospitalizacion); ?>> Hospitalización
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_hospitalizacion" class="control-label">Fecha hospitalización:</label>
                                    <input value="<?php echo $fecha_hospitalizacion; ?>" class="form-control datepicker-date" name="fecha_hospitalizacion" id="fecha_hospitalizacion">
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
                                            <input id="fallecido" name="fallecido" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $fallecido); ?>> Fallecido
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_fallecimiento" class="control-label">Fecha fallecimiento:</label>
                                    <input value="<?php echo $fecha_fallecimiento; ?>" class="form-control datepicker-date" name="fecha_fallecimiento" id="fecha_fallecimiento">
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
                                            <input id="fiebre" name="fiebre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $fiebre); ?>> Fiebre
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="escalofrios" name="escalofrios" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $escalofrios); ?>> Escalofrios
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="sudoracion" name="sudoracion" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sudoracion); ?>> Sudoración
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="cefalea" name="cefalea" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $cefalea); ?>> Cefalea
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
                                            <input id="malgia_artralgia" name="malgia_artralgia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $malgia_artralgia); ?>> Malgia / Artralgia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="inyeccion_conjuntival" name="inyeccion_conjuntival" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $inyeccion_conjuntival); ?>> Inyección conjuntival
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dorsalgia" name="dorsalgia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $dorsalgia); ?>> Dorsalgia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="nauseas_vomito" name="nauseas_vomito" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $nauseas_vomito); ?>> Nauseas / Vomito
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
                                            <input id="convulsiones_generalizadas" name="convulsiones_generalizadas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $convulsiones_generalizadas); ?>> Convulsiones generalizadas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dificultad_respiratoria" name="dificultad_respiratoria" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $dificultad_respiratoria); ?>> Dificultad respiratoria
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="dolor_retroorbitario" name="dolor_retroorbitario" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $dolor_retroorbitario); ?>> Dolor retroorbitario
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="compromiso_de_conciencia" name="compromiso_de_conciencia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $compromiso_de_conciencia); ?>> Compromiso de conciencia
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
                                            <input id="manifestaciones_hemorragicas" name="manifestaciones_hemorragicas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $manifestaciones_hemorragicas); ?>> Manifestaciones hemorragicas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="petequias" name="petequias" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $petequias); ?>> Petequias
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="erupcion_cutanea" name="erupcion_cutanea" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $erupcion_cutanea); ?>> Erupcion cutanea
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="sintomas_respiratorios" name="sintomas_respiratorios" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sintomas_respiratorios); ?>> Sintomas respiratorios
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
                                            <input id="shock" name="shock" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $shock); ?>> Shock
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="ictericia" name="ictericia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $ictericia); ?>> Ictericia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="compromiso_renal" name="compromiso_renal" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $compromiso_renal); ?>> Compromiso renal
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="otros" class="control-label">Otros:</label>
                                    <input value="<?php echo $otros; ?>" class="form-control" name="otros" id="otros">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                             </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="influenza" class="control-label">Influenza:</label>
                                    <input value="<?php echo $influenza; ?>" class="form-control" name="influenza" id="influenza">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="adenovirus" class="control-label">Adenovirus:</label>
                                    <input value="<?php echo $adenovirus; ?>" class="form-control" name="adenovirus" id="adenovirus">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="vrs" class="control-label">VRS:</label>
                                    <input value="<?php echo $vrs; ?>" class="form-control" name="vrs" id="vrs">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="rotavirus" class="control-label">Rotavirus:</label>
                                    <input value="<?php echo $rotavirus; ?>" class="form-control" name="rotavirus" id="rotavirus">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="diagnostico_clinico" class="control-label">Diagnostico clínico:</label>
                                    <input value="<?php echo $diagnostico_clinico; ?>" class="form-control" name="diagnostico_clinico" id="diagnostico_clinico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre_medico" class="control-label">Nombre medico:</label>
                                    <input value="<?php echo $nombre_medico; ?>" class="form-control" name="nombre_medico" id="nombre_medico">
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
                                            <input id="vive_en_isla" name="vive_en_isla" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $vive_en_isla); ?>> Vive en Isla de Pascua
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
                                            <input id="viaje_fuera_de_isla_de_pascua" name="viaje_fuera_de_isla_de_pascua" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $viaje_fuera_de_isla_de_pascua); ?>> Viaje fuera de Isla de Pascua
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_lugar" class="control-label">Lugar:</label>
                                    <input value="<?php echo $viaje_fuera_de_isla_de_pascua_lugar; ?>" class="form-control" name="viaje_fuera_de_isla_de_pascua_lugar" id="viaje_fuera_de_isla_de_pascua_lugar">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_fecha_salida" class="control-label">Fecha salida:</label>
                                    <input value="<?php echo $viaje_fuera_de_isla_de_pascua_fecha_salida; ?>" class="form-control datepicker-date" name="viaje_fuera_de_isla_de_pascua_fecha_salida" id="viaje_fuera_de_isla_de_pascua_fecha_salida">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_fuera_de_isla_de_pascua_fecha_llegada" class="control-label">Fecha llegada:</label>
                                    <input value="<?php echo $viaje_fuera_de_isla_de_pascua_fecha_llegada; ?>" class="form-control datepicker-date" name="viaje_fuera_de_isla_de_pascua_fecha_llegada" id="viaje_fuera_de_isla_de_pascua_fecha_llegada">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="viaje_reciente_al_extrangero" name="viaje_reciente_al_extrangero" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $viaje_reciente_al_extrangero); ?>> Viaje reciente al extrangero
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_pais" class="control-label">País:</label>
                                    <input value="<?php echo $viaje_reciente_al_extrangero_pais; ?>" class="form-control" name="viaje_reciente_al_extrangero_pais" id="viaje_reciente_al_extrangero_pais">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_fecha_salida" class="control-label">Fecha salida:</label>
                                    <input value="<?php echo $viaje_reciente_al_extrangero_fecha_salida; ?>" class="form-control datepicker-date" name="viaje_reciente_al_extrangero_fecha_salida" id="viaje_reciente_al_extrangero_fecha_salida">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="viaje_reciente_al_extrangero_fecha_llegada" class="control-label">Fecha llegada:</label>
                                    <input value="<?php echo $viaje_reciente_al_extrangero_fecha_llegada; ?>" class="form-control datepicker-date" name="viaje_reciente_al_extrangero_fecha_llegada" id="viaje_reciente_al_extrangero_fecha_llegada">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="lugar_de_residencia_hace_30_dias" class="control-label">Lugar de residencia los 30 dias anteriores al inicio de los sintomas:</label>
                                    <input value="<?php echo $lugar_de_residencia_hace_30_dias; ?>" class="form-control" name="lugar_de_residencia_hace_30_dias" id="lugar_de_residencia_hace_30_dias">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="antecedentes_de_dengue_previo" name="antecedentes_de_dengue_previo" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $antecedentes_de_dengue_previo); ?>> Antecedentes de dengue previo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="antecedentes_de_dengue_previo_fecha" class="control-label">Fecha:</label>
                                    <input value="<?php echo $antecedentes_de_dengue_previo_fecha; ?>" class="form-control datepicker-date" name="antecedentes_de_dengue_previo_fecha" id="antecedentes_de_dengue_previo_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="caso_febril_grupo_familiar" name="caso_febril_grupo_familiar" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $caso_febril_grupo_familiar); ?>> Caso febril actual en el grupo familiar
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vacunacion_contra_fiebre_amarilla" name="vacunacion_contra_fiebre_amarilla" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $vacunacion_contra_fiebre_amarilla); ?>> Vacunación contra fiebre amarilla
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="vacunacion_contra_fiebre_amarilla_fecha" class="control-label">Fecha vacunacion:</label>
                                    <input value="<?php echo $vacunacion_contra_fiebre_amarilla_fecha; ?>" class="form-control datepicker-date" name="vacunacion_contra_fiebre_amarilla_fecha" id="vacunacion_contra_fiebre_amarilla_fecha">
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
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("publico/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
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