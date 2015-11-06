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


<!-- begin DASHBOARD CIRCLE TILES -->
<div class="row">
    <div class="col-lg-5 col-sm-12">
        <div class="row">
            
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading orange">
                            <i class="fa fa-bell fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content orange">
                        <div class="circle-tile-description text-faded">
                            Alarmas en revisión
                        </div>
                        <div id="alarmas-revision-cantidad" class="circle-tile-number text-faded">
                            <?= $cantidad_alarmas_en_revision ?>
                        </div>
                        <a href="<?= site_url("alarma/ingreso/tab/listado/estado/en_revision") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading gray">
                            <i class="fa fa-bell-slash fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content gray">
                        <div class="circle-tile-description text-faded">
                            Alarmas rechazadas
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?= $cantidad_alarmas_rechazada ?>
                        </div>
                        <a href="<?= site_url("alarma/ingreso/tab/listado/estado/rechazado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>    
        <div class="row">
            
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading red">
                            <i class="fa fa-bullhorn fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content red">
                        <div class="circle-tile-description text-faded">
                            Emergencias en curso
                        </div>
                        <div id="emergencias-encurso-cantidad" data-row="5" class="circle-tile-number text-faded">
                           <?= $cantidad_emergencias_en_curso ?>
                        </div>
                        <a href="<?= site_url("emergencia/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading green">
                            <i class="fa fa-check fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content green">
                        <div class="circle-tile-description text-faded">
                            Emergencias cerradas
                        </div>
                        <div data-row="5" class="circle-tile-number text-faded">
                            <?= $cantidad_emergencias_cerradas ?>
                        </div>
                        <a href="<?= site_url("emergencia/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tile tile-img tile-time" style="height: 200px">
                    <p class="time-widget">
                        <span class="time-widget-heading">Hoy es</span>
                        <br>
                        <strong>
                            <span id="datetime"></span>
                        </strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-green">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Gráfico de emergencia por mes</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="lineChart" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div id="morris-chart-line"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-lg-7 col-sm-12">
        <div class="row top-spaced-doble">
            <div class="col-lg-12">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4><i class="fa fa-list-ul"></i> Ultimas emergencias</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <div id="contendor-grilla-emergencia" class="table-responsive">
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4><i class="fa fa-list-ul"></i> Ultimas alarmas</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <div id="contendor-grilla-alarma" class="table-responsive">
                    </div>
                </div>
            </div></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-blue">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Calendario</h4>
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


<?= loadJS("assets/js/modulo/dashboard.js", true) ?>