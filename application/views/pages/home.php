<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Dashboard
                <small>Resumen</small>
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
    <div class="col-lg-2 col-sm-6">
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
                <div class="circle-tile-number text-faded">
                    9
                </div>
                <a href="<?= site_url("alarma/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
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
                <div class="circle-tile-number text-faded">
                    24
                    <span id="sparklineC"></span>
                </div>
                <a href="<?= site_url("emergencia/listado") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="#">
                <div class="circle-tile-heading dark-blue">
                    <i class="fa fa-users fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content dark-blue">
                <div class="circle-tile-description text-faded">
                    Users
                </div>
                <div class="circle-tile-number text-faded">
                    265
                    <span id="sparklineA"></span>
                </div>
                <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="#">
                <div class="circle-tile-heading green">
                    <i class="fa fa-money fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content green">
                <div class="circle-tile-description text-faded">
                    Revenue
                </div>
                <div class="circle-tile-number text-faded">
                    $32,384
                </div>
                <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="#">
                <div class="circle-tile-heading blue">
                    <i class="fa fa-tasks fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content blue">
                <div class="circle-tile-description text-faded">
                    Tasks
                </div>
                <div class="circle-tile-number text-faded">
                    10
                    <span id="sparklineB"></span>
                </div>
                <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="circle-tile">
            <a href="#">
                <div class="circle-tile-heading purple">
                    <i class="fa fa-comments fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content purple">
                <div class="circle-tile-description text-faded">
                    Mentions
                </div>
                <div class="circle-tile-number text-faded">
                    96
                    <span id="sparklineD"></span>
                </div>
                <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- end DASHBOARD CIRCLE TILES -->

<div class="row">
    <div class="col-lg-3">
        <div class="tile tile-img tile-time" style="height: 200px">
            <p class="time-widget">
                <span class="time-widget-heading">It Is Currently</span>
                <br>
                <strong>
                    <span id="datetime"></span>
                </strong>
            </p>
        </div>
    </div>
</div>


<?= loadJS("assets/lib/moment/moment.min.js", true) ?>
<?= loadJS("assets/js/Modulo/dashboard.js", true) ?>