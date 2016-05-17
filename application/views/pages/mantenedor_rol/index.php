<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Roles
                <small><i class="fa fa-arrow-right"></i> Mantenedor</small>
                
                <div class="pull-right">
                    <a href="#" id="nueva" class="btn btn-green btn-square">
                        <i class="fa fa-plus"></i>
                        Nuevo rol
                    </a>
                </div>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio </a></li>
                <li><i class="fa fa-users"></i> Usuarios </li>
                <li><i class="fa fa-angle-double-right"></i> Roles </li>
                <li class="active"><i class="fa fa-list"></i> Listado </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">                     
        <div class="row">
            <div id="resultados" class="table-responsive" data-row="20" style="overflow: visible">
                <div class="col-lg-12 text-center" style="height: 100px;">
                    <i class="fa fa-4x fa-spin fa-spinner"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/library/bootbox-4.4.0/bootbox.min.js") ?>
<?= loadJS("assets/js/modulo/general/permisos.js") ?>
<?= loadJS("assets/js/modulo/mantenedor/roles.js") ?>