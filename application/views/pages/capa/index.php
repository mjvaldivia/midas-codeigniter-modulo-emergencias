<?php
/**
 * User: claudio
 * Date: 15-09-15
 * Time: 11:00 AM
 */
?>

<ol class="breadcrumb">
    <li><a href="<?= site_url() ?>">Inicio</a></li>
    <li class="active">Listado Capas</li>
</ol>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Capas</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="tblCapas" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Icono</th>
                    <th>Nombre</th>
                    <th>Comuna</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/extensions/Insensitive/dataTables.insensitive.js") ?>

<?= loadJS("assets/js/capas.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Layer.initList();
    });
</script>
