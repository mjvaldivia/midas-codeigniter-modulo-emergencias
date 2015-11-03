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
    <div class="col-lg-4 col-sm-12">
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
                            Alarmas
                        </div>
                        <div id="alarmas-cantidad" class="circle-tile-number text-faded">

                        </div>
                        <a href="<?= site_url("alarma/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>

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
                        <div id="emergencias-cantidad" class="circle-tile-number text-faded">
                            
                           
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
    </div>
    <div class="col-lg-8 col-sm-12">
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

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre emergencia</th>
                                    <th>Tipo emergencia</th>
                                    <th>Comunas afectadas</th>
                                    <th>Fecha emergencia</th>
                                    <th>Lugar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre emergencia</th>
                                    <th>Tipo emergencia</th>
                                    <th>Comunas afectadas</th>
                                    <th>Fecha emergencia</th>
                                    <th>Lugar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                    <td>@mdo</td>
                                    <td>
                                        <button class="btn btn-xs btn-blue">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

<?= loadCSS("assets/lib/daterangepicker/daterangepicker.css", true) ?>
<?= loadCSS("assets/lib/fullcalendar/fullcalendar.css", true) ?>

<?= loadJS("assets/lib/daterangepicker/moment.js", true) ?>
<?= loadJS("assets/lib/daterangepicker/daterangepicker.js", true) ?>
<?= loadJS("assets/lib/moment/moment.min.js", true) ?>
<?= loadJS("assets/lib/fullcalendar/fullcalendar.min.js", true) ?>
<?= loadJS("assets/lib/fullcalendar/lang-all.js", true) ?>
<?= loadJS("assets/js/Modulo/dashboard.js", true) ?>