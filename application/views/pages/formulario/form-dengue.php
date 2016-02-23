<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de vigilancia de casos febriles/exantemáticos ISLA DE PASCUA </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("formulario/index") ?>"> Casos febriles</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
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
            
            
            <form id="form-dengue" class="form-vertical" action="<?php echo base_url("formulario/guardar_dengue") ?>" method="post" role="form">
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
                                <div class="col-xs-2">
                                    <div class="form-group clearfix">
                                        <label for="sexo" class="control-label">Sexo(*):</label>
                                        <select name="sexo" id="sexo" class="form-control">
                                            <option value=""></option>
                                            <option value="Masculino" <?php if($sexo == "Masculino") echo "selected" ?>> Masculino </option>
                                            <option value="Femenino" <?php if($sexo == "Femenino") echo "selected" ?>> Femenino </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
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
                            <div class="row">
                                
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Teléfono(s) de contacto:</label>
                                        <input value="<?php echo $telefono; ?>" class="form-control" name="telefono" id="telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento(*):</label>
                                        <input value="<?php echo $fecha_nacimiento; ?>" class="form-control" name="fecha_de_nacimiento" id="fecha_de_nacimiento">
                                        
                                        <span class="help-block">Formato: dd/mm/aaaa</span>
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
                                        <label for="ocupacion" class="control-label">Ocupación(*):</label>
                                        <input value="<?php echo $ocupacion; ?>" class="form-control" name="ocupacion" id="ocupacion">
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
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_consulta" class="control-label">Fecha consulta(*):</label>
                                    <input value="<?php echo $fecha_consulta; ?>" class="form-control datepicker-date" name="fecha_de_consulta" id="fecha_consulta">
                                    <span class="help-block">Formato: dd/mm/aaaa</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="fecha_de_inicio_de_sintomas" class="control-label">Fecha de inicio de síntomas (fiebre o exantema) (*):</label>
                                    <input value="<?php echo $fecha_de_inicio_de_sintomas; ?>" class="form-control datepicker-date" name="fecha_de_inicio_de_sintomas" id="fecha_de_inicio_de_sintomas">
                                    <span class="help-block">Formato: dd/mm/aaaa</span>
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
                                            <input name="hospitalizacion" type="hidden" value="No" />
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
                                            <input name="fallecido" type="hidden" value="No" />
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
                        
                        
                        <legend> <small>Signos clínicos</small> </legend>
      
                        <div class="tile gray">
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
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            
                                            <input id="mialgia_artralgia" name="mialgia_artralgia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $mialgia_artralgia); ?>> Mialgia / Artralgia
                                            <input name="mialgia_artralgia" type="hidden" value="No" />
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
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="convulsiones_generalizadas" type="hidden" value="No" />
                                            <input id="convulsiones_generalizadas" name="convulsiones_generalizadas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $convulsiones_generalizadas); ?>> Convulsiones generalizadas
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
                                    <div class="checkbox">
                                        <label>
                                            <input name="compromiso_de_conciencia" type="hidden" value="No" />
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
                                            <input name="manifestaciones_hemorragicas" type="hidden" value="No" />
                                            <input id="manifestaciones_hemorragicas" name="manifestaciones_hemorragicas" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $manifestaciones_hemorragicas); ?>> Manifestaciones hemorragicas
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="petequias" type="hidden" value="No" />
                                            <input id="petequias" name="petequias" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $petequias); ?>> Petequias
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
                                            <input name="sintomas_respiratorios" type="hidden" value="No" />
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
                                            <input name="compromiso_renal" type="hidden" value="No" />
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
                        <legend> <small> Resultados test rápidos </small> </legend>
                        <div class="row">
                            <div class="col-xs-3">
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
                            <div class="col-xs-3">
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
                            <div class="col-xs-3">
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
                            <div class="col-xs-3">
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
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="diagnostico_clinico" class="control-label">Diagnóstico clínico:</label>
                                    <input value="<?php echo $diagnostico_clinico; ?>" class="form-control" name="diagnostico_clinico" id="diagnostico_clinico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="nombre_medico" class="control-label">Nombre médico:</label>
                                    <input value="<?php echo $nombre_medico; ?>" class="form-control" name="nombre_medico" id="nombre_medico">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 top-spaced">
                <legend> Examen de laboratorio </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible;">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="fecha_toma_de_pcr" class="control-label">Fecha de toma de PCR:</label>
                                    <input value="<?php echo $fecha_toma_de_pcr; ?>" class="form-control datepicker-date" name="fecha_toma_de_pcr" id="fecha_toma_de_pcr">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group top-spaced">
                                    <div class="checkbox">
                                        <label>
                                            <input name="rechaza_toma_muestra_pcr" type="hidden" value="No" />
                                            <input id="rechaza_toma_muestra_pcr" name="rechaza_toma_muestra_pcr" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $rechaza_toma_muestra_pcr); ?>> Rechaza toma muestra
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <label for="fecha_toma_de_sevologia" class="control-label">Fecha de toma de serología:</label>
                                    <input value="<?php echo $fecha_toma_de_sevologia; ?>" class="form-control datepicker-date" name="fecha_toma_de_sevologia" id="fecha_toma_de_sevologia">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group clearfix top-spaced">
                                    <div class="checkbox">
                                        <label>
                                            <input name="rechaza_toma_muestra_serologia" type="hidden" value="No" />
                                            <input id="rechaza_toma_muestra_serologia" name="rechaza_toma_muestra_serologia" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $rechaza_toma_muestra_serologia); ?>> Rechaza toma muestra
                                        </label>
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
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="vive_en_isla" type="hidden" value="No" />
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
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="lugar_de_residencia_hace_30_dias" class="control-label">Lugar de residencia los 30 días anteriores al inicio de los síntomas:</label>
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
                                            <input name="antecedentes_de_dengue_previo" type="hidden" value="No" />
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
                                            <input name="caso_febril_grupo_familiar" type="hidden" value="No" />
                                            <input id="caso_febril_grupo_familiar" name="caso_febril_grupo_familiar" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $caso_febril_grupo_familiar); ?>> Caso febril actual en el grupo familiar
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <div class="checkbox">
                                        <label>
                                            <input name="vacunacion_contra_fiebre_amarilla" type="hidden" value="No" />
                                            <input id="vacunacion_contra_fiebre_amarilla" name="vacunacion_contra_fiebre_amarilla" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $vacunacion_contra_fiebre_amarilla); ?>> Vacunación contra fiebre amarilla
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group clearfix">
                                    <label for="vacunacion_contra_fiebre_amarilla_fecha" class="control-label">Fecha vacunación:</label>
                                    <input value="<?php echo $vacunacion_contra_fiebre_amarilla_fecha; ?>" class="form-control datepicker-date" name="vacunacion_contra_fiebre_amarilla_fecha" id="vacunacion_contra_fiebre_amarilla_fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                            
            <div class="row">
                <div class="col-md-12 text-left">
                    <div id="form_error" class="alert alert-danger hidden">
                        <strong> Existen problemas con los datos ingresados </strong> <br>
                        Revise y corrija los campos iluminados en rojo.
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
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("formulario/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>

<?= loadJS("assets/js/modulo/mapa/formulario.js") ?>
<?= loadJS("assets/js/form-dengue.js") ?>