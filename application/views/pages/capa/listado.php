
<div id="pResultados" class="portlet portlet-default" width="100%">
    <div class="portlet-heading">
        <div class="portlet-title">
            <h4><i class="fa fa-th-list"></i>
            Resultados <span id="resultados_capa"></span></h4>
        </div>
    </div>
    <div id="contenedor-grilla-capas" class="portlet-body table-responsive">
      
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