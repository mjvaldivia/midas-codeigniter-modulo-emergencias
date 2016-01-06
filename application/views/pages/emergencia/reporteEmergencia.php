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
        font-size: 16px;
    }
    .tabla_border{
                border-spacing: 0;
        border-collapse: collapse;
        border: 1px solid black;
    }
    
    .descripcion{
        color: gray;
    }
</style>



<table class="">
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

INFORMACIÓN DE LA ALARMA 
<hr>
<br>
<table class="">
    <tr>
        <td width="40%">Encargado de la alarma:</td>
        <td width="60%">
            <div class="descripcion"><?= nombreUsuario($id_usuario_encargado); ?></div>
        </td>
    </tr>
    <tr>
        <td>Hora inicio de la alarma:</td>
        <td>
            <div class="descripcion"><?= $hora_emergencia ?></div>
        </td>
    </tr>
    <tr>
        <td>Hora de registro:</td>
        <td>
            <div class="descripcion"><?= $hora_recepcion ?></div>
        </td>
    </tr>
    <tr>
        <td>Lugar de la Emergencia:</td>
        <td>
            <div class="descripcion"><?= $eme_c_lugar_emergencia?></div>
        </td>
    </tr>
    <tr>
        <td>Comuna (s):</td>
        <td>
            <div class="descripcion"><?= comunasEmergenciaConComa($eme_ia_id); ?></div>
        </td>
    </tr>
    <tr>
        <td>Observaciones preliminares:</td>
        <td><?= $eme_c_observacion ?></td>
    </tr>
    <tr >
        <td colspan="2"></td>
    </tr>
</table>

<br>
INFORMACIÓN DE LA EMERGENCIA
<hr>

<br>
<?= reporteEmergenciaTipo($eme_ia_id); ?>
<br>

<!--<pagebreak></pagebreak>-->
<table border="0">
    <tr>
        <td>Mapa del lugar de la emergencia</td>
    </tr>
    <tr>
        <td><img src="<?php echo base_url($imagename) ?>"/></td>
    </tr>  
</table>