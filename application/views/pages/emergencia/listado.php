<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadCSS("assets/js/library/bootstrap-fileinput/css/fileinput.min.css") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput.min.js") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadCSS("assets/js/library/picklist/picklist.css") ?>
<?= loadJS("assets/js/library/picklist/picklist.js") ?>

<?= loadJS("assets/js/library/bootbox-4.4.0/bootbox.min.js") ?>
<?= loadJS("assets/js/library/mapa/extencion/geo-encoder.js"); ?>
<?= loadJS("assets/js/library/html2canvas/build/html2canvas.js") ?>

<?= loadJS("assets/js/modulo/alarma/mapa.js") ?>
<?= loadJS("assets/js/modulo/alarma/form-alarma.js") ?>
<?= loadJS("assets/js/modulo/emergencia/form-emergencias-cerrar.js") ?>
<?= loadJS("assets/js/modulo/emergencia/form-emergencias-editar.js") ?>
<?= loadJS("assets/js/modulo/emergencia_reporte/form.js") ?>
<?= loadJS("assets/js/emergencia.js") ?>


<style type="text/css">
    .form-inline .form-group {
        margin-right: 20px;
    }

    #tblAlarmas td,th {
        vertical-align: middle!important;
        padding-bottom: 5px;
        border: 0!important;
    }

    #tblAlarmas tr.odd div {
        background-color: whitesmoke;
    }

    #tblAlarmas tr.even div {
        background-color: rgb(208,228,247);
    }

    #tblAlarmas .shadow {


        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border : 1px solid silver;
    }
    .icono{
    font-size: 42px;
    color: white;
    border: 1px solid black;
    border-radius: 5px;
    padding-top: 7px;
    height: 60px;
    width: 60px;
background: rgb(208,228,247); /* Old browsers */
background: -moz-linear-gradient(top, rgb(208,228,247) 0%, rgb(115,177,231) 24%, rgb(10,119,213) 50%, rgb(83,159,225) 79%, rgb(135,188,234) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(208,228,247)), color-stop(24%,rgb(115,177,231)), color-stop(50%,rgb(10,119,213)), color-stop(79%,rgb(83,159,225)), color-stop(100%,rgb(135,188,234))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgb(208,228,247) 0%,rgb(115,177,231) 24%,rgb(10,119,213) 50%,rgb(83,159,225) 79%,rgb(135,188,234) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgb(208,228,247) 0%,rgb(115,177,231) 24%,rgb(10,119,213) 50%,rgb(83,159,225) 79%,rgb(135,188,234) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgb(208,228,247) 0%,rgb(115,177,231) 24%,rgb(10,119,213) 50%,rgb(83,159,225) 79%,rgb(135,188,234) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgb(208,228,247) 0%,rgb(115,177,231) 24%,rgb(10,119,213) 50%,rgb(83,159,225) 79%,rgb(135,188,234) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d0e4f7', endColorstr='#87bcea',GradientType=0 );
    }
    .btn-group .btn-default{
             font-size: 17px;
    }
</style>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Emergencias
                <small><i class="fa fa-arrow-right"></i> Listado de emergencias</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio</a></li>
                <li> Emergencias</li>
                <li class="active" > Listado</li>
            </ol>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- end PAGE TITLE AREA -->


<div id="contenedor-emergencia">
<form class="form-inline form-busqueda">
    <div class="portlet portlet-default">
        <div class="portlet-body">
            <div class="form-group">
                <label for="" class="control-label">Año</label>
                <input id="iAnio" name="iAnio" type="text" class="form-control" style="max-width: 100px" value="{anioActual}"/>
            </div>
            <div class="form-group">
                <label for="iTiposEmergencias" class="control-label">Tipo de emergencia</label>
                <select name="iTiposEmergencias" id="iTiposEmergencias" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="iEstadoEmergencias" class="control-label">Estado</label>
                <?= formElementSelectEmergenciaEstados("iEstadoEmergencias", $select_estado_id_default, array("class" => "form-control")); ?>
            </div>
            <button id="btnBuscar" type="button" class="btn btn-primary btn-square btn-buscar" onclick="Emergencia.eventoBtnBuscar();">
                <i class="fa fa-search"></i>
                Buscar
            </button>
        </div>
    </div>
</form>

<form class="form-horizontal" onsubmit="return false;">

    <div id="pResultados" class="portlet portlet-default" width="100%" style="visibility: hidden">
        <div class="portlet-body table-responsive">
            <table id="tblEmergencias" class="table">
                <thead>
                    <tr><th></th></tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</form>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        Emergencia.inicioListado();
    });
</script>