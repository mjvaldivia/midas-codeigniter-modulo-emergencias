<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Hospitales </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("hospital/index") ?>"> Hospitales</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                <li class="pull-right"><a href="<?php echo base_url("hospital/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
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
            
            
            <form id="form-hospital" autocomplete="off" class="form-vertical" action="<?php echo base_url("embarazo/guardar") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Identificación <div class="pull-right"><small>(*) Campos obligatorios</small></div>
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

                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="nombre" class="control-label">Nombre(*):</label>
                                            <input value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="direccion" class="control-label">Dirección (*):</label>
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
                <legend> SERVICIOS BÁSICOS CRÍTICOS </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4> AGUA </h4> 
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="agua_cuenta_con_agua" class="control-label">Cuenta con agua(*):</label>
                                            <select name="agua_cuenta_con_agua" id="agua_cuenta_con_agua" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($agua_cuenta_con_agua == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($agua_cuenta_con_agua == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($agua_cuenta_con_agua == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($agua_cuenta_con_agua == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($agua_cuenta_con_agua == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($agua_cuenta_con_agua == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="agua_fuente_abastecimiento_actual" class="control-label">Fuente de abastecimiento de Agua actual(*):</label>
                                            <input type="text" value="<?php echo $agua_fuente_abastecimiento_actual; ?>" class="form-control" name="agua_fuente_abastecimiento_actual" id="agua_fuente_abastecimiento_actual">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="agua_cuenta_con_estanque_de_reserva" type="hidden" value="No" />
                                                <input id="agua_cuenta_con_estanque_de_reserva" name="agua_cuenta_con_estanque_de_reserva" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $agua_cuenta_con_estanque_de_reserva); ?>> Cuenta con estanque de reserva operativo ?
                                            </label>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <h4> ELECTRICIDAD </h4> 
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="cuenta_con_electricidad" class="control-label">El centro cuenta con suministro eléctrico?(*):</label>
                                            <select name="cuenta_con_electricidad" id="cuenta_con_electricidad" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($cuenta_con_electricidad == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($cuenta_con_electricidad == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($cuenta_con_electricidad == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($cuenta_con_electricidad == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($cuenta_con_electricidad == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($cuenta_con_electricidad == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="electricidad_fuente_abastecimiento_actual" class="control-label">Fuente de suministro eléctrico actual(*):</label>
                                            <input type="text" value="<?php echo $electricidad_fuente_abastecimiento_actual; ?>" class="form-control" name="electricidad_fuente_abastecimiento_actual" id="electricidad_fuente_abastecimiento_actual">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="electricidad_cuenta_con_generador" class="control-label">Cuenta con generador operativo ? ? (*):</label>
                                            <input id="electricidad_cuenta_con_generador" name="electricidad_cuenta_con_generador" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $electricidad_cuenta_con_generador); ?>>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <h4> GASES MEDICINALES </h4> 
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="cuenta_con_oxigeno" class="control-label">Cuenta con Oxígeno?(*):</label>
                                            <select name="cuenta_con_oxigeno" id="cuenta_con_oxigeno" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($cuenta_con_oxigeno == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($cuenta_con_oxigeno == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($cuenta_con_oxigeno == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($cuenta_con_oxigeno == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($cuenta_con_oxigeno == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($cuenta_con_oxigeno == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group clearfix">
                                            <label for="autonomia_oxigeno" class="control-label">Autonomía Oxígeno(*):</label>
                                            <input type="text" value="<?php echo $autonomia_oxigeno; ?>" class="form-control" name="autonomia_oxigeno" id="autonomia_oxigeno">
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <h4> ALCANTARILLADO </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="alcantarillado_operativo" class="control-label">Alcantarillado Operativo?(*):</label>
                                            <select name="alcantarillado_operativo" id="alcantarillado_operativo" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($alcantarillado_operativo == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($alcantarillado_operativo == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($alcantarillado_operativo == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($alcantarillado_operativo == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($alcantarillado_operativo == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($alcantarillado_operativo == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <h4> BAÑOS PÚBLICOS </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="bano_publico_operativo" class="control-label">Baños  Operativos?(*):</label>
                                            <select name="bano_publico_operativo" id="bano_publico_operativo" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($bano_publico_operativo == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($bano_publico_operativo == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($bano_publico_operativo == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($bano_publico_operativo == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($bano_publico_operativo == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($bano_publico_operativo == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3">
                                <h4> BAÑOS PERSONAL </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="bano_personal_operativo" class="control-label">Baños  Operativos?(*):</label>
                                            <select name="bano_personal_operativo" id="bano_personal_operativo" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($bano_personal_operativo == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($bano_personal_operativo == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($bano_personal_operativo == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($bano_personal_operativo== "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($bano_personal_operativo == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($bano_personal_operativo == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <h4> ACCESO HOSPITAL </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="nivel_acceso_hospital" class="control-label">Nivel de Acceso?(*):</label>
                                            <select name="nivel_acceso_hospital" id="nivel_acceso_hospital" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($nivel_acceso_hospital == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($nivel_acceso_hospital == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($nivel_acceso_hospital == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($nivel_acceso_hospital == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($nivel_acceso_hospital == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($nivel_acceso_hospital == "No aplica") echo "selected" ?>> No aplica </option>
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
                <legend> SERVICIOS BÁSICOS SECUNDARIOS </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                            <div class="col-xs-3">
                                <h4> REAS </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="reas_operativo" class="control-label">Cuenta con REAS operativo?(*):</label>
                                            <select name="reas_operativo" id="reas_operativo" class="form-control">
                                                <option value=""></option>
                                                <option value="Sin servicio" <?php if($reas_operativo == "Sin servicio") echo "selected" ?>> Sin servicio </option>
                                                <option value="Sólo servicio de emergencia" <?php if($reas_operativo == "Sólo servicio de emergencia") echo "selected" ?>> Sólo servicio de emergencia </option>
                                                <option value="Servicio ilimitado" <?php if($reas_operativo == "Servicio ilimitado") echo "selected" ?>> Servicio ilimitado </option>
                                                <option value="Servicio reubicado" <?php if($reas_operativo == "Servicio reubicado") echo "selected" ?>> Servicio reubicado </option>
                                                <option value="Servicio normal" <?php if($reas_operativo == "Servicio normal") echo "selected" ?>> Servicio normal </option>
                                                <option value="No aplica" <?php if($reas_operativo == "No aplica") echo "selected" ?>> No aplica </option>
                                            </select>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <h4> CONECTIVIDAD CON RESTO DE LA RED </h4> 
                                <div class="row">
                                    <div class="col-xs-6">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="comunicacion_red_analoga" type="hidden" value="No" />
                                                <input id="comunicacion_red_analoga" name="comunicacion_red_analoga" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $comunicacion_red_analoga); ?>> Comunicación Red Análoga
                                            </label>
                                        </div>
                           
                                    </div>
                                    <div class="col-xs-6">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="comunicacion_celular" type="hidden" value="No" />
                                                <input id="comunicacion_celular" name="comunicacion_celular" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $comunicacion_celular); ?>> Comunicación Celular
                                            </label>
                                        </div>

                                    </div>
                                 </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="comunicacion_hf_vhf" type="hidden" value="No" />
                                                <input id="comunicacion_hf_vhf" name="comunicacion_hf_vhf" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $comunicacion_hf_vhf); ?>> Comunicación HF/VHF
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-xs-6">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="internet" type="hidden" value="No" />
                                                <input id="internet" name="internet" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $internet); ?>> Internet
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-3">
                                <h4> CALEFACCIÓN </h4> 
                                <div class="row">
                                    <div class="col-xs-12">
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input name="cuenta_con_calefaccion" type="hidden" value="No" />
                                                <input id="cuenta_con_calefaccion" name="cuenta_con_calefaccion" type="checkbox" <?= formValueEmergenciaTipoChecked("Si", $cuenta_con_calefaccion); ?>> El centro cuenta con Calefacción?
                                            </label>
                                        </div>
                           
                                    </div>
                                    
                                 </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 top-spaced">
                <legend> NIVELES DE SERVICIOS BÁSICOS CRITICOS  </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4> AGUA </h4> 
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="capacidad_estanque" class="control-label">Capacidad del Estanque Existente:</label>
                                            <input type="text" value="<?php echo $capacidad_estanque; ?>" class="form-control" name="capacidad_estanque" id="capacidad_estanque">
                                            <span class="help-block">(Litros)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="cantidad_agua_estanque" class="control-label">Cantidad de agua disponible en estanque existente:</label>
                                            <input type="text" value="<?php echo $cantidad_agua_estanque; ?>" class="form-control" name="cantidad_agua_estanque" id="cantidad_agua_estanque">
                                            <span class="help-block">(Litros)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="autonomia_agua" class="control-label">Autonomía para funcionar Agua:</label>
                                            <input type="text" value="<?php echo $autonomia_agua; ?>" class="form-control" name="autonomia_agua" id="autonomia_agua">
                                            <span class="help-block">(Horas)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="porcentaje_establecimiento_con_agua" class="control-label">Porcentaje establecimiento se encuentra con Agua:</label>
                                            <input type="text" value="<?php echo $porcentaje_establecimiento_con_agua; ?>" class="form-control" name="porcentaje_establecimiento_con_agua" id="porcentaje_establecimiento_con_agua">
                                            <span class="help-block">(%)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <h4> ELECTRICIDAD </h4> 
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="capacidad_estanque_combustible" class="control-label">Capacidad de estanque para combustible:</label>
                                            <input type="text" value="<?php echo $capacidad_estanque_combustible; ?>" class="form-control" name="capacidad_estanque_combustible" id="capacidad_estanque_combustible">
                                            <span class="help-block">(Litros)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="combustible_disponible" class="control-label">Combustible disponible en estanque:</label>
                                            <input type="text" value="<?php echo $combustible_disponible; ?>" class="form-control" name="combustible_disponible" id="combustible_disponible">
                                            <span class="help-block">(Litros)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="autonomia_electricidad" class="control-label">Autonomía para funcionar con generador:</label>
                                            <input type="text" value="<?php echo $autonomia_electricidad; ?>" class="form-control" name="autonomia_electricidad" id="autonomia_electricidad">
                                            <span class="help-block">(Horas)</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group clearfix">
                                            <label for="porcentaje_establecimiento_con_electricidad" class="control-label">Porcentaje establecimiento respalda el generador:</label>
                                            <input type="text" value="<?php echo $porcentaje_establecimiento_con_electricidad; ?>" class="form-control" name="porcentaje_establecimiento_con_electricidad" id="porcentaje_establecimiento_con_electricidad">
                                            <span class="help-block">(%)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 top-spaced">
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="necesidades_principales" class="control-label">Necesidades principales:</label>
                                    <textarea name="necesidades_principales" id="necesidades_principales" class="form-control"><?php echo $necesidades_principales; ?></textarea>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="observaciones_generales" class="control-label">Observaciones generales:</label>
                                    <textarea name="observaciones_generales" id="observaciones_generales" class="form-control"><?php echo $observaciones_generales; ?></textarea>
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="estado" class="control-label">Estado(*):</label>
                                    <select name="estado" id="estado" class="form-control">
                                        <option value=""></option>
                                        <option value="1" <?php if($estado == "1") echo "selected" ?>> Verde </option>
                                        <option value="2" <?php if($estado == "2") echo "selected" ?>> Amarillo </option>
                                        <option value="3" <?php if($estado == "3") echo "selected" ?>> Rojo </option>
                                    </select>
                                    <span class="help-block hidden"></span>
                                </div>
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
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("embarazo/index") ?>'"><i class="fa fa-ban"></i> Cancelar</button>
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
<?= loadJS("assets/js/modulo/hospital/form.js") ?>