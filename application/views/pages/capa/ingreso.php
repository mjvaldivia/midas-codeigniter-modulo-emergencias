<style>
    .fileinput-upload , .fileinput-remove-button, .fileinput-remove,  .kv-file-upload{
        display: none;
    }
</style>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Capas
                <small><i class="fa fa-arrow-right"></i> Administrador de capas</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Administrador de capas </li>
                <?php if (!$editar): ?>
                    <li class="active"><i class="fa fa-bell"></i> Ingreso Capa</li>
                <?php else: ?>
                    <li class="active"><i class="fa fa-bell"></i> Editar Capa</li>
                <?php endif; ?>
            </ol>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- end PAGE TITLE AREA -->

<div class="top-spaced">
    <h1 class="">Listado de capas
        <button type="button" class="btn btn-square btn-lg btn-success pull-right" onclick="xModal.open('<?php echo site_url('capas/nuevaCapa');?>','Nueva Capa','lg');">Nueva Capa</button>
    </h1>

</div>


<div class="col-xs-12 top-spaced">
    <div class="row">
        <div id='listado_capas'>

        </div>
    </div>
</div>


<?= loadCSS("assets/js/library/bootstrap-fileinput/css/fileinput.css") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput.js") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/library/bootbox-4.4.0/bootbox.min.js") ?>



<?= loadJS("assets/js/capas.js") ?>

<script type="text/javascript">


    $(document).ready(function() {
        Layer.initSave();
        $('#listado_capas').load(siteUrl+'capas/listado');
    });





</script>