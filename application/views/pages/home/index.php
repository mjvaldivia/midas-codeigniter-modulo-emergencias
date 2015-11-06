<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Dashboard
                <small><i class="fa fa-arrow-right"></i> Resumen</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="pull-right">
                    <div class="col-sm-12">
                    <div id="rango-fechas" class="reportrange btn btn-success date-picker">
                        <i class="fa fa-calendar"></i>
                        <span class="date-range">Seleccionar fechas</span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="hidden" name="fecha_desde" id="fecha_desde" value="<?= $fecha_desde ?>" class="element-search"/>
                    <input type="hidden" name="fecha_hasta" id="fecha_hasta" value="<?= $fecha_hasta ?>" class="element-search"/>
                    </div>
                </li>
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
                        <div id="alarmas-cantidad" class="circle-tile-number text-faded">

                        </div>
                        <a href="<?= site_url("alarma/ingreso") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
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

                        </div>
                        <a href="<?= site_url("alarma/ingreso") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
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
                            Emergencias
                        </div>
                        <div id="emergencias-cantidad" data-row="5" class="circle-tile-number text-faded">
                            
                           
                        </div>
                        <a href="<?= site_url("emergencia/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading gray">
                            <span class="fa-stack fa-fw fa-3x" style="width:73px">
                                <i class="fa fa-bullhorn fa-stack-1x"></i>
                                <i class="fa fa-ban fa-stack-2x" style="line-height: 75px"></i>
                            </span>
                        </div>
                    </a>
                    <div class="circle-tile-content gray">
                        <div class="circle-tile-description text-faded">
                            Emergencias rechazadas
                        </div>
                        <div data-row="5" class="circle-tile-number text-faded">
                            
                           
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
                        <h4>Emergencias</h4>
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
                        <h4>Alarmas</h4>
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