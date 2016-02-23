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
    <tr>
        <td width="30%">
            Nombres 
        </td>
        <td>
            :<?php echo $nombre; ?>
        </td>
    </tr>
    <tr>
        <td>
            Apellidos
        </td>
        <td>
            :<?php echo $apellido; ?>
        </td>
    </tr>
    <tr>
        <td>
            Run
        </td>
        <td>
            :<?php echo $run; ?>
        </td>
    </tr>
    <tr>
        <td>
            N° Pasaporte
        </td>
        <td>
            :<?php echo $numero_pasaporte; ?>
        </td>
    </tr>
    <tr>
        <td>
            Sexo
        </td>
        <td>
            :<?php echo $sexo; ?>
        </td>
    </tr>
    <tr>
        <td>
            Fecha de nacimiento
        </td>
        <td>
            :<?php echo $fecha_de_nacimiento; ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            Dirección de residencia/trabajo o de estadía en Isla de Pascua
        </td>
        <td valign="top">
            :<?php echo $direccion; ?>
        </td>
    </tr>
    <tr>
        <td>
            Origen
        </td>
        <td>
            :<?php echo $origen; ?>
        </td>
    </tr>
    <tr>
        <td>
            Teléfono(s) de contacto:
        </td>
        <td>
            :<?php echo $telefono; ?>
        </td>
    </tr>
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
            :<?php echo $fecha_de_consulta; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
           Fecha de inicio de síntomas (fiebre o exantema) 
        </td>
        <td valign="top">
            :<?php echo $fecha_de_inicio_de_sintomas; ?>
        </td>
        <td width="20%" valign="top">
            T° Axilar al momento de la consulta
        </td>
        <td valign="top">
            :<?php echo $temperatura_axilar; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Hospitalización
        </td>
        <td valign="top">
            :<?php echo $hospitalizacion; ?>
        </td>
        <td width="20%" valign="top">
            Fecha hospitalización
        </td>
        <td valign="top">
            :<?php echo $fecha_hospitalizacion; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Fallecido
        </td>
        <td valign="top">
            :<?php echo $fallecido; ?>
        </td>
        <td width="20%" valign="top">
            Fecha fallecimiento
        </td>
        <td valign="top">
            :<?php echo $fecha_fallecimiento; ?>
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
            :<?php echo $otros; ?>
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
            :<?php echo $influenza; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Adenovirus
        </td>
        <td>
            :<?php echo $adenovirus; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            VRS
        </td>
        <td>
            :<?php echo $vrs; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Rotavirus
        </td>
        <td>
            :<?php echo $rotavirus; ?>
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
            :<?php echo $diagnostico_clinico; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Nombre médico
        </td>
        <td>
            :<?php echo $nombre_medico; ?>
        </td>
    </tr>
</table>
<br>

<table class="tabla" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size:14px;padding:0px !important" colspan="4">
            5.-  Examen de laboratorio
        </td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="30%">
            Fecha de toma de PCR
        </td>
        <td>
            :<?php echo $fecha_toma_de_pcr; ?>
        </td>
        <td width="30%">
            Rechaza toma muestra
        </td>
        <td>
            :<?php echo $rechaza_toma_muestra_pcr; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Fecha de toma de serología
        </td>
        <td>
            :<?php echo $fecha_toma_de_sevologia; ?>
        </td>
        <td width="30%">
            Rechaza toma muestra
        </td>
        <td>
            :<?php echo $rechaza_toma_muestra_serologia; ?>
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
        <td width="30%">
            Vive en Isla de Pascua
        </td>
        <td colspan="3">
            :<?php echo $vive_en_isla; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" rowspan="3" valign="top">
            Viaje fuera de Isla de Pascua
        </td>
        <td width="30%" rowspan="3" valign="top">
            :<?php echo $viaje_fuera_de_isla_de_pascua; ?>
        </td>
        <td width="20%" valign="top">
            Lugar
        </td>
        <td valign="top">
            :<?php echo $viaje_fuera_de_isla_de_pascua_lugar; ?>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha salida
        </td>
        <td valign="top">
            :<?php echo $viaje_fuera_de_isla_de_pascua_fecha_salida; ?>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha llegada
        </td>
        <td valign="top">
            :<?php echo $viaje_fuera_de_isla_de_pascua_fecha_llegada; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    
    <tr>
        <td width="30%" rowspan="3" valign="top">
            Viaje reciente al extranjero
        </td>
        <td width="30%" rowspan="3" valign="top">
            :<?php echo $viaje_reciente_al_extranjero; ?>
        </td>
        <td width="20%" valign="top">
            País
        </td>
        <td valign="top">
            :<?php echo $viaje_reciente_al_extrangero_pais; ?>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha salida
        </td>
        <td valign="top">
            :<?php echo $viaje_reciente_al_extrangero_fecha_salida; ?>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top">
            Fecha llegada
        </td>
        <td valign="top">
            :<?php echo $viaje_reciente_al_extrangero_fecha_llegada; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    
    <tr>
        <td valign="top" colspan="2">
            Lugar de residencia los 30 días anteriores al inicio de los síntomas:
        </td>
        <td valign="top" colspan="2">
            :<?php echo $lugar_de_residencia_hace_30_dias; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    
    <tr>
        <td width="30%"  valign="top">
            Antecedentes de dengue previo
        </td>
        <td width="30%"  valign="top">
            :<?php echo $antecedentes_de_dengue_previo; ?>
        </td>
        <td width="20%" valign="top">
            Fecha
        </td>
        <td valign="top">
            :<?php echo $antecedentes_de_dengue_previo_fecha; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    
    <tr>
        <td valign="top" colspan="2">
            Caso febril actual en el grupo familiar
        </td>
        <td valign="top" colspan="2">
            :<?php echo $caso_febril_grupo_familiar; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="4">
            &nbsp;
        </td>
    </tr>
    
    <tr>
        <td width="30%" valign="top">
            Vacunación contra fiebre amarilla
        </td>
        <td width="30%" valign="top">
            :<?php echo $vacunacion_contra_fiebre_amarilla; ?>
        </td>
        <td width="20%" valign="top">
            Fecha vacunación
        </td>
        <td valign="top">
            :<?php echo $vacunacion_contra_fiebre_amarilla_fecha; ?>
        </td>
    </tr>
</table>