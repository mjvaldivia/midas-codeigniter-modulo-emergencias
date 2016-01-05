<style>    
    body{
        font-family: calibri;
    }
    table{
        width: 100%;

    }
    td, th{
       /* border: 1px solid black;*/
        /* background-color: #CFC378;*/
        font-weight: normal;
        text-align: left;
        padding : 10px;

    }
    .tabla_detalle td, .tabla_detalle th{
        border: 1px solid black;
    }
    #texto_cabecera{
        font-size: 19px;
    }
    .tabla_border{
                border-spacing: 0;
        border-collapse: collapse;
        border: 1px solid black;
    }
</style>



<table class="tabla_cabecera tabla_border">
    <tr>
        <th  style="padding:10px; width: 0px;">
            <img src="<?php echo base_url("/assets/img/top_logo.png") ?>" width="140px"/>
        </th>
        <th style="padding:10px;" id="detalle_cabecera" valign='top'>
            <div id="texto_cabecera">
                <h2><b>Reporte de Emergencias <?= $eme_ia_id ?></b></h2></div>
                <span style="text-transform: uppercase;"><?= $eme_c_nombre_emergencia ?></span><br>
                Fecha: <?= $eme_d_fecha_emergencia ?><br>
                Elaborado por: <?= $emisor ?><br>
                Fecha de emisión: <?= date('d-m-Y H:i') ?><br>
        </th>
    </tr>
</table>
<br>
<table class="tabla_detalle tabla_border">
    <tr>
        <th colspan="2">
           INFORMACIÓN DE LA ALARMA 
        </th>
    </tr>
    <tr>
        <td>Encargado de la alarma</td>
        <td><?= $usuario ?></td>
    </tr>
    <tr>
        <td>Hora inicio de la alarma </td>
        <td><?= $hora_emergencia ?></td>
    </tr>
    <tr>
        <td>Hora de registro </td>
        <td><?= $hora_recepcion ?></td>
    </tr>
    <tr>
        <td>Lugar de la Emergencia </td>
        <td><?= $eme_c_lugar_emergencia?></td>
    </tr>
    <tr>
        <td>Comuna (s)</td>
        <td><?= $nombre_comunas ?></td>
    </tr>
    <tr>
        <td>Observaciones preliminares</td>
        <td><?= $eme_c_observacion ?></td>
    </tr>
    <tr >
        <td colspan="2"></td>
    </tr>
    <tr>
        <th colspan="2">
           INFORMACIÓN DE LA EMERGENCIA
        </th>
    </tr>
    <tr>
        <td>Descripción del evento</td>
        <td><?= $eme_c_descripcion ?></td>
    </tr>
    <tr>
        <td>Acciones</td>
        <td><?= $eme_c_acciones ?></td>
    </tr>
    <tr>
        <td>Información adicional </td>
        <td><?= $eme_c_informacion_adicional ?></td>
    </tr>
    <tr>
        <td colspan="2">Dispone de recursos suficientes para controlar la emergencia: <?= $eme_c_recursos ?></td>
    </tr>
    <tr>
        <td>Número de personas heridas: <?= $eme_c_heridos ?></td>
        <td>Número de personas fallecidas: <?= $eme_c_fallecidos ?></td>
    </tr>
    <tr>
        <td colspan="2">¿Está en riesgo la seguridad de nuestro personal? <?= $eme_c_riesgo ?></td>
    </tr>
    <tr>
        <td colspan="2">¿En que ha sido superada su capacidad para una respuesta eficiente y efectiva? <?= $eme_c_capacidad ?></td>
    </tr>
</table>

<br>
<pagebreak></pagebreak>
<table border="0">
    <tr>
        <td>Mapa del lugar de la emergencia</td>
    </tr>
    <tr>
        <td><img src="<?php echo base_url($imagename) ?>"/></td>
    </tr>  
    </table>