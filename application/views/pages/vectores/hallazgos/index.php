<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Gestión de Vigilancia de Vectores :: Inspecciones </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Vectores</li>
                <li class="active"><i class="fa fa-bell"></i> Inspecciones</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <?php if (1): ?>
        <div class="col-xs-12 text-right">
            <a href="<?php echo base_url('vectores_hallazgos/excel') ?>" class="btn btn-primary btn-square"
               target="_blank"><i class="fa fa-file-excel-o"></i> Descargar Excel</a>
            <?php if (!$presidencia): ?>
                <a href="<?php echo base_url('vectores_hallazgos/denuncias') ?>" class="btn btn-success btn-square"><i
                        class="fa fa-plus"></i> Nueva Inspeccion</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="col-xs-12" style="margin-top:15px">
        <div class="portlet portlet-basic">
            <div class="portlet-body">

                <div class="table-responsive" id="contenedor-lista-denuncias">
                    <?php echo $grilla; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo jsDatatable(); ?>
<?= loadJS("assets/js/modulo/vectores/hallazgos/index.js"); ?>
