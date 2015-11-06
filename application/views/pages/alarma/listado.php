<style type="text/css">
    .form-inline .form-group {
        margin-right: 20px;
    }

    td,th {
        vertical-align: middle!important;
        padding-bottom: 5px;
        border: 0!important;
    }

    tr.odd div {
        background-color: whitesmoke;
    }

    tr.even div {
        background-color: rgb(208,228,247);
    }

    .shadow {


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
</style>

<form class="form-inline">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-filter"></i>
                Filtros
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label">Año</label>
                <input id="iAnio" name="iAnio" type="text" class="form-control" style="max-width: 100px" value="<?= $anioActual ?>"/>
            </div>
            <div class="form-group">
                <label for="TiposEmergencias" class="control-label">Tipo de emergencia</label>
                <select name="TiposEmergencias" id="TiposEmergencias" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="iEstadoAlarma" class="control-label">Estado</label>
                <?= formElementSelectAlarmaEstados("iEstadoAlarma", $select_estado_id_default, array("class" => "form-control")) ?>
            </div>
            <button id="btnBuscarAlarmas" type="button" class="btn btn-primary">
                <i class="fa fa-search"></i>
                Buscar
            </button>
        </div>
    </div>
</form>

<form class="form-horizontal" onsubmit="return false;">

    <div id="pResultados" class="panel panel-primary" width="100%" style="visibility: hidden">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-th-list"></i>
                Resultados
            </h3>
        </div>
        <div class="panel-body table-responsive">
            <table id="tblAlarmas" class="table">
                <thead>
                    <tr><th></th></tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</form>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadJS("assets/js/jquery.jcombo.js") ?>
<?= loadJS("assets/js/alarmas.js") ?>

<script type="text/javascript">
    $(document).ready(function () {
        Alarma.inicioListado();
        
    });
</script>