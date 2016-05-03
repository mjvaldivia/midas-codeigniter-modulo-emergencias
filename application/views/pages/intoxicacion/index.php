<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>  Gestión de Intoxicacion
                <div class="pull-right">

                    <!--<a href="<?php echo base_url("intoxicacion/excel"); ?>" target="_blank" id="descargar" class="btn btn-default btn-square">
                        <i class="fa fa-download"></i>
                        Descargar excel
                    </a>-->
        
                    <a href="<?php echo base_url("intoxicacion/nuevo"); ?>" id="nueva" class="btn btn-square btn-green">
                        <i class="fa fa-plus"></i>
                        Nueva Ficha Intoxicación Por Mariscos
                    </a>

                </div>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li class="active"><i class="fa fa-bell"></i> Intoxicaciones </li>
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
                            <div class="col-lg-12 text-center" style="height: 100px;">
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
<?= loadJS("assets/js/intoxicacion.js") ?>