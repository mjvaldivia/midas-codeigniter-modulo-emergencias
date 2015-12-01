<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>

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
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-body clearfix">
                
                <ul id="ul-tabs" class="nav nav-pills">    
    
                    <?php if(puedeEditar("alarma")) { ?>
                    <li class='<?= tabActive("nuevo", $tab_activo, "header") ?>'>
                        <a href="#tab1" onclick ="if(Alarma.map==null)initialize();"  data-toggle="tab" id="tab-nueva"><i class="fa fa-plus"></i> Nueva</a>
                    </li>
                    <?php } ?>

                    <li class='<?= tabActive("listado", $tab_activo, "header") ?>'>
                        <a href="#tab2" data-toggle="tab" id="tab-listado"><i class="fa fa-list"></i> Listado</a>
                    </li>

                </ul>

                <div id="tab-content" class="tab-content">

                    <?php if(puedeEditar("alarma")) { ?>
                    <div class='tab-pane top-spaced <?= tabActive("nuevo", $tab_activo, "content") ?>' id='tab1' style='overflow:hidden;'>
                        <div id='div_tab_1'>
                             <?= $formulario ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class='tab-pane top-spaced <?= tabActive("listado", $tab_activo, "content") ?>' id='tab2' style='overflow:hidden;'>
                        <div id='div_tab_2' class="col-lg-12">
                            
                            <form name="busqueda" id="busqueda" class="form-inline form-busqueda">
                                <div class="portlet portlet-default">
                                    <div class="portlet-heading">
                                        <div class="portlet-title">
                                            <h4><i class="fa fa-filter"></i>
                                            Filtros
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-group">
                                            <label for="" class="control-label">Año</label>
                                            <input id="iAnio" name="iAnio" type="text" class="form-control" style="max-width: 100px" value="<?= $year ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="TiposEmergencias" class="control-label">Tipo de emergencia</label>
                                            <?= formElementSelectEmergenciaTipo("TiposEmergencias", "",array("class" => "form-control") ) ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="iEstadoAlarma" class="control-label">Estado</label>
                                            <?= formElementSelectAlarmaEstados("iEstadoAlarma", $id_estado, array("class" => "form-control")) ?>
                                        </div>
                                        <button id="btnBuscarAlarmas" type="button" class="btn btn-primary btn-square btn-buscar">
                                            <i class="fa fa-search"></i>
                                            Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div id="pResultados" class="portlet portlet-default">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                        <h4><i class="fa fa-th-list"></i>
                                        Resultados
                                        </h4>
                                    </div>
                                </div>
                                <div class="portlet-body table-responsive">
                                    <div id="grilla-alarma"></div>
                                    <div id="grilla-alarma-loading" class="col-lg-12 text-center"> <i class="fa fa-4x fa-spin fa-spinner"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                
            </div>
        </div>
    </div>
</div>



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
<?= loadJS("assets/js/modulo/emergencia/form-emergencias-nueva.js") ?>
<?= loadJS("assets/js/modulo/alarma/form-alarma-editar.js"); ?>

<?= loadJS("assets/js/modulo/alarma/listado.js") ?>