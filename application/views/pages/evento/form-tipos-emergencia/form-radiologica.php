<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
<form  id="form-tipos-emergencia" name="form_tipos_emergencia" enctype="application/x-www-form-urlencoded" action="" method="post">
    
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <legend> Descripción </legend>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group clearfix">
                        <label for="form_tipo_descripcion" class="control-label">&nbsp;</label>
                        <textarea  class="form-control" name="form_tipo_descripcion" id="form_tipo_descripcion"><?php echo $form_tipo_descripcion; ?></textarea>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <legend> Material radioactivo <button type="button" class="btn btn-primary btn-sm pull-right" onclick="xModal.open('<?php echo site_url('evento/listaFuentesRadiologicas')?>','Listado Fuentes Radiológicas',75);">Listado de Fuentes Radiológicas <i class="ionicons ion-nuclear"></i></button></legend>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_fuente_radioactiva" class="control-label">Equipo y/o fuente radioactiva:</label>
                        <input  class="form-control" name="form_tipo_fuente_radioactiva" id="form_tipo_fuente_radioactiva" value="<?php echo $form_tipo_fuente_radioactiva; ?>" readonly />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_material_radioactivo" class="control-label">Actividad de material radioactivo:</label>
                        <input  class="form-control" name="form_tipo_material_radioactivo" id="form_tipo_material_radioactivo" value="<?php echo $form_tipo_material_radioactivo; ?>"  readonly/>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group clearfix">
                        <label for="form_tipo_material_marca" class="control-label">Marca:</label>
                        <input  class="form-control" name="form_tipo_material_marca" id="form_tipo_material_marcao" value="<?php echo $form_tipo_material_marca; ?>"  readonly/>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group clearfix">
                        <label for="form_tipo_material_modelo" class="control-label">Modelo:</label>
                        <input  class="form-control" name="form_tipo_material_modelo" id="form_tipo_material_modelo" value="<?php echo $form_tipo_material_modelo; ?>"  readonly/>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group clearfix">
                        <label for="form_tipo_material_serie" class="control-label">N° Serie:</label>
                        <input  class="form-control" name="form_tipo_material_serie" id="form_tipo_material_serie" value="<?php echo $form_tipo_material_serie; ?>"  readonly/>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group clearfix">
                        <label for="form_tipo_material_ano_fabricacion" class="control-label">Año fabricación:</label>
                        <input  class="form-control" name="form_tipo_material_ano_fabricacion" id="form_tipo_material_ano_fabricacion" value="<?php echo $form_tipo_material_ano_fabricacion; ?>" readonly/>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    <div class="row">
        <div class="col-lg-12">
            <legend> Lugar del incidente </legend>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group clearfix">
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="form_tipo_lugar" id="form_tipo_lugar_via_publica"  <?= formValueEmergenciaTipoChecked("via_publica", $form_tipo_lugar); ?> class="radio-lugar-incidente" data-toggle="div-lugar-via-publica"> Via pública
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group clearfix">
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="form_tipo_lugar" id="form_tipo_lugar_propiedad_privada" <?= formValueEmergenciaTipoChecked("propiedad_privada", $form_tipo_lugar); ?> class="radio-lugar-incidente" data-toggle="div-lugar-propiedad-privada"> Propiedad privada y/o pública
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div id="div-lugar-via-publica" class="hidden">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_via_publica_donde" class="control-label">Dónde:</label>
                            <input  class="form-control" name="form_tipo_lugar_via_publica_donde" id="form_tipo_lugar_via_publica_donde" value="<?php echo $form_tipo_lugar_via_publica_donde; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_via_publica_donde_detalle" id="form_tipo_lugar_via_publica_donde_detalle_calle" <?= formValueEmergenciaTipoChecked("calle", $form_tipo_lugar_via_publica_donde_detalle); ?>> Calle
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_via_publica_donde_detalle" id="form_tipo_lugar_via_publica_donde_detalle_sitio_eriazo" <?= formValueEmergenciaTipoChecked("sitio eriazo", $form_tipo_lugar_via_publica_donde_detalle); ?> > Sitio eriazo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_via_publica_donde_detalle" id="form_tipo_lugar_via_publica_donde_detalle_parque" <?= formValueEmergenciaTipoChecked("parque", $form_tipo_lugar_via_publica_donde_detalle); ?>> Parque
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_via_publica_donde_detalle" id="form_tipo_lugar_via_publica_donde_detalle_canal" <?= formValueEmergenciaTipoChecked("canal", $form_tipo_lugar_via_publica_donde_detalle); ?>> Canal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_via_publica_donde" class="control-label">Otro:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="form_tipo_lugar_via_publica_donde_detalle" id="form_tipo_lugar_via_publica_donde_detalle_otro" <?= formValueEmergenciaTipoChecked("otro", $form_tipo_lugar_via_publica_donde_detalle); ?>>
                                </span>
                                <input type="text" name="form_tipo_lugar_via_publica_donde_detalle_otro_detalle" id="form_tipo_lugar_via_publica_donde_detalle_otro_detalle" class="form-control" value="<?php echo $form_tipo_lugar_via_publica_donde_detalle_otro_detalle; ?>">
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
            <div id="div-lugar-propiedad-privada" class="hidden">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_propiedad_privada_direccion" class="control-label">Dirección:</label>
                            <input  class="form-control" name="form_tipo_lugar_propiedad_privada_direccion" id="form_tipo_lugar_propiedad_privada_direccion" value="<?php echo $form_tipo_lugar_propiedad_privada_direccion; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_propiedad_privada_comuna" class="control-label">Comuna:</label>
                            <input  class="form-control" name="form_tipo_lugar_propiedad_privada_comuna" id="form_tipo_lugar_propiedad_privada_comuna" value="<?php echo $form_tipo_lugar_propiedad_privada_comuna; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_propiedad_privada_ciudad" class="control-label">Localidad/Ciudad:</label>
                            <input  class="form-control" name="form_tipo_lugar_propiedad_privada_ciudad" id="form_tipo_lugar_propiedad_privada_ciudad" value="<?php echo $form_tipo_lugar_propiedad_privada_ciudad; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_hospital" <?= formValueEmergenciaTipoChecked("hospital", $form_tipo_lugar_propiedad_privada_tipo); ?>> Hospital
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_construccion" <?= formValueEmergenciaTipoChecked("propiedad_en_construccion", $form_tipo_lugar_propiedad_privada_tipo); ?>> Propiedad en construcción
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_relleno" <?= formValueEmergenciaTipoChecked("relleno_sanitario", $form_tipo_lugar_propiedad_privada_tipo); ?>> Relleno sanitario
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_deposito" <?= formValueEmergenciaTipoChecked("deposito_industrial", $form_tipo_lugar_propiedad_privada_tipo); ?>> Depósito industrial
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_industria" <?= formValueEmergenciaTipoChecked("industria", $form_tipo_lugar_propiedad_privada_tipo); ?>> Industria
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_bodega" <?= formValueEmergenciaTipoChecked("bodega", $form_tipo_lugar_propiedad_privada_tipo); ?>> Bodega
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_aduana" <?= formValueEmergenciaTipoChecked("recintos_aduaneros", $form_tipo_lugar_propiedad_privada_tipo); ?>> Recintos aduaneros
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label for="form_tipo_lugar_propiedad_privada_donde" class="control-label">Otro:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="form_tipo_lugar_propiedad_privada_tipo" id="form_tipo_lugar_propiedad_privada_tipo_otro" <?= formValueEmergenciaTipoChecked("otro", $form_tipo_lugar_propiedad_privada_tipo); ?>>
                                </span>
                                <input type="text" name="form_tipo_lugar_propiedad_privada_tipo_otro_detalle" id="form_tipo_lugar_propiedad_privada_tipo_otro_detalle" class="form-control" value="<?php echo $form_tipo_lugar_propiedad_privada_tipo_otro_detalle; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            
            <div class="row">
                <div class="col-lg-12">
                    <legend> Origen de la información </legend>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_informante" class="control-label">Persona que informa del evento:</label>
                        <input  class="form-control" name="form_tipo_origen_informante" id="form_tipo_origen_informante" value="<?php echo $form_tipo_origen_informante; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_institucion" class="control-label">Institución y/o empresa:</label>
                        <input  class="form-control" name="form_tipo_origen_institucion" id="form_tipo_origen_institucion" value="<?php echo $form_tipo_origen_institucion; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_direccion" class="control-label">Dirección:</label>
                        <input  class="form-control" name="form_tipo_origen_direccion" id="form_tipo_origen_direccion" value="<?php echo $form_tipo_origen_direccion; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_comuna" class="control-label">Comuna:</label>
                        <input  class="form-control" name="form_tipo_origen_comuna" id="form_tipo_origen_comuna" value="<?php echo $form_tipo_origen_comuna; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_telefono" class="control-label">Teléfono:</label>
                        <input  class="form-control" name="form_tipo_origen_telefono" id="form_tipo_origen_telefono" value="<?php echo $form_tipo_origen_telefono; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_email" class="control-label">Correo electrónico:</label>
                        <input  class="form-control" name="form_tipo_origen_email" id="form_tipo_origen_email" value="<?php echo $form_tipo_origen_email; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_fecha" class="control-label">Fecha:</label>
                        <input  class="form-control datepicker" name="form_tipo_origen_fecha" id="form_tipo_origen_fecha" value="<?php echo $form_tipo_origen_fecha; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_medio_comunicacion" class="control-label">Medio de comunicación:</label>
                        <input  class="form-control" name="form_tipo_origen_medio_comunicacion" id="form_tipo_origen_institucion" value="<?php echo $form_tipo_origen_medio_comunicacion; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group clearfix">
                        <label for="form_tipo_origen_recibe_alerta" class="control-label">Recibe alerta:</label>
                        <input  class="form-control" name="form_tipo_origen_recibe_alerta" id="form_tipo_origen_recibe_alerta" value="<?php echo $form_tipo_origen_recibe_alerta; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <legend> Investigador </legend>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_investigador_nombre" class="control-label">Nombre:</label>
                        <input  class="form-control" name="form_tipo_investigador_nombre" id="form_tipo_investigador_nombre" value="<?php if(empty($form_tipo_investigador_nombre)) echo $investigador['nombre']; else echo $form_tipo_investigador_nombre; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_investigador_funcion" class="control-label">Función o cargo:</label>
                        <input  class="form-control" name="form_tipo_investigador_funcion" id="form_tipo_investigador_funcion" value="<?php if(empty($form_tipo_investigador_funcion)) echo $investigador['cargo']; else echo $form_tipo_investigador_funcion; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_investigador_email" class="control-label">Correo electrónico:</label>
                        <input  class="form-control" name="form_tipo_investigador_email" id="form_tipo_investigador_email" value="<?php if(empty($form_tipo_investigador_email)) echo $investigador['email']; else echo $form_tipo_investigador_email; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_investigador_telefono" class="control-label">Teléfono:</label>
                        <input  class="form-control" name="form_tipo_investigador_telefono" id="form_tipo_investigador_telefono" value="<?php echo $form_tipo_investigador_telefono; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <legend> Otro contacto </legend>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_contacto_nombre" class="control-label">Nombre:</label>
                        <input  class="form-control" name="form_tipo_contacto_nombre" id="form_tipo_contacto_nombre" value="<?php echo $form_tipo_contacto_nombre; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_contacto_funcion" class="control-label">Función o cargo:</label>
                        <input  class="form-control" name="form_tipo_contacto_funcion" id="form_tipo_contacto_funcion" value="<?php echo $form_tipo_contacto_funcion; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_contacto_email" class="control-label">Correo electrónico:</label>
                        <input  class="form-control" name="form_tipo_contacto_email" id="form_tipo_contacto_email" value="<?php echo $form_tipo_contacto_email; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group clearfix">
                        <label for="form_tipo_contacto_telefono" class="control-label">Teléfono:</label>
                        <input  class="form-control" name="form_tipo_contacto_telefono" id="form_tipo_contacto_telefono" value="<?php echo $form_tipo_contacto_telefono; ?>" />
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <legend> Instituciones u organismos presentes </legend>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group clearfix">
                <label for="form_tipo_instuticiones" class="control-label">&nbsp;</label>
                <textarea  class="form-control" name="form_tipo_instuticiones" id="form_tipo_instuticiones"><?php echo $form_tipo_instuticiones; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <legend> Análisis preliminar del riesgo radiológico </legend>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_riesgo_potencial" class="control-label">a. Riesgo potencial</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_riesgo_potencial" id="form_tipo_riesgo_potencial_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_riesgo_potencial); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_riesgo_potencial" id="form_tipo_riesgo_potencial_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_riesgo_potencial); ?>> No
                    </label>
                </div>
            </div>
        </div>

        <div id="div-riesgo-potencial" class="hidden">
            <div class="col-lg-2">
                <div class="form-group clearfix">
                    <label for="form_tipo_riesgo_potencial_irradiacion_personas" class="control-label">Irradiación a personas</label>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_irradiacion_personas" id="form_tipo_riesgo_potencial_irradiacion_personas_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_riesgo_potencial_irradiacion_personas); ?>> Si
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_irradiacion_personas" id="form_tipo_riesgo_potencial_irradiacion_personas_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_riesgo_potencial_irradiacion_personas); ?>> No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group clearfix">
                    <label for="form_tipo_riesgo_potencial_contaminacion_personas" class="control-label">Contaminación a personas</label>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_contaminacion_personas" id="form_tipo_riesgo_potencial_contaminacion_personas_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_riesgo_potencial_contaminacion_personas); ?>> Si
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_contaminacion_personas" id="form_tipo_riesgo_potencial_contaminacion_personas_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_riesgo_potencial_contaminacion_personas); ?>> No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group clearfix">
                    <label for="form_tipo_riesgo_potencial_irradiacion_ambiental" class="control-label">Irradiación ambiental</label>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_irradiacion_ambiental" id="form_tipo_riesgo_potencial_irradiacion_ambiental_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_riesgo_potencial_irradiacion_ambiental); ?>> Si
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_irradiacion_ambiental" id="form_tipo_riesgo_potencial_irradiacion_ambiental_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_riesgo_potencial_irradiacion_ambiental); ?>> No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group clearfix">
                    <label for="form_tipo_riesgo_potencial_contaminacion_ambiental" class="control-label">Contaminación ambiental</label>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_contaminacion_ambiental" id="form_tipo_riesgo_potencial_contaminacion_ambiental_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_riesgo_potencial_contaminacion_ambiental); ?>> Si
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="form_tipo_riesgo_potencial_contaminacion_ambiental" id="form_tipo_riesgo_potencial_contaminacion_ambiental_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_riesgo_potencial_contaminacion_ambiental); ?>> No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_evaluacion_radiacion" class="control-label">b. Evaluación de la radiación</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_radiacion" id="form_tipo_evaluacion_radiacion_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_evaluacion_radiacion); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_radiacion" id="form_tipo_evaluacion_radiacion_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_evaluacion_radiacion); ?>> No
                    </label>
                </div>
            </div>
        </div>
        
        <div id="div-evaluacion-radiacion" class="hidden">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label for="form_tipo_riesgo_potencial_irradiacion_personas" class="control-label">Efectúa medición de radiación:</label>
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_evaluacion_radiacion_efectua_medicion" id="form_tipo_evaluacion_radiacion_efectua_medicion_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_evaluacion_radiacion_efectua_medicion); ?>> Si
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="form_tipo_evaluacion_radiacion_efectua_medicion" id="form_tipo_evaluacion_radiacion_efectua_medicion_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_evaluacion_radiacion_efectua_medicion); ?>> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_evaluacion_radiacion_instrumento" class="control-label">Instrumento:</label>
                            <input class="form-control" name="form_tipo_evaluacion_radiacion_instrumento" id="form_tipo_evaluacion_radiacion_instrumento" value="<?php echo $form_tipo_evaluacion_radiacion_instrumento; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group clearfix">
                            <label for="form_tipo_evaluacion_radiacion_unidad" class="control-label">Unidad:</label>
                            <input class="form-control" name="form_tipo_evaluacion_radiacion_unidad" id="form_tipo_evaluacion_radiacion_unidad" value="<?php echo $form_tipo_evaluacion_radiacion_unidad; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_evaluacion_radiacion_tasa" class="control-label">Tasa de dosis de radiación natural (fondo):</label>
                            <input class="form-control" name="form_tipo_evaluacion_radiacion_tasa" id="form_tipo_evaluacion_radiacion_tasa" value="<?php echo $form_tipo_evaluacion_radiacion_tasa; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group clearfix">
                            <label for="form_tipo_evaluacion_radiacion_distancia" class="control-label">Distancias de seguridad recomendadas:</label>
                            <input class="form-control" name="form_tipo_evaluacion_radiacion_distancia" id="form_tipo_evaluacion_radiacion_distancia" value="<?php echo $form_tipo_evaluacion_radiacion_distancia; ?>" />
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group clearfix">
                <label for="form_tipo_evaluacion_equipo" class="control-label">c. Evaluación equipo y/o fuente</label>
            </div>
        </div>
    </div>
    
     <div class="row">
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_evaluacion_equipo_aplica" class="control-label">Aplica</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_equipo_aplica" id="form_tipo_evaluacion_equipo_aplica_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_evaluacion_equipo_aplica); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_equipo_aplica" id="form_tipo_evaluacion_equipo_aplica_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_evaluacion_equipo_aplica); ?>> No
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_evaluacion_equipo_evidencia_dano" class="control-label">Evidencia daño</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_equipo_evidencia_dano" id="form_tipo_evaluacion_equipo_evidencia_dano_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_evaluacion_equipo_evidencia_dano); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_evaluacion_equipo_evidencia_dano" id="form_tipo_evaluacion_equipo_evidencia_dano_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_evaluacion_equipo_evidencia_dano); ?>> No
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_personas_expuestas" class="control-label">d. Trabajadores y personas expuestas</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_personas_expuestas" id="form_tipo_personas_expuestas_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_personas_expuestas); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_personas_expuestas" id="form_tipo_personas_expuestas_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_personas_expuestas); ?>> No
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_personas_expuestas" id="form_tipo_personas_expuestas_nc" <?= formValueEmergenciaTipoChecked("NC", $form_tipo_personas_expuestas); ?>> NC
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_personas_expuestas_indique" class="control-label">Indique personas expuestas:</label>
                <textarea  class="form-control" name="form_tipo_personas_expuestas_indique" id="form_tipo_personas_expuestas_indique"><?php echo $form_tipo_personas_expuestas_indique; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group clearfix">
                <label for="form_tipo_registros_fotograficos" class="control-label">e. Registros fotográficos</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_registros_fotograficos" id="form_tipo_registros_fotograficos_si" <?= formValueEmergenciaTipoChecked("Si", $form_tipo_registros_fotograficos); ?>> Si
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="form_tipo_registros_fotograficos" id="form_tipo_registros_fotograficos_no" <?= formValueEmergenciaTipoChecked("No", $form_tipo_registros_fotograficos); ?>> No
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <legend> Acciones tomadas </legend>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones_tomadas_resguardo_publico" class="control-label">Resguardo a público:</label>
                <textarea  class="form-control" name="form_tipo_acciones_tomadas_resguardo_publico" id="form_tipo_acciones_tomadas_resguardo_publico"><?php echo $form_tipo_acciones_tomadas_resguardo_publico; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones_tomadas_resguardo_trabajadores" class="control-label">Resguardo a trabajadores:</label>
                <textarea  class="form-control" name="form_tipo_acciones_tomadas_resguardo_trabajadores" id="form_tipo_acciones_tomadas_resguardo_trabajadores"><?php echo $form_tipo_acciones_tomadas_resguardo_trabajadores; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones_tomadas_control" class="control-label">Control de derrame y/o contaminación:</label>
                <textarea  class="form-control" name="form_tipo_acciones_tomadas_control" id="form_tipo_acciones_tomadas_control"><?php echo $form_tipo_acciones_tomadas_control; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones_tomadas_medidas_administrativas" class="control-label">Medidas administrativas:</label>
                <textarea  class="form-control" name="form_tipo_acciones_tomadas_medidas_administrativas" id="form_tipo_acciones_tomadas_medidas_administrativas"><?php echo $form_tipo_acciones_tomadas_medidas_administrativas; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones_tomadas_sumario_sanitario" class="control-label">Inicio Sumario Sanitario, materias:</label>
                <textarea  class="form-control" name="form_tipo_acciones_tomadas_sumario_sanitario" id="form_tipo_acciones_tomadas_sumario_sanitario"><?php echo $form_tipo_acciones_tomadas_sumario_sanitario; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
</form>

<?= loadJS("assets/js/modulo/evento/form/form-tipo-emergencia/radiologica.js") ?>