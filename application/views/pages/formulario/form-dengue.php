<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de casos febriles/exantemáticos ISLA DE PASCUA </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("formulario/index") ?>"> Casos febriles</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                
                <?php if(puedeEditar("casos_febriles") || puedeEliminar("casos_febriles") || puedeVerReporteEmergencia("casos_febriles")){ ?>
                <li class="pull-right"><a href="<?php echo base_url("formulario/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
                <?php } ?>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            
            <?php if($ingresado == "correcto") { ?>
            <div class="col-md-12">
                <div class="alert alert-success">
                    Se ha ingresado el caso correctamente
                </div>
            </div>
            <?php } ?>
            
            
            <form id="form-dengue" autocomplete="off" class="form-vertical" action="<?php echo base_url("formulario/guardar_dengue") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Identificación del caso <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body">
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
                                <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
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
                                    <div class="form-group clearfix">
                                        <label for="sexo" class="control-label">Sexo(*):</label>
                                        <select name="sexo" id="sexo" class="form-control">
                                            <option value=""></option>
                                            <option value="M" <?php if($sexo == "Masculino" || $sexo == "M") echo "selected" ?>> M </option>
                                            <option value="F" <?php if($sexo == "Femenino" || $sexo == "F") echo "selected" ?>> F </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
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
                                <div class="<?php if(!puedeVerFormularioDatosPersonales("casos_febriles")) echo "hidden"; ?>">
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
                                        <label for="direccion" class="control-label">Dirección de residencia/trabajo o de estadía en Isla de Pascua (*):</label>
                                        <input value="<?php echo $direccion; ?>" class="form-control" name="direccion" id="direccion">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="ocupacion" class="control-label">Origen(*):</label>
                                         <select name="origen" id="origen" class="form-control">
                                            <option value=""></option>
                                            <option value="Residente" <?php if($origen == "Residente") echo "selected" ?>> Residente natural </option>
                                            <option value="Residente no permanente" <?php if($origen == "Residente no permanente") echo "selected" ?>> Residente no permanente (1 año) </option>
                                            <option value="Turista estadía corta" <?php if($origen == "Turista estadía corta") echo "selected" ?>> Turista estadía corta (hasta un mes) </option>
                                        </select>
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
                            <div class="col-xs-6">
                                
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="fecha_de_consulta" class="control-label">Fecha consulta(*):</label>
                                            <input value="<?php echo $fecha_de_consulta; ?>" class="form-control datepicker-date" name="fecha_de_consulta" id="fecha_de_consulta">
                                            <span class="help-block">Formato: dd/mm/aaaa</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="temperatura_axilar" class="control-label">T° Axilar al momento de la consulta(*):</label>
                                            <input type="text" value="<?php echo $temperatura_axilar; ?>" class="form-control" name="temperatura_axilar" id="temperatura_axilar">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="fecha_de_inicio_de_sintomas" class="control-label">Fecha de inicio de síntomas (fiebre o exantema) (*):</label>
                                            <input value="<?php echo $fecha_de_inicio_de_sintomas; ?>" class="form-control" name="fecha_de_inicio_de_sintomas" id="fecha_de_inicio_de_sintomas">
                                            <span class="help-block">Formato: dd/mm/aaaa</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="semana_epidemiologica" class="control-label">Semana epidemiológica:</label>
                                            <div class="clearfix"></div>
                                            <div class="label blue" id="texto_semana_epidemiologica"><?php echo $semana_epidemiologica; ?></div>
                                            <input type="hidden" value="<?php echo $semana_epidemiologica; ?>" class="form-control" name="semana_epidemiologica" id="semana_epidemiologica">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1">
                            </div>
                            <div class="col-xs-4">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="form-group clearfix">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="hospitalizacion" type="hidden" value="No" />
                                                    <input id="hospitalizacion" name="hospitalizacion" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $hospitalizacion); ?>> Hospitalización
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="form-group clearfix">
                                            <label for="fecha_hospitalizacion" class="control-label">Fecha hospitalización:</label>
                                            <input value="<?php echo $fecha_hospitalizacion; ?>" class="form-control datepicker-date" name="fecha_hospitalizacion" id="fecha_hospitalizacion">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="form-group clearfix">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="fallecido" type="hidden" value="No" />
                                                    <input id="fallecido" name="fallecido" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $fallecido); ?>> Fallecido
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="form-group clearfix">
                                            <label for="fecha_fallecimiento" class="control-label">Fecha fallecimiento:</label>
                                            <input value="<?php echo $fecha_fallecimiento; ?>" class="form-control datepicker-date" name="fecha_fallecimiento" id="fecha_fallecimiento">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <legend> <small>Signos clínicos</small> </legend>

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="fiebre" type="hidden" value="No" />
                                            <input id="fiebre" name="fiebre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $fiebre); ?>> Fiebre
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="exantema_generalizado" type="hidden" value="No" />
                                            <input id="exantema_generalizado" name="exantema_generalizado" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $exantema_generalizado); ?>> Exantema generalizado
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="calofrios" type="hidden" value="No" />
                                            <input id="calofrios" name="calofrios" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $calofrios); ?>> Calofríos
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="sudoracion" type="hidden" value="No" />
                                            <input id="sudoracion" name="sudoracion" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sudoracion); ?>> Sudoración
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
                                            <input name="cefalea_dolor_retroorbitario" type="hidden" value="No" />
                                            <input id="cefalea_dolor_retroorbitario" name="cefalea_dolor_retroorbitario" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $cefalea_dolor_retroorbitario); ?>> Cefalea / Dolor retroorbitario
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="tos" name="tos" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $tos); ?>> Tos
                                            <input name="tos" type="hidden" value="No" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input id="coriza" name="coriza" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $coriza); ?>> Coriza
                                            <input name="coriza" type="hidden" value="No" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            
                                            <input id="mialgia" name="mialgia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $mialgia); ?>> Mialgia 
                                            <input name="mialgia" type="hidden" value="No" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            
                                            <input id="artralgia" name="artralgia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $artralgia); ?>> Artralgia
                                            <input name="artralgia" type="hidden" value="No" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="conjuntivitis" type="hidden" value="No" />
                                            <input id="conjuntivitis" name="conjuntivitis" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $conjuntivitis); ?>> Conjuntivitis
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="nauseas_vomito" type="hidden" value="No" />
                                            <input id="nauseas_vomito" name="nauseas_vomito" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $nauseas_vomito); ?>> Náuseas / Vómito
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="diarrea" type="hidden" value="No" />
                                            <input id="diarrea" name="diarrea" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $diarrea); ?>> Diarrea
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="edema_de_articulacion_manos_y_pies" type="hidden" value="No" />
                                            <input id="edema_de_articulacion_manos_y_pies" name="edema_de_articulacion_manos_y_pies" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $edema_de_articulacion_manos_y_pies); ?>>  Edema de articulación de manos/pies
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="ictericia" type="hidden" value="No" />
                                            <input id="ictericia" name="ictericia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $ictericia); ?>> Ictericia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="torniquete" type="hidden" value="No" />
                                            <input id="torniquete" name="torniquete" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $torniquete); ?>> Torniquete (+)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="leucopenia" type="hidden" value="No" />
                                            <input id="leucopenia" name="leucopenia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $leucopenia); ?>> Leucopenia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="acumulacion_extravascular_de_fluidos" type="hidden" value="No" />
                                            <input id="acumulacion_extravascular_de_fluidos" name="acumulacion_extravascular_de_fluidos" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $acumulacion_extravascular_de_fluidos); ?>> Acumulación extravascular de fluidos
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="dolor_o_sensibilidad_abdominal" type="hidden" value="No" />
                                            <input id="dolor_o_sensibilidad_abdominal" name="dolor_o_sensibilidad_abdominal" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $dolor_o_sensibilidad_abdominal); ?>> Dolor/sensibilidad abdominal
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="sangramiento_de_mucosas" type="hidden" value="No" />
                                            <input id="sangramiento_de_mucosas" name="sangramiento_de_mucosas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sangramiento_de_mucosas); ?>> Sangramiento de mucosas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="hepatomegalia_2cm" type="hidden" value="No" />
                                            <input id="hepatomegalia_2cm" name="hepatomegalia_2cm" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $hepatomegalia_2cm); ?>> Hepatomegalia > 2cm
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="aumento_hematocrito" type="hidden" value="No" />
                                            <input id="aumento_hematocrito" name="aumento_hematocrito" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $aumento_hematocrito); ?>> Aumento hematocrito
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="disminucion_de_plaquetas" type="hidden" value="No" />
                                            <input id="disminucion_de_plaquetas" name="disminucion_de_plaquetas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $disminucion_de_plaquetas); ?>> Disminución de plaquetas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="sdra" type="hidden" value="No" />
                                            <input id="sdra" name="sdra" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sdra); ?>> SDRA
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="shock" type="hidden" value="No" />
                                            <input id="shock" name="shock" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $shock); ?>> Shock
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="sangramiento_severo" type="hidden" value="No" />
                                            <input id="sangramiento_severo" name="sangramiento_severo" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $sangramiento_severo); ?>> Sangramiento severo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="compromiso_severo_de_organos" type="hidden" value="No" />
                                            <input id="compromiso_severo_de_organos" name="compromiso_severo_de_organos" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $compromiso_severo_de_organos); ?>> Compromiso severo de órganos
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="meningitis_encefalitis" type="hidden" value="No" />
                                            <input id="meningitis_encefalitis" name="meningitis_encefalitis" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $meningitis_encefalitis); ?>> Meningitis/encefalitis
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="paralisis_flaccida_aguda" type="hidden" value="No" />
                                            <input id="paralisis_flaccida_aguda" name="paralisis_flaccida_aguda" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $paralisis_flaccida_aguda); ?>> Parálisis fláccida aguda/Sind. Guillain-Barré
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="vertigo" type="hidden" value="No" />
                                            <input id="vertigo" name="vertigo" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $vertigo); ?>> Vértigo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="paresia" type="hidden" value="No" />
                                            <input id="paresia" name="paresia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $paresia); ?>> Paresia
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="rigidez_de_nuca" type="hidden" value="No" />
                                            <input id="rigidez_de_nuca" name="rigidez_de_nuca" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $rigidez_de_nuca); ?>> Rigidez de nuca
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="albuminuria" type="hidden" value="No" />
                                            <input id="albuminuria" name="albuminuria" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $albuminuria); ?>> Albuminuria
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="anemia_severa" type="hidden" value="No" />
                                            <input id="anemia_severa" name="anemia_severa" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $anemia_severa); ?>> Anemia severa
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="dificultad_respiratoria" type="hidden" value="No" />
                                            <input id="dificultad_respiratoria" name="dificultad_respiratoria" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $dificultad_respiratoria); ?>> Dificultad respiratoria
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
                 
                        <legend> <small> Resultados test rápidos </small> </legend>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group clearfix">
                                    <label for="influenza" class="control-label">Influenza:</label>
                                    <select name="influenza" id="influenza" class="form-control">
                                        <option value=""></option>
                                        <option value="positivo" <?php if($influenza == "positivo") echo "selected" ?>> positivo </option>
                                        <option value="negativo" <?php if($influenza == "negativo") echo "selected" ?>> negativo </option>
                                        <option value="no concluyente" <?php if($influenza == "no concluyente") echo "selected" ?>> no concluyente </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group clearfix">
                                    <label for="adenovirus" class="control-label">Adenovirus:</label>
                                    <select name="adenovirus" id="adenovirus" class="form-control">
                                        <option value=""></option>
                                        <option value="positivo" <?php if($adenovirus == "positivo") echo "selected" ?>> positivo </option>
                                        <option value="negativo" <?php if($adenovirus == "negativo") echo "selected" ?>> negativo </option>
                                        <option value="no concluyente" <?php if($adenovirus == "no concluyente") echo "selected" ?>> no concluyente </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group clearfix">
                                    <label for="vrs" class="control-label">VRS:</label>
                                    <select name="vrs" id="vrs" class="form-control">
                                        <option value=""></option>
                                        <option value="positivo" <?php if($vrs == "positivo") echo "selected" ?>> positivo </option>
                                        <option value="negativo" <?php if($vrs == "negativo") echo "selected" ?>> negativo </option>
                                        <option value="no concluyente" <?php if($vrs == "no concluyente") echo "selected" ?>> no concluyente </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group clearfix">
                                    <label for="rotavirus" class="control-label">Rotavirus:</label>
                                    <select name="rotavirus" id="rotavirus" class="form-control">
                                        <option value=""></option>
                                        <option value="positivo" <?php if($rotavirus == "positivo") echo "selected" ?>> positivo </option>
                                        <option value="negativo" <?php if($rotavirus == "negativo") echo "selected" ?>> negativo </option>
                                        <option value="no concluyente" <?php if($rotavirus == "no concluyente") echo "selected" ?>> no concluyente </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group clearfix">
                                    <label for="dengue_local" class="control-label">Dengue local:</label>
                                    <select name="dengue_local" id="dengue_local" class="form-control">
                                        <option value=""></option>
                                        <option value="positivo" <?php if($dengue_local == "positivo") echo "selected" ?>> positivo </option>
                                        <option value="negativo" <?php if($dengue_local == "negativo") echo "selected" ?>> negativo </option>
                                        <option value="no concluyente" <?php if($dengue_local == "no concluyente") echo "selected" ?>> no concluyente </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="diagnostico_clinico" class="control-label">Diagnóstico clínico:</label>
                                    <input value="<?php echo $diagnostico_clinico; ?>" class="form-control" name="diagnostico_clinico" id="diagnostico_clinico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 top-spaced">
                <legend> Laboratorio </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible;">
                        <div class="row">
                            <div class="col-xs-12">
                                <table width="100%" class="table table-bordered table-green">
                                    <thead>
                                    <tr>
                                        <th width="20%">TIPO DE MUESTRA</th>
                                        <th width="10%">Sangre</th>
                                        <th width="10%">Orina</th>
                                        <th width="10%">LCE</th>
                                        <th width="25%">Fecha de toma</th>
                                        <th width="25%">Rechaza toma de muestra</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">Muestra PCR</td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_pcr_sangre" type="hidden" value="No" />
                                                        <input id="muestra_pcr_sangre" name="muestra_pcr_sangre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_pcr_sangre); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_pcr_orina" type="hidden" value="No" />
                                                        <input id="muestra_pcr_orina" name="muestra_pcr_orina" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_pcr_orina); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_pcr_lce" type="hidden" value="No" />
                                                        <input id="muestra_pcr_lce" name="muestra_pcr_lce" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_pcr_lce); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center"><input value="<?php echo $muestra_pcr_fecha; ?>" class="form-control datepicker-date" name="muestra_pcr_fecha" id="muestra_pcr_fecha"></td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_pcr_rechaza_toma" type="hidden" value="No" />
                                                        <input id="muestra_pcr_rechaza_toma" name="muestra_pcr_rechaza_toma" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_pcr_rechaza_toma); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">Muestra serología</td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_serologia_sangre" type="hidden" value="No" />
                                                        <input id="muestra_serologia_sangre" name="muestra_serologia_sangre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_serologia_sangre); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_serologia_orina" type="hidden" value="No" />
                                                        <input id="muestra_serologia_orina" name="muestra_serologia_orina" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_serologia_orina); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_serologia_lce" type="hidden" value="No" />
                                                        <input id="muestra_serologia_lce" name="muestra_serologia_lce" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_serologia_lce); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center"><input value="<?php echo $muestra_serologia_fecha; ?>" class="form-control datepicker-date" name="muestra_serologia_fecha" id="muestra_serologia_fecha"></td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_serologia_rechaza_toma" type="hidden" value="No" />
                                                        <input id="muestra_serologia_rechaza_toma" name="muestra_serologia_rechaza_toma" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_serologia_rechaza_toma); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">Muestra frotis</td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_frotis_sangre" type="hidden" value="No" />
                                                        <input id="muestra_frotis_sangre" name="muestra_frotis_sangre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_frotis_sangre); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_frotis_orina" type="hidden" value="No" />
                                                        <input id="muestra_frotis_orina" name="muestra_frotis_orina" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_frotis_orina); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_frotis_lce" type="hidden" value="No" />
                                                        <input id="muestra_frotis_lce" name="muestra_frotis_lce" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_frotis_lce); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center"><input value="<?php echo $muestra_frotis_fecha; ?>" class="form-control datepicker-date" name="muestra_frotis_fecha" id="muestra_frotis_fecha"></td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_frotis_rechaza_toma" type="hidden" value="No" />
                                                        <input id="muestra_frotis_rechaza_toma" name="muestra_frotis_rechaza_toma" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_frotis_rechaza_toma); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <div class="col-xs-4 text-right">Otro:</div> <div class="col-xs-8"><input value="<?php echo $muestra_otro; ?>" class="form-control" name="muestra_otro" id="muestra_otro"></div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_otro_sangre" type="hidden" value="No" />
                                                        <input id="muestra_otro_sangre" name="muestra_otro_sangre" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_otro_sangre); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_otro_orina" type="hidden" value="No" />
                                                        <input id="muestra_otro_orina" name="muestra_otro_orina" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_otro_orina); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_otro_lce" type="hidden" value="No" />
                                                        <input id="muestra_otro_lce" name="muestra_otro_lce" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_otro_lce); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                            <td align="center"><input value="<?php echo $muestra_otro_fecha; ?>" class="form-control datepicker-date" name="muestra_otro_fecha" id="muestra_otro_fecha"></td>
                                            <td align="center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="muestra_otro_rechaza_toma" type="hidden" value="No" />
                                                        <input id="muestra_otro_rechaza_toma" name="muestra_otro_rechaza_toma" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $muestra_otro_rechaza_toma); ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info text-center"> SE SOLICITA ANÁLISIS PARA </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table width="100%">
                                    <tr>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_dengue" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_dengue" name="se_solicita_analisis_para_dengue" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_dengue); ?>> Dengue
                                                </label>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_chikungunya" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_chikungunya" name="se_solicita_analisis_para_chikungunya" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_chikungunya); ?>> Chikungunya
                                                </label>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_zika" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_zika" name="se_solicita_analisis_para_zika" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_zika); ?>> Zika
                                                </label>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_fiebre_amarilla" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_fiebre_amarilla" name="se_solicita_analisis_para_fiebre_amarilla" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_fiebre_amarilla); ?>> Fiebre Amarilla
                                                </label>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_virus_del_nilo_occidental" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_virus_del_nilo_occidental" name="se_solicita_analisis_para_virus_del_nilo_occidental" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_virus_del_nilo_occidental); ?>> Virus del Nilo Occidental
                                                </label>
                                            </div>
                                        </td>
                                        <td width="15%">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="se_solicita_analisis_para_malaria" type="hidden" value="No" />
                                                    <input id="se_solicita_analisis_para_fiebre_malaria" name="se_solicita_analisis_para_malaria" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $se_solicita_analisis_para_malaria); ?>> Malaria
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <small> (*) frente a cualquier caso que presente exantema macular generalizado, acompañado de uno o más de los siguientes signos o síntomas: fiebre ≥ 38º C, conjuntivitis, linfoadenopatías o artralgias (puede acompañarse de tos y coriza), sospeche de Sarampión-Rubeola </small>
                            </div>
                        </div>
                        
                        <div class="">
                        
                        <div class="row top-spaced-doble">
                            <div class="col-xs-12">
                                <legend>
                                <small> Resultados </small>
                                </legend>
                            </div>
                        </div>
                        
                        <div class="row top-spaced">
                            <div class="col-xs-9">
                                <table width="100%" class="table table-bordered table-green">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>PCR</th>
                                            <th>Serología</th>
                                            <th>Otro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Dengue</td>
                                            <td>
                                                <select name="conclusion_pcr_dengue" id="conclusion_pcr_dengue" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_dengue == "Confirmado" OR $conclusion_pcr_dengue == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_dengue == "Descartado" OR $conclusion_pcr_dengue == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_dengue == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_dengue" id="conclusion_serologia_dengue" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_dengue == "Confirmado" OR $conclusion_serologia_dengue == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_dengue == "Descartado" OR $conclusion_serologia_dengue == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_dengue == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_dengue" id="conclusion_otro_dengue" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_dengue == "Confirmado" OR $conclusion_otro_dengue == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_dengue == "Descartado" OR $conclusion_otro_dengue == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_dengue == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Chikungunya</td>
                                            <td>
                                                <select name="conclusion_pcr_chikungunya" id="conclusion_pcr_chikungunya" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_chikungunya == "Confirmado" OR $conclusion_pcr_chikungunya == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_chikungunya == "Descartado" OR $conclusion_pcr_chikungunya == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_chikungunya == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_chikungunya" id="conclusion_serologia_chikungunya" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_chikungunya == "Confirmado" OR $conclusion_serologia_chikungunya == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_chikungunya == "Descartado" OR $conclusion_serologia_chikungunya == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_chikungunya == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_chikungunya" id="conclusion_otro_chikungunya" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_chikungunya == "Confirmado" OR $conclusion_otro_chikungunya == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_chikungunya == "Descartado" OR $conclusion_otro_chikungunya == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_chikungunya == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Zika</td>
                                            <td>
                                                <select name="conclusion_pcr_zika" id="conclusion_pcr_zika" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_zika == "Confirmado" OR $conclusion_pcr_zika == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_zika == "Descartado" OR $conclusion_pcr_zika == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_zika == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_zika" id="conclusion_serologia_zika" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_zika == "Confirmado" OR $conclusion_serologia_zika == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_zika == "Descartado" OR $conclusion_serologia_zika == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_zika == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_zika" id="conclusion_otro_zika" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_zika == "Confirmado" OR $conclusion_otro_zika == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_zika == "Descartado" OR $conclusion_otro_zika == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_zika == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fiebre Amarilla</td>
                                            <td>
                                                <select name="conclusion_pcr_fiebre_amarilla" id="conclusion_pcr_fiebre_amarilla" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_fiebre_amarilla == "Confirmado" OR $conclusion_pcr_fiebre_amarilla == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_fiebre_amarilla == "Descartado" OR $conclusion_pcr_fiebre_amarilla == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_fiebre_amarilla == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_fiebre_amarilla" id="conclusion_serologia_fiebre_amarilla" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_fiebre_amarilla == "Confirmado" OR $conclusion_serologia_fiebre_amarilla == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_fiebre_amarilla == "Descartado" OR $conclusion_serologia_fiebre_amarilla == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_fiebre_amarilla == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_fiebre_amarilla" id="conclusion_otro_fiebre_amarilla" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_fiebre_amarilla == "Confirmado" OR $conclusion_otro_fiebre_amarilla == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_fiebre_amarilla == "Descartado" OR $conclusion_otro_fiebre_amarilla == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_fiebre_amarilla == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>V. del Nilo Occidental</td>
                                            <td>
                                                <select name="conclusion_pcr_virus_del_nilo" id="conclusion_pcr_virus_del_nilo" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_virus_del_nilo == "Confirmado" OR $conclusion_pcr_virus_del_nilo == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_virus_del_nilo == "Descartado" OR $conclusion_pcr_virus_del_nilo == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_virus_del_nilo == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_virus_del_nilo" id="conclusion_serologia_virus_del_nilo" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_virus_del_nilo == "Confirmado" OR $conclusion_serologia_virus_del_nilo == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_virus_del_nilo == "Descartado" OR $conclusion_serologia_virus_del_nilo == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_virus_del_nilo == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_virus_del_nilo" id="conclusion_otro_virus_del_nilo" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_virus_del_nilo == "Confirmado" OR $conclusion_otro_virus_del_nilo == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_virus_del_nilo == "Descartado" OR $conclusion_otro_virus_del_nilo == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_virus_del_nilo == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Malaria</td>
                                            <td>
                                                <select name="conclusion_pcr_malaria" id="conclusion_pcr_malaria" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_pcr_malaria == "Confirmado" OR $conclusion_pcr_malaria == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_pcr_malaria == "Descartado" OR $conclusion_pcr_malaria == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_pcr_malaria == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_serologia_malaria" id="conclusion_serologia_malaria" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_serologia_malaria == "Confirmado" OR $conclusion_serologia_malaria == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_serologia_malaria == "Descartado" OR $conclusion_serologia_malaria == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_serologia_malaria == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="conclusion_otro_malaria" id="conclusion_otro_malaria" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Positivo" <?php if($conclusion_otro_malaria == "Confirmado" OR $conclusion_otro_malaria == "Positivo") echo "selected" ?>> Positivo </option>
                                                    <option value="Negativo" <?php if($conclusion_otro_malaria == "Descartado" OR $conclusion_otro_malaria == "Negativo") echo "selected" ?>> Negativo </option>
                                                    <option value="No concluyente" <?php if($conclusion_otro_malaria == "No concluyente") echo "selected" ?>> No concluyente </option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-3">
                                 <div class="tile blue <?php if(!puedeFinalizarEmergencia("casos_febriles")) echo "hidden"; ?>" style="overflow: visible">
                                    <div class="form-group clearfix">
                                       <label for="conclusion_del_caso" class="control-label">Conclusión del caso:</label>
                                       <select name="conclusion_del_caso" id="conclusion_del_caso" class="form-control">
                                           <option value=""></option>
                                           <option value="1" <?php if($conclusion_del_caso == "1") echo "selected" ?>> Confirmado </option>
                                           <option value="2" <?php if($conclusion_del_caso == "2") echo "selected" ?>> Descartado </option>
                                           <option value="3" <?php if($conclusion_del_caso == "3") echo "selected" ?>> No concluyente </option>
                                       </select>
                                       <span class="help-block hidden"></span>
                                   </div>
                                   <div class="form-group clearfix">
                                       <label for="enfermedades" class="control-label">Enfermedades:</label>
                                       <?php echo formSelectEnfermedades("enfermedades[]", $conclusion_enfermedades); ?>
                                       <span class="help-block hidden"></span>
                                   </div>  
                                   <div class="form-group clearfix">
                                       <label for="observaciones" class="control-label">Observaciones:</label>
                                       <textarea name="observaciones" id="observaciones" class="form-control"><?php echo $observaciones; ?></textarea>
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
                <legend> Antecedentes epidemiológicos </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="viaje_fuera_de_isla_de_pascua" type="hidden" value="No" />
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
                        <hr>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="viaje_reciente_al_extranjero" type="hidden" value="No" />
                                            <input id="viaje_reciente_al_extranjero" name="viaje_reciente_al_extranjero" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $viaje_reciente_al_extrangero); ?>> Viaje reciente al extranjero
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
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="lugar_de_residencia_hace_30_dias" class="control-label">Lugar de residencia los 30 días anteriores al inicio de los síntomas:</label>
                                    <input value="<?php echo $lugar_de_residencia_hace_30_dias; ?>" class="form-control" name="lugar_de_residencia_hace_30_dias" id="lugar_de_residencia_hace_30_dias">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="antecedentes_de_dengue_previo" type="hidden" value="No" />
                                            <input id="antecedentes_de_dengue_previo" name="antecedentes_de_dengue_previo" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $antecedentes_de_dengue_previo); ?>> Antecedentes de dengue previo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="antecedentes_de_dengue_previo_fecha" class="control-label">Fecha:</label>
                                    <input value="<?php echo $antecedentes_de_dengue_previo_fecha; ?>" class="form-control" name="antecedentes_de_dengue_previo_fecha" id="antecedentes_de_dengue_previo_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="caso_febril_grupo_familiar" type="hidden" value="No" />
                                            <input id="caso_febril_grupo_familiar" name="caso_febril_grupo_familiar" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $caso_febril_grupo_familiar); ?>> Caso febril actual en el grupo familiar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="vacunacion_contra_fiebre_amarilla" type="hidden" value="No" />
                                            <input id="vacunacion_contra_fiebre_amarilla" name="vacunacion_contra_fiebre_amarilla" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $vacunacion_contra_fiebre_amarilla); ?>> Vacunación contra fiebre amarilla
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                 
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
                        <?php if(!puedeFinalizarEmergencia("casos_febriles")) { ?>
                        <button id="enviar" class="btn btn-blue" type="button"><i class="fa fa-send"></i> Guardar y enviar a delegado de epidemiología</button>
                        <?php } ?>
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("formulario/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
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
<?= loadJS("assets/js/form-dengue.js") ?>