<style>    
    body{
        font-family: calibri;
        font-size: 12px;
    }
    table{
        width: 100%;

    }
    td, th{
       /*border: 1px solid black;*/
        /* background-color: #CFC378;*/
        font-weight: normal;
        text-align: left;
        padding : 0px;


    }
    .tabla_detalle td, .tabla_detalle th, .tabla_cabecera td{
        border: 1px solid black;
        border-spacing: 0;
        border-collapse: collapse;
        padding:5px;
    }

    .tabla_cabecera td{
        padding:0px !important;
        border-spacing: 0;
        border-collapse: collapse;
    }
    #texto_cabecera{
        font-size: 16px;
    }
    .tabla_border, .tabla_border>tr>td{
                border-spacing: 0;
        border-collapse: collapse;
        border: 1px solid black;
    }
    .tabla_border>td{padding:5px;}
    
    .descripcion{
        color: gray;
    }
</style>

<table  cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding:0px !important; width: 140px;">
            <img src="var:imagen_logo" width="140px"/>
        </td>
        <td valign="top" align="center" style="text-align: center;" >
            <table width="100%">
                <tr>
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;padding:0px !important">
                        FICHA DE VIGILANCIA FEBRILES
                    </td>
                </tr>
            </table>
            <br>
            <table width="70%">
                <tr>
                    <td width="40%" align="right"><strong>Seremi región</strong></td>
                    <td>: Valparaíso</td>  
                </tr>
                <tr>
                    <td width="40%" align="right"><strong>Servicio de salud</strong></td>
                    <td>: Metropolitano oriente</td>  
                </tr>
                <tr>
                    <td width="40%" align="right"><strong>Of. provincial</strong></td>
                    <td>: Isla de Pascua</td>  
                </tr>
                <tr>
                    <td width="40%" align="right"><strong>Establecimiento</strong></td>
                    <td>: Hospital Hanga Roa</td>  
                </tr>
            </table>
            
        </td>
    </tr>
</table>

