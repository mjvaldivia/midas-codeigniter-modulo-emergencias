<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>  Gestión de vigilancia de casos febriles/exantemáticos ISLA DE PASCUA 
                <div class="pull-right">
                    <?php if(puedeVerGraficos):?>
                    <a href="<?php echo base_url("formulario/dengue_reporte_grafico"); ?>"  class="btn btn-orange btn-square">
                        <i class="fa fa-bar-chart"></i>
                        Reporte Gráfico
                    </a>
                    <?php endif;?>
                    <?php if(puedeVerReporteEmergencia("casos_febriles")) { ?>
                    <a href="<?php echo base_url("formulario/excel"); ?>" target="_blank" id="descargar" class="btn btn-default btn-square">
                        <i class="fa fa-download"></i>
                        Descargar excel
                    </a>
                    <?php } ?>
                    
                    <?php if(puedeActivarAlarma("casos_febriles")) { ?>
                    <a href="<?php echo base_url("formulario/form_dengue"); ?>" id="nueva" class="btn btn-square btn-green">
                        <i class="fa fa-plus"></i>
                        Nuevo caso
                    </a>
                    <?php } ?>
                </div>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li class="active"><i class="fa fa-bell"></i> Casos febriles </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">                        
        <div id="pResultados" class="portlet portlet-default">
                <div class="portlet-body"> 
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="resultados" class="table-responsive" data-row="20">
                                <div class="col-lg-12 text-center">
                                    <i class="fa fa-4x fa-spin fa-spinner"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
     
        </div>
    </div>
</div>

<?= loadJS("assets/js/library/bootbox-4.4.0/bootbox.min.js", true) ?>
<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css"); ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js"); ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js"); ?>
<?= loadJS("assets/js/dengue.js") ?>