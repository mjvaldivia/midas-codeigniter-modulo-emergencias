<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Permisos
                <small><i class="fa fa-arrow-right"></i> Mantenedor</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Dashboard </a></li>
                <li class="active"><i class="fa fa-bell"></i> Permisos </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">           
        
                            
        <div id="pResultados" class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-th-list"></i>
                    Resultados
                    </h4>
                </div>
            </div>
            <div class="portlet-body table-responsive">
                <div id="grilla-roles"></div>
                <div id="grilla-roles-loading" class="col-lg-12 text-center"> 
                    <i class="fa fa-4x fa-spin fa-spinner"></i> 
                </div>
            </div>
        </div>
    </div>
</div>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/bootbox.min.js") ?>
<?= loadJS("assets/js/modulo/general/permisos.js") ?>
<?= loadJS("assets/js/modulo/mantenedor/permisos.js") ?>