<?php
/**
 * User: claudio
 * Date: 17-08-15
 * Time: 09:50 AM
 */
?>
<style type="text/css">
    .form-inline .form-group {
        margin-right: 20px;
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
                <input type="text" class="form-control" style="max-width: 100px"/>
            </div>
            <div class="form-group">
                <label for="iTiposEmergencias" class="control-label">Tipo de emergencia</label>
                <select name="iTiposEmergencias" id="iTiposEmergencias" class="form-control"></select>
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

    <div id="pResultados" class="panel panel-primary" style="display: none">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-th-list"></i>
                Resultados
            </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="tblAlarmas" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Alarmas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>B</td>
                    </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</form>

<link rel="stylesheet" href="<?= base_url("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.min.css") ?>"
      type="text/css"/>
<script src="<?= base_url("assets/lib/DataTables-1.10.8/js/jquery.dataTables.min.js") ?>"
        type="text/javascript"></script>
<script src="<?= base_url("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.min.js") ?>"
        type="text/javascript"></script>


<script src="<?= base_url("assets/js/jquery.jcombo.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/js/alarmas.js") ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        Alarma.inicioListado();
    });
</script>