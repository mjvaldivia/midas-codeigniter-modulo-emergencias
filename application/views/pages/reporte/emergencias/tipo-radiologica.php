<table class="">
    <tr>
        <td width="40%">Descripción del evento:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= trim($form_tipo_descripcion) ?></div>
        </td>
    </tr>
</table>

<br>
Material radioactivo
<hr>
        
<table width="100%" class="">
    <tr>
        <td width="40%">Equipo y/o fuente radioactiva:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_fuente_radioactiva ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Actividad de material radioactivoa:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_material_radioactivo ?></div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="tabla_detalle tabla_border">
                <tr>
                    <td width="25%">Marca</td>
                    <td width="25%">Modelo</td>
                    <td width="25%">N° Serie</td>
                    <td width="25%">Año fabricación</td>
                </tr>
                <tr>
                    <td width="25%"><?= $form_tipo_material_marca; ?></td>
                    <td width="25%"><?= $form_tipo_material_modelo; ?></td>
                    <td width="25%"><?= $form_tipo_material_serie; ?></td>
                    <td width="25%"><?= $form_tipo_material_ano_fabricacion; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<span>Lugar del incidente: <div class="descripcion"><?= reporteNombreLugar($form_tipo_lugar) ?></div></span>
<hr>

<?php
if($form_tipo_lugar == "via_publica"){
?>
    <table width="100%" class="">
        <tr>
            <td width="40%">Tipo:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= reporteNombreLugarDetalle($form_tipo_lugar_via_publica_donde_detalle, $form_tipo_lugar_via_publica_donde_detalle_otro_detalle) ?></div>
            </td>
        </tr>
        <tr>
            <td width="40%">Dónde:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= $form_tipo_lugar_via_publica_donde ?></div>
            </td>
        </tr>

    </table>
<?php
} elseif($form_tipo_lugar == "propiedad_privada"){
?>
    <table width="100%" class="">
        <tr>
            <td width="40%">Dirección:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= $form_tipo_lugar_propiedad_privada_direccion ?></div>
            </td>
        </tr>
        <tr>
            <td width="40%">Comuna:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= $form_tipo_lugar_propiedad_privada_comuna ?></div>
            </td>
        </tr>
        <tr>
            <td width="40%">Localidad/Ciudad:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= $form_tipo_lugar_propiedad_privada_ciudad ?></div>
            </td>
        </tr>
        <tr>
            <td width="40%">Tipo:</td>
            <td width="60%" align="left">
                <div class="descripcion"><?= reporteNombreTipoPropiedadPrivada($form_tipo_lugar_propiedad_privada_tipo, $form_tipo_lugar_propiedad_privada_tipo_otro_detalle); ?></div>
            </td>
        </tr>
    </table>
<?php
}
?>

<br>
<span>Origen de la información</span>
<hr>

<table width="100%" class="">
    <tr>
        <td width="40%">Persona que informa del evento:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_informante ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Institución y/o empresa:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_institucion ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Dirección:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_direccion ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Comuna:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_comuna ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Teléfono:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_telefono ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Correo electrónico:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_email ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Fecha:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_fecha ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Medio de comunicación:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_medio_comunicacion ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Recibe alerta:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_origen_recibe_alerta ?></div>
        </td>
    </tr>
</table>

<br>
<span>Investigador</span>
<hr>

<table width="100%" class="">
    <tr>
        <td width="40%">Nombre:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_investigador_nombre ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Función o cargo:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_investigador_funcion ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Correo electrónico:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_investigador_email ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Teléfono:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_investigador_telefono ?></div>
        </td>
    </tr>
</table>

<br>
<span>Otro contacto</span>
<hr>

<table width="100%" class="">
    <tr>
        <td width="40%">Nombre:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_contacto_nombre ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Función o cargo:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_contacto_funcion ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Correo electrónico:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_contacto_email ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Teléfono:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_contacto_telefono ?></div>
        </td>
    </tr>
</table>

<br>
<span>Instituciones u organismos presentes</span>
<hr>

<div class="descripcion"><?= $form_tipo_instuticiones ?></div>

<br>
<span>Análisis preliminar del riesgo radiológico</span>
<hr>

