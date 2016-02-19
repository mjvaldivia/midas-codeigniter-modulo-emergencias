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

<table class="tabla_cabecera" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding:0px !important; width: 140px;">
            <img src="var:imagen_logo" width="140px"/>
        </td>
        <td style="text-align: center;font-weight: bold;font-size:18px;padding:0px !important">FICHA DE VIGILANCIA FEBRILES</td>
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
            Rut
        </td>
        <td>
            :<?php echo $rut; ?>
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
            :<?php echo $sexo; ?>
        </td>
    </tr>
    <tr>
        <td>
            Dirección
        </td>
        <td>
            :<?php echo $direccion; ?>
        </td>
    </tr>
    <tr>
        <td>
            Ocupación
        </td>
        <td>
            :<?php echo $ocupacion; ?>
        </td>
    </tr>
    <tr>
        <td>
            Telefono
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
            2.- Cuadro clínico
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
            :<?php echo $fecha_consulta; ?>
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
            T° Axilar
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
            Calofríos
        </td>
    
        <td>
            :<?php echo $calofrios; ?>
        </td>
    </tr>
    <tr>
        <td width="30%">
            Sudoración
        </td>
        <td>
            :<?php echo $sudoracion; ?>
        </td>
    
        <td width="30%" valign="top">
            Cefalea / Dolor retroorbitario
        </td>
        <td valign="top">
            :<?php echo $cefalea_dolor_retroorbitario; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Mialgia / Artralgia
        </td>
        <td valign="top">
            :<?php echo $mialgia_artralgia; ?>
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
            Convulsiones generalizadas
        </td>
        <td valign="top">
            :<?php echo $convulsiones_generalizadas; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Dificultad respiratoria
        </td>
        <td valign="top">
            :<?php echo $dificultad_respiratoria; ?>
        </td>

        <td width="30%" valign="top">
            Compromiso de conciencia
        </td>
        <td valign="top">
            :<?php echo $compromiso_de_conciencia; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Manifestaciones hemorragicas
        </td>
        <td valign="top">
            :<?php echo $manifestaciones_hemorragicas; ?>
        </td>
        <td width="30%" valign="top">
            Petequias
        </td>
        <td valign="top">
            :<?php echo $petequias; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Exantema generalizado
        </td>
        <td valign="top">
            :<?php echo $exantema_generalizado; ?>
        </td>
        <td width="30%" valign="top">
            Sintomas respiratorios
        </td>
        <td valign="top">
            :<?php echo $sintomas_respiratorios; ?>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">
            Shock
        </td>
        <td valign="top">
            :<?php echo $shock; ?>
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
            Compromiso renal
        </td>
        <td valign="top">
            :<?php echo $compromiso_renal; ?>
        </td>
        <td width="30%" valign="top">
            Otros
        </td>
        <td valign="top">
            :<?php echo $otros; ?>
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