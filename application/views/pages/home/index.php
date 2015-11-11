<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Dashboard
                <small><i class="fa fa-arrow-right"></i> Resumen</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- end PAGE TITLE AREA -->

<div id="contenedor-home">

<!-- begin DASHBOARD CIRCLE TILES -->
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="row">
            
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="<?= site_url("alarma/ingreso/tab/nuevo") ?>">
                        <div class="circle-tile-heading orange">
                            <i class="fa fa-bell fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content orange">
                        <div class="circle-tile-description text-faded">
                            Alarmas
                        </div>
                        <div id="alarmas-revision-cantidad" class="circle-tile-number text-faded">

                        </div>
                        <a href="<?= site_url("alarma/ingreso/tab/nuevo") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="<?= site_url("emergencia/listado/estado/en_curso") ?>">
                        <div class="circle-tile-heading red">
                            <i class="fa fa-bullhorn fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content red">
                        <div class="circle-tile-description text-faded">
                            Emergencias
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           
                        </div>
                        <a href="<?= site_url("emergencia/listado/estado/en_curso") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="<?= site_url("capas/ingreso") ?>">
                        <div class="circle-tile-heading blue">
                            <i class="fa fa-globe fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            Capas
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           
                        </div>
                        <a href="<?= site_url("capas/ingreso") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading green">
                            <i class="fa fa-flag-checkered fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content green">
                        <div class="circle-tile-description text-faded">
                            Simulación
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           
                        </div>
                        <a href="<?= site_url("/") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading dark-blue">
                            <i class="fa fa-book fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-blue">
                        <div class="circle-tile-description text-faded">
                            Documentación
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           
                        </div>
                        <a href="<?= site_url("/") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="circle-tile">
                    <a href="<?= site_url("soportes/bandeja_usuario") ?>">
                        <div class="circle-tile-heading dark-gray">
                            <i class="fa fa-question-circle fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-gray">
                        <div class="circle-tile-description text-faded">
                            Mesa de ayuda
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           
                        </div>
                        <a href="<?= site_url("soportes/bandeja_usuario") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="row">
            <div class="col-lg-8">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4><i class="fa fa-list-ul"></i> Ultimas emergencias</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div id="contendor-grilla-emergencia" class="table-responsive">
                            <div class="col-lg-12 text-center">
                                <i class="fa fa-4x fa-spin fa-spinner"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4><i class="fa fa-pie-chart"></i> Gráfico emergencias/tipo</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="donutChart" class="portlet-body" style="height: 500px; padding-top: 100px">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-chart-pie" style="height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4><i class="fa fa-list-ul"></i> Ultimas alarmas</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body" >
                        <div id="contendor-grilla-alarma" class="table-responsive">
                            <div class="col-lg-12 text-center">
                                <i class="fa fa-4x fa-spin fa-spinner"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4><i class="fa fa-line-chart"></i> Gráfico de emergencia por mes</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="lineChart" class="panel-collapse collapse in">
                        <div class="portlet-body" style="height: 555px;padding-top: 100px">
                            <div id="morris-chart-line"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-blue">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-calendar"></i> Calendario</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end DASHBOARD CIRCLE TILES -->
</div>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing,geometry"></script>
<?= loadCSS("assets/lib/jquery-ui-1.11.4/jquery-ui.css") ?>
<?= loadJS("assets/lib/jquery-ui-1.11.4/jquery-ui.js") ?>

<?= loadJS("assets/lib/bootstrap-tokenfield/dist/bootstrap-tokenfield.js") ?>
<?= loadCSS("assets/lib/bootstrap-tokenfield/dist/css/bootstrap-tokenfield.css") ?>
<?= loadJS("assets/js/geo-encoder.js") ?>


<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadCSS("assets/lib/daterangepicker/daterangepicker.css", true) ?>
<?= loadCSS("assets/lib/fullcalendar/fullcalendar.css", true) ?>
<?= loadCSS("assets/lib/morris/morris.css", true) ?>

<?= loadJS("assets/lib/daterangepicker/moment.js", true) ?>
<?= loadJS("assets/lib/daterangepicker/daterangepicker.js", true) ?>
<?= loadJS("assets/lib/moment/moment.min.js", true) ?>
<?= loadJS("assets/lib/fullcalendar/fullcalendar.min.js", true) ?>
<?= loadJS("assets/lib/fullcalendar/lang-all.js", true) ?>

<?= loadJS("assets/lib/morris/raphael-2.1.0.min.js", true) ?>
<?= loadJS("assets/lib/morris/morris.js", true) ?>

<?= loadJS("assets/lib/flot/jquery.flot.min.js", true) ?>
<?= loadJS("assets/lib/flot/jquery.flot.resize.min.js", true) ?>
<?= loadJS("assets/lib/flot/jquery.flot.pie.min.js", true) ?>
<?= loadJS("assets/lib/flot/jquery.flot.tooltip.min.js", true) ?>

<?= loadJS("assets/js/bootbox.min.js", true) ?>

<?= loadJS("assets/js/modulo/dashboard.js", true) ?>