<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Alarmas
                <small><i class="fa fa-arrow-right"></i> Gestión de alarmas</small>
                <?php if(puedeEditar("alarma")){ ?>
                <div class="pull-right">
                    <a href="#" id="nueva" class="btn btn-green btn-square">
                        <i class="fa fa-plus"></i>
                        Nueva alarma
                    </a>
                </div>
                <?php } ?>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Dashboard </a></li>
                <li><i class="fa fa-bell"></i> Alarmas </li>
                <li class="active"><i class="fa fa-bell"></i> Ingreso </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">           
        <form name="busqueda" id="busqueda" class=" form-busqueda">
            <div class="portlet portlet-default">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="" class="control-label">Año</label>
                                <input id="filtro_year" name="filtro_year" type="text" class="form-control" value="<?= $year ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="TiposEmergencias" class="control-label">Tipo de emergencia</label>
                                <?= formElementSelectEmergenciaTipo("filtro_id_tipo", "",array("class" => "form-control") ) ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="iEstadoAlarma" class="control-label">Estado</label>
                                <?= formElementSelectAlarmaEstados("filtro_id_estado", $id_estado, array("class" => "form-control")) ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button id="btnBuscarAlarmas" type="button" class="btn btn-primary btn-square btn-buscar top-spaced">
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
                <div id="grilla-alarma"></div>
                <div id="grilla-alarma-loading" class="col-lg-12 text-center"> <i class="fa fa-4x fa-spin fa-spinner"></i> </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadCSS("assets/lib/picklist/picklist.css") ?>
<?= loadJS("assets/lib/picklist/picklist.js") ?>

<?= loadJS("assets/js/moment.min.js") ?>
<?= loadCSS("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
<?= loadJS("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>

<?= loadJS("assets/js/bootbox.min.js") ?>
<?= loadJS("assets/js/geo-encoder.js") ?>

<?= loadJS("assets/js/modulo/general/permisos.js") ?>

<?= loadJS("assets/js/modulo/alarma/mapa.js"); ?>
<?= loadJS("assets/js/modulo/alarma/form-alarma.js") ?>
<?= loadJS("assets/js/modulo/alarma/form-alarma-editar.js"); ?>

<?= loadJS("assets/js/modulo/emergencia/form-emergencias-nueva.js") ?>

<?= loadJS("assets/js/modulo/alarma/listado.js") ?>