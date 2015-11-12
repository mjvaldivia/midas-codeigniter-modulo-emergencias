
<div id="pResultados" class="portlet portlet-default" width="100%">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4><i class="fa fa-th-list"></i>
                Resultados</h4>
            </div>
        </div>
        <div class="portlet-body table-responsive">
    <table id="tblCapas" class="table table-bordered table-striped dataTable">
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Categoría</td>
                <td>Zona Geográfica</td>
                <td>Ícono</td>
                <td>Propiedades</td>
                <td>Archivo</td>
                <td></td>
                
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>   
</div>
</div>
<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/capas.js",false) ?>

<script type="text/javascript">
    $(document).ready(function () {
        Layer.initList();
    });
</script>