<table width="100%" class="">
    <tr>
        <td width="40%">Riesgo potencial:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_riesgo_potencial ?></div>
        </td>
    </tr>
    <?php if($form_tipo_riesgo_potencial=="Si") { ?>
    <tr>
        <td colspan="2">
            <table width="100%" class="tabla_detalle tabla_border">
                <tr>
                    <td width="25%">Irradiación a personas</td>
                    <td width="25%">Contaminación a personas</td>
                    <td width="25%">Irradiación ambiental</td>
                    <td width="25%">Contaminación ambiental</td>
                </tr>
                <tr>
                    <td width="25%"><div class="descripcion"><?= $form_tipo_riesgo_potencial_irradiacion_personas ?></div></td>
                    <td width="25%"><div class="descripcion"><?= $form_tipo_riesgo_potencial_contaminacion_personas ?></div></td>
                    <td width="25%"><div class="descripcion"><?= $form_tipo_riesgo_potencial_irradiacion_ambiental ?></div></td>
                    <td width="25%"><div class="descripcion"><?= $form_tipo_riesgo_potencial_contaminacion_ambiental ?></div></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php } ?>
</table>

<table width="100%" class="">
    <tr>
        <td width="40%">Evaluación de la radiación:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_evaluacion_radiacion ?></div>
        </td>
    </tr>
    <?php if($form_tipo_evaluacion_radiacion=="Si") { ?>
    <tr>
        <td colspan="2">
            <table width="100%" class="tabla_detalle tabla_border">
                <tr>
                    <td width="30%">Efectúa medición de radiación</td>
                    <td width="35%">Instrumento</td>
                    <td width="35%">Unidad</td>
                </tr>
                <tr>
                    <td>
                        <div class="descripcion"><?= $form_tipo_evaluacion_radiacion_efectua_medicion ?></div>
                    </td>
                    <td>
                        <div class="descripcion"><?= $form_tipo_evaluacion_radiacion_instrumento ?></div>
                    </td>
                    <td>
                        <div class="descripcion"><?= $form_tipo_evaluacion_radiacion_unidad ?></div>
                    </td>
                </tr>
            </table>
            
            <br>
            
            <table width="100%" class="tabla_detalle tabla_border">
                <tr>
                    <td width="50%">Tasa de dosis de radiación natural (fondo)</td>
                    <td width="50%">Distancias de seguridad recomendadas</td>
                </tr>
                <tr>
                    <td>
                        <div class="descripcion"><?= $form_tipo_evaluacion_radiacion_tasa ?></div>
                    </td>
                    <td>
                        <div class="descripcion"><?= $form_tipo_evaluacion_radiacion_distancia ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php } ?>
</table>

<table width="100%" class="">
    <tr>
        <td width="40%">Evaluación equipo y/o fuente</td>
        <td width="60%" align="left"></td>
    </tr>
    <tr>
        <td width="40%">Aplica:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_evaluacion_equipo_aplica ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Evidencia daño:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_evaluacion_equipo_evidencia_dano ?></div>
        </td>
    </tr>
</table>

<table width="100%" class="">
    <tr>
        <td width="40%">Trabajadores y personas expuestas:</td>
        <td width="60%" align="left"><?= $form_tipo_personas_expuestas ?></td>
    </tr>
    <?php if($form_tipo_personas_expuestas == "Si") { ?>
    <tr>
        <td width="40%">Indique personas expuestas:</td>
        <td width="60%" align="left"><?= $form_tipo_personas_expuestas_indique ?></td>
    </tr>
    <?php } ?>
</table>

<table width="100%" class="">
    <tr>
        <td width="40%">Registros fotográficos:</td>
        <td width="60%" align="left"><?= $form_tipo_registros_fotograficos ?></td>
    </tr>
</table>

<br>
<span>Acciones tomadas</span>
<hr>

<table width="100%" class="">
    <tr>
        <td width="40%">Resguardo a público:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_acciones_tomadas_resguardo_publico ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Resguardo a trabajadores:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_acciones_tomadas_resguardo_trabajadores ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Control de derrame y/o contaminación:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_acciones_tomadas_control ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Medidas administrativas:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_acciones_tomadas_medidas_administrativas ?></div>
        </td>
    </tr>
    <tr>
        <td width="40%">Inicio Sumario Sanitario, materias:</td>
        <td width="60%" align="left">
            <div class="descripcion"><?= $form_tipo_acciones_tomadas_sumario_sanitario ?></div>
        </td>
    </tr>
</table>