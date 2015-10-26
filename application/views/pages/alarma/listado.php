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
        background-color: #deeefe;
    }
    
    tr.even div {
        background-color: #bbdcfd;
    }
    
    .shadow {
        -moz-box-shadow: 5px 5px 5px 0px #3B9DFF;
        -webkit-box-shadow: 5px 5px 5px 0px #3B9DFF;
        box-shadow: 5px 5px 5px 0px #3B9DFF;
        
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
</style>
<br>
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
                <input id="iAnio" name="iAnio" type="text" class="form-control" style="max-width: 100px" value="{anioActual}"/>
            </div>
            <div class="form-group">
                <label for="TiposEmergencias" class="control-label">Tipo de emergencia</label>
                <select name="TiposEmergencias" id="TiposEmergencias" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="iEstadoAlarma" class="control-label">Estado</label>
                <select name="iEstadoAlarma" id="iEstadoAlarma" class="form-control"></select>
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