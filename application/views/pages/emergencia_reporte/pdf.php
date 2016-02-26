<style>    
    body{
        font-family: calibri;
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
        <td style="padding:0px !important; width: 140px;" rowspan="3">
            <img src="var:imagen_logo" width="140px"/>
        </td>
        <td style="text-align: center;font-weight: bold;font-size:18px;padding:0px !important" colspan="2">MINUTA DE EMERGENCIA</td>
        <td style="text-align:center;">Minuta</td>
    </tr>
    <tr>
        <td style="text-align: center;font-size:16px" colspan="2"><span style="font-weight: bold">CONTENIDO</span><br/><?= $eme_c_nombre_emergencia ?></td>
        <td>Región<br/><?php echo $region?></td>
    </tr>
    <tr>
        <td style="text-align: center;font-size:14px"><span style="font-weight: bold">ELABORADOR POR:</span><br/><?= $emisor ?></td>
        <td>Cargo/Función</td>
        <td></td>
    </tr>

</table>
<br/>

<table class="tabla_detalle" cellpadding="1" cellspacing="0">
    <tr>
        <td>1.- TIPO DE EVENTO</td>
        <td colspan="4"><?php echo nombreEmergenciaTipo($tip_ia_id)?></td>
    </tr>
    <tr>
        <td>2.- OCURRENCIA</td>
        <td>DÍA</td>
        <td><?= $eme_d_fecha_emergencia ?></td>
        <td>HORA</td>
        <td><?= $hora_emergencia ?></td>
    </tr>
    <tr>
        <td colspan="5">3.- DIRECCIÓN/UBICACIÓN<br/>
            <?= $eme_c_lugar_emergencia?>, <?= comunasEmergenciaConComa($eme_ia_id); ?>
        </td>
    </tr>
    <tr>
        <td colspan="5">4.- ORIGEN DE INFORMACION:<br/>
            <?= $eme_c_nombre_informante;?>
        </td>
    </tr>
    <tr>
        <td colspan="5">5.- DISPONE DE RECURSOS SUFICIENTES PARA CONTROLAR LA EMERGENCIA:<br/>
        <?php echo $form_tipo_recursos?>
        </td>
    </tr>
    <tr>
        <td colspan="5">6.- IMPACTO A LAS PERSONAS:<br/>
            NUMERO HERIDOS:<?php echo $form_tipo_heridos?>                         NUMERO FALLECIDOS:<?php echo $form_tipo_fallecidos?></td>
    </tr>
    <tr>
        <td colspan="5">7.- ESTA EN RIESGO LA SEGURIDAD DE NUESTRO PERSONAL:<br/>
        <?php echo nl2br($form_tipo_riesgo) ?>
        </td>
    </tr>
    <tr>
        <td colspan="5">8.- ¿EN QUE HA SIDO SUPERADA SU CAPACIDAD PARA UNA RESPUESTA EFICIENTE Y EFECTIVA?<br/>
        <?php echo nl2br($form_tipo_superada) ?>
        </td>
    </tr>
</table>

<br/>
<table class="tabla_detalle">
    <tr>
        <td>9.- DESCRIPCIÓN DEL EVENTO<br/>
        <?php echo nl2br($eme_c_descripcion) ?>
        </td>
    </tr>
</table>

<br/>

<table class="tabla_detalle">
    <tr>
        <td>10.- ACCIONES<br/>
            <?php echo nl2br($form_tipo_acciones) ?>
        </td>
    </tr>
</table>
<br/>

<table border="0" style="page-break-inside: avoid;">
    <tr>
        <td>ANEXO: Mapa del lugar de la emergencia</td>
    </tr>
    <tr>
        <td><img src="var:imagen_mapa"/></td>
    </tr>  
</table>