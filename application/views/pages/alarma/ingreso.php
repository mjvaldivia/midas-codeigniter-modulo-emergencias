<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Alarmas
                <small><i class="fa fa-arrow-right"></i> Gestión de alarmas</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Dashboard </a></li>
                <li><i class="fa fa-bell"></i> Alarmas </li>
                <li class="active"><i class="fa fa-bell"></i> Ingreso </li>
            </ol>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- end PAGE TITLE AREA -->

<ul id="ul-tabs" class="nav nav-tabs">
    <li class='<?= tabActive("nuevo", $tab_activo, "header") ?>'>
        <a href="#tab1" onclick ="if(Alarma.map==null)initialize();"  data-toggle="tab">Nueva</a>
    </li>
    <li class='<?= tabActive("listado", $tab_activo, "header") ?>'>
        <a href="#tab2" data-toggle="tab">Listado</a>
    </li>
</ul>

<div id="tab-content" class="tab-content">
    
    <div class='tab-pane <?= tabActive("nuevo", $tab_activo, "content") ?>' id='tab1' style='overflow:hidden;'>
        <div id='div_tab_1'>
             <?= $formulario ?>
        </div>
    </div>
    
    <div class='tab-pane <?= tabActive("listado", $tab_activo, "content") ?>' id='tab2' style='overflow:hidden;'>
        <div id='div_tab_2'>
            <?= $html_listado ?>
        </div>
    </div>
</div> 


<?= loadCSS("assets/lib/picklist/picklist.css") ?>
<?= loadJS("assets/lib/picklist/picklist.js") ?>

<?= loadJS("assets/js/moment.min.js") ?>
<?= loadCSS("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
<?= loadJS("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>

<?= loadJS("assets/js/bootbox.min.js") ?>
<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/alarmas.js") ?>

<script type="text/javascript">
    $(document).ready(function () {
        Alarma.inicioIngreso();
        initialize();
        //$('#div_tab_2').load(siteUrl+'alarma/listado');
    });
</script>