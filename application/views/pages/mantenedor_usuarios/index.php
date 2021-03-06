<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Usuario
                <small><i class="fa fa-arrow-right"></i> Mantenedor</small>

                <div class="pull-right">
                    <a href="#" id="nueva" class="btn btn-green btn-square">
                        <i class="fa fa-plus"></i>
                        Nueva persona
                    </a>
                </div>

            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio </a></li>
                <li class="active"><i class="fa fa-bell"></i> Usuarios </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">           
        <form name="busqueda" id="busqueda" class=" form-busqueda">
            <div class="portlet portlet-basic">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="" class="control-label">Rut</label>
                                <input id="filtro_rut" name="filtro_rut" type="text" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="" class="control-label">Nombre</label>
                                <input id="filtro_nombre" name="filtro_nombre" type="text" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="filtro_id_region" class="control-label">Región</label>
                                <?= formElementSelectRegion("filtro_id_region", "",array("class" => "form-control") ) ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button id="btn-buscar" type="button" class="btn btn-primary btn-square btn-buscar top-spaced">
                                <i class="fa fa-search"></i>
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
                            
        <div id="pResultados" class="portlet portlet-default">
            <div class="portlet-body table-responsive">
                <div id="grilla-usuarios"></div>
                <div id="grilla-usuarios-loading" class="col-lg-12 text-center"> 
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
<?= loadJS("assets/js/modulo/mantenedor/usuarios.js") ?>