<br/>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            1.- Identificación del caso
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <?php if(puedeVerFormularioDatosPersonales("casos_febriles")) { ?>
    <tr>
        <td width="30%">
            Nombres 
        </td>
        <td>
            : <?php echo $nombre; ?>
        </td>
    </tr>
    <tr>
        <td>
            Apellidos
        </td>
        <td>
            : <?php echo $apellido; ?>
        </td>
    </tr>
    <tr>
        <td>
            Run
        </td>
        <td>
            : <?php echo $run; ?>
        </td>
    </tr>
    <tr>
        <td>
            N° Pasaporte
        </td>
        <td>
            : <?php echo $numero_pasaporte; ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td>
            Sexo
        </td>
        <td>
            : <?php echo $sexo; ?>
        </td>
    </tr>
    <tr>
        <td>
            Fecha de nacimiento
        </td>
        <td>
            : <?php echo $fecha_de_nacimiento; ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            Dirección de residencia/trabajo o de estadía en Isla de Pascua
        </td>
        <td valign="top">
            : <?php echo $direccion; ?>
        </td>
    </tr>
    <tr>
        <td>
            Origen
        </td>
        <td>
            : <?php echo $origen; ?>
        </td>
    </tr>
    <?php if(puedeVerFormularioDatosPersonales("casos_febriles")) { ?>
    <tr>
        <td>
            Teléfono(s) de contacto:
        </td>
        <td>
            : <?php echo $telefono; ?>
        </td>
    </tr>
    <?php } ?>
</table>
<br/>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            2.- Información clínica 
        </td>
    </tr>
</table>
<br/>

<table width="100%">
    <tr>
        <td width="30%">
            Fecha consulta 
        </td>
        <td colspan="3">
            : <?php echo $fecha_de_consulta; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
           Fecha de inicio de síntomas (fiebre o exantema) 
        </td>
        <td valign="top">
            : <?php echo $fecha_de_inicio_de_sintomas; ?>
        </td>
        <td width="20%" valign="top">
            T° Axilar al momento de la consulta
        </td>
        <td valign="top">
            : <?php echo $temperatura_axilar; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Hospitalización
        </td>
        <td valign="top">
            : <?php echo $hospitalizacion; ?>
        </td>
        <td width="20%" valign="top">
            Fecha hospitalización
        </td>
        <td valign="top">
            : <?php echo $fecha_hospitalizacion; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Fallecido
        </td>
        <td valign="top">
            : <?php echo $fallecido; ?>
        </td>
        <td width="20%" valign="top">
            Fecha fallecimiento
        </td>
        <td valign="top">
            : <?php echo $fecha_fallecimiento; ?>
        </td>
    </tr>
</table>
<br>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            3.- Signos clínicos
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="30%">
            Fiebre
        </td>
        <td>
            :<?php echo $fiebre; ?>
        </td>
        <td width="30%">
            Exantema generalizado
        </td>
        <td>
            :<?php echo $exantema_generalizado; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Calofríos
        </td>
        <td>
            :<?php echo $calofrios; ?>
        </td>
    
        <td width="30%" valign="top">
            Sudoración
        </td>
        <td valign="top">
            :<?php echo $sudoracion; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Cefalea / Dolor retroorbitario
        </td>
        <td valign="top">
            :<?php echo $cefalea_dolor_retroorbitario; ?>
        </td>
        <td width="30%" valign="top">
            Tos
        </td>
        <td valign="top">
            :<?php echo $tos; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Coriza
        </td>
        <td valign="top">
            :<?php echo $coriza; ?>
        </td>
        <td width="30%" valign="top">
            Mialgia 
        </td>
        <td valign="top">
            :<?php echo $mialgia; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Artralgia
        </td>
        <td valign="top">
            :<?php echo $artralgia; ?>
        </td>

        <td width="30%" valign="top">
            Conjuntivitis
        </td>
        <td valign="top">
            :<?php echo $conjuntivitis; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Náuseas / Vómito
        </td>
        <td valign="top">
            :<?php echo $nauseas_vomito; ?>
        </td>
        <td width="30%" valign="top">
            Diarrea
        </td>
        <td valign="top">
            :<?php echo $diarrea; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Edema de articulación de manos/pies
        </td>
        <td valign="top">
            :<?php echo $edema_de_articulacion_manos_y_pies; ?>
        </td>
        <td width="30%" valign="top">
            Ictericia
        </td>
        <td valign="top">
            :<?php echo $ictericia; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Torniquete (+)
        </td>
        <td valign="top">
            :<?php echo $torniquete; ?>
        </td>

        <td width="30%" valign="top">
           Leucopenia
        </td>
        <td valign="top">
            :<?php echo $leucopenia; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Acumulación extravascular de fluidos
        </td>
        <td valign="top">
            :<?php echo $acumulacion_extravascular_de_fluidos; ?>
        </td>
        <td width="30%" valign="top">
            Dolor/sensibilidad abdominal
        </td>
        <td valign="top">
            :<?php echo $dolor_o_sensibilidad_abdominal; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Sangramiento de mucosas
        </td>
        <td valign="top">
            :<?php echo $sangramiento_de_mucosas; ?>
        </td>
        <td width="30%" valign="top">
            Hepatomegalia > 2cm
        </td>
        <td valign="top">
            :<?php echo $hepatomegalia_2cm; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Aumento hematocrito
        </td>
        <td valign="top">
            :<?php echo $aumento_hematocrito; ?>
        </td>
        <td width="30%" valign="top">
            Disminución de plaquetas
        </td>
        <td valign="top">
            :<?php echo $disminucion_de_plaquetas; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            SDRA
        </td>
        <td valign="top">
            :<?php echo $sdra; ?>
        </td>
        <td width="30%" valign="top">
            Shock
        </td>
        <td valign="top">
            :<?php echo $shock; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Sangramiento severo
        </td>
        <td valign="top">
            :<?php echo $sangramiento_severo; ?>
        </td>
        <td width="30%" valign="top">
            Compromiso severo de órganos
        </td>
        <td valign="top">
            :<?php echo $compromiso_severo_de_organos; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Meningitis/encefalitis
        </td>
        <td valign="top">
            :<?php echo $meningitis_encefalitis; ?>
        </td>
        <td width="30%" valign="top">
             Parálisis fláccida aguda/Sind. Guillain-Barré
        </td>
        <td valign="top">
            :<?php echo $paralisis_flaccida_aguda; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Vértigo
        </td>
        <td valign="top">
            :<?php echo $vertigo; ?>
        </td>
        <td width="30%" valign="top">
             Paresia
        </td>
        <td valign="top">
            :<?php echo $paresia; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Rigidez de nuca
        </td>
        <td valign="top">
            :<?php echo $rigidez_de_nuca; ?>
        </td>
        <td width="30%" valign="top">
             Albuminuria
        </td>
        <td valign="top">
            :<?php echo $albuminuria; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Anemia severa
        </td>
        <td valign="top">
            :<?php echo $anemia_severa; ?>
        </td>
        <td width="30%" valign="top">
             Dificultad respiratoria
        </td>
        <td valign="top">
            :<?php echo $dificultad_respiratoria; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Otros
        </td>
        <td valign="top">
            : <strong><?php echo $otros; ?></strong>
        </td>
        <td width="30%" valign="top">
             
        </td>
       <td valign="top">
        </td>
    </tr>
</table>

<br>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            4.-  Resultados test rápidos
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="30%">
            Influenza 
        </td>
        <td>
            : <strong><?php echo $influenza; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Adenovirus
        </td>
        <td>
            : <strong><?php echo $adenovirus; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="30%">
            VRS
        </td>
        <td>
            : <strong><?php echo $vrs; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Rotavirus
        </td>
        <td>
            : <strong><?php echo $rotavirus; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Dengue local
        </td>
        <td>
            : <strong><?php echo $dengue_local; ?></strong>
        </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr>
        <td width="30%">
            Diagnóstico clínico
        </td>
        <td>
            : <strong><?php echo $diagnostico_clinico; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Nombre médico
        </td>
        <td>
            : <strong><?php echo nombreUsuario($id_usuario); ?></strong>
        </td>
    </tr>
</table>
<br>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            5.-  Laboratorio
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <thead>
    <tr>
        <th align="center" width="15%">
            TIPO DE MUESTRA
        </th>
        <th align="center" width="15%">
            Sangre
        </th>
        <th align="center"  width="15%">
            Orina
        </th>
        <th align="center" width="15%">
            LCE
        </th>
        <th align="center" width="20%">
            Fecha de toma
        </th>
        <th align="center" width="20%">
            Rechaza toma de muestra
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>Muestra PCR</td>
            <td align="center"><?php echo $muestra_pcr_sangre; ?></td>
            <td align="center"><?php echo $muestra_pcr_orina; ?></td>
            <td align="center"><?php echo $muestra_pcr_lce; ?></td>
            <td align="center"><?php echo $muestra_pcr_fecha ?></td>
            <td align="center"><?php echo $muestra_pcr_rechaza_toma; ?></td>
        </tr>
        <tr>
            <td>Muestra serología</td>
            <td align="center"><?php echo $muestra_serologia_sangre; ?></td>
            <td align="center"><?php echo $muestra_serologia_orina; ?></td>
            <td align="center"><?php echo $muestra_serologia_lce; ?></td>
            <td align="center"><?php echo $muestra_serologia_fecha ?></td>
            <td align="center"><?php echo $muestra_serologia_rechaza_toma; ?></td>
        </tr>
        <tr>
            <td>Muestra frotis</td>
            <td align="center"><?php echo $muestra_frotis_sangre; ?></td>
            <td align="center"><?php echo $muestra_frotis_orina; ?></td>
            <td align="center"><?php echo $muestra_frotis_lce; ?></td>
            <td align="center"><?php echo $muestra_frotis_fecha ?></td>
            <td align="center"><?php echo $muestra_frotis_rechaza_toma; ?></td>
        </tr>
        <tr>
            <td>Otro: <?php echo $muestra_otro; ?></td>
            <td align="center"><?php echo $muestra_otro_sangre; ?></td>
            <td align="center"><?php echo $muestra_otro_orina; ?></td>
            <td align="center"><?php echo $muestra_otro_lce; ?></td>
            <td align="center"><?php echo $muestra_otro_fecha ?></td>
            <td align="center"><?php echo $muestra_otro_rechaza_toma; ?></td>
        </tr>
    </tbody>
</table>
<br>
<table width="100%">
    <thead>
    <tr>
        <th colspan="6" align="center" width="100%">
            Se solicitan análisis para:
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td align="center" width="15%">Dengue : <?php echo $se_solicita_analisis_para_dengue; ?></td>
            <td align="center" width="15%">Chikungunya : <?php echo $se_solicita_analisis_para_chikungunya; ?></td>
            <td align="center" width="15%">Zika : <?php echo $se_solicita_analisis_para_zika; ?></td>
            <td align="center" width="20%">Fiebre Amarilla : <?php echo $se_solicita_analisis_para_fiebre_amarilla; ?></td>
            <td align="center" width="20%">Virus del Nilo : <?php echo $se_solicita_analisis_para_virus_del_nilo_occidental; ?></td>
            <td align="center" width="15%">Malaria : <?php echo $se_solicita_analisis_para_malaria; ?></td>
        </tr>
    </tbody>
</table>
<br>
<table width="100%">
    <thead>
    <tr>
        <th colspan="4" align="center" width="100%">
            Resultados
        </th>
    </tr>
    <tr>
        <th width="10%"></th>
        <th align="center" width="20%">PCR</th>
        <th align="center" width="25%">Serología</th>
        <th align="center" width="25%">Otro</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td align="right">Dengue</td>
            <td align="center"><?php echo $conclusion_pcr_dengue; ?></td>
            <td align="center"><?php echo $conclusion_serologia_dengue; ?></td>
            <td align="center"><?php echo $conclusion_otro_dengue; ?></td>
        </tr>
        <tr>
            <td align="right">Chikungunya</td>
            <td align="center"><?php echo $conclusion_pcr_chikungunya; ?></td>
            <td align="center"><?php echo $conclusion_serologia_chikungunya; ?></td>
            <td align="center"><?php echo $conclusion_otro_chikungunya; ?></td>
        </tr>
        <tr>
            <td align="right">Zika</td>
            <td align="center"><?php echo $conclusion_pcr_zika; ?></td>
            <td align="center"><?php echo $conclusion_serologia_zika; ?></td>
            <td align="center"><?php echo $conclusion_otro_zika; ?></td>
        </tr>
        <tr>
            <td align="right">Fiebre Amarilla</td>
            <td align="center"><?php echo $conclusion_pcr_fiebre_amarilla; ?></td>
            <td align="center"><?php echo $conclusion_serologia_fiebre_amarilla; ?></td>
            <td align="center"><?php echo $conclusion_otro_fiebre_amarilla; ?></td>
        </tr>
        <tr>
            <td align="right">V. del Nilo Occidental</td>
            <td align="center"><?php echo $conclusion_pcr_virus_del_nilo; ?></td>
            <td align="center"><?php echo $conclusion_serologia_virus_del_nilo; ?></td>
            <td align="center"><?php echo $conclusion_otro_virus_del_nilo; ?></td>
        </tr>
        <tr>
            <td align="right">Malaria</td>
            <td align="center"><?php echo $conclusion_pcr_malaria; ?></td>
            <td align="center"><?php echo $conclusion_serologia_malaria; ?></td>
            <td align="center"><?php echo $conclusion_otro_malaria; ?></td>
        </tr>
    </tbody>
</table>
<br>
<table width="100%">
    <tr>
        <td width="30%">
            Conclusión del caso :
        </td>
        <td>
            : 
            <?php if($estado == ""){ ?>
            Caso sospechoso
            <?php }elseif($estado == 1) { ?>
            Confirmado
            <?php }elseif($estado == 2) { ?>
            Descartado
            <?php }elseif($estado == 3) { ?>
            No concluyente
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            Observaciones 
        </td>
        <td>
            : <?php echo $observaciones; ?>
        </td>
    </tr>
</table>
<br>
<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            6.-  Antecedentes epidemiológicos
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
    <tr>
        <td width="30%" rowspan="3" valign="top">
            Viaje fuera de Isla de Pascua
        </td>
        <td width="30%" rowspan="3" valign="top">
            : <strong><?php echo $viaje_fuera_de_isla_de_pascua; ?></strong>
        </td>
        <td width="20%" valign="top">
            Lugar
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_fuera_de_isla_de_pascua_lugar; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha salida
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_fuera_de_isla_de_pascua_fecha_salida; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha llegada
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_fuera_de_isla_de_pascua_fecha_llegada; ?></strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
        
    <tr>
        <td width="30%" rowspan="3" valign="top">
            Viaje reciente al extranjero
        </td>
        <td width="30%" rowspan="3" valign="top">
            : <strong><?php echo $viaje_reciente_al_extranjero; ?></strong>
        </td>
        <td width="20%" valign="top">
            País
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_reciente_al_extrangero_pais; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha salida
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_reciente_al_extrangero_fecha_salida; ?></strong>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha llegada
        </td>
        <td valign="top">
            : <strong><?php echo $viaje_reciente_al_extrangero_fecha_llegada; ?></strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td valign="top" colspan="2">
            Lugar de residencia los 30 días anteriores al inicio de los síntomas:
        </td>
        <td valign="top" colspan="2">
            : <strong><?php echo $lugar_de_residencia_hace_30_dias; ?></strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td width="30%"  valign="top">
            Antecedentes de dengue previo
        </td>
        <td width="30%"  valign="top">
            : <strong><?php echo $antecedentes_de_dengue_previo; ?></strong>
        </td>
        <td width="20%" valign="top">
            Fecha
        </td>
        <td valign="top">
            : <strong><?php echo $antecedentes_de_dengue_previo_fecha; ?></strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td valign="top" colspan="1">
            Caso febril actual en el grupo familiar
        </td>
        <td valign="top" colspan="3">
            : <strong><?php echo $caso_febril_grupo_familiar; ?></strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td width="30%" valign="top">
            Vacunación contra fiebre amarilla
        </td>
        <td width="30%" valign="top">
            : <strong><?php echo $vacunacion_contra_fiebre_amarilla; ?></strong>
        </td>
        <td width="20%" valign="top">
           
        </td>
        <td valign="top">

        </td>
    </tr>
</table>