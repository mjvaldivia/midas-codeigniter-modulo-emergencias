
<div id="pResultados" class="portlet portlet-default" width="100%">
    <div class='portlet-body'>
        <div class="table-responsive">
            <div class="col-xs-12" id="contenedor-grilla-capas"></div>

        </div>
    </div>
</div>
<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/capas.js",false) ?>

<script type="text/javascript">
    $(document).ready(function () {
        Layer.initList();
    });
</script>