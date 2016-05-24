<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Monitoreo de Trampas
                <div class="pull-right">

                    <!--<a href="<?php echo base_url("trampas/excel"); ?>" target="_blank" id="descargar" class="btn btn-default btn-square">
                        <i class="fa fa-download"></i>
                        Descargar excel
                    </a>-->

                    <a href="<?php echo base_url("vectores_trampas/nuevo"); ?>" id="nueva" class="btn btn-square btn-green">
                        <i class="fa fa-plus"></i>
                        Nueva Trampa
                    </a>

                </div>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li class="active"><i class="fa fa-bell"></i> Trampas</li>
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
                            <?php echo $grilla;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo jsDatatable(); ?>