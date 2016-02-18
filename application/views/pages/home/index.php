<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Inicio
                <small><i class="fa fa-arrow-right"></i> Resumen</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Inicio</li>
            </ol>
        </div>
    </div>
</div>

<div id="contenedor-home">

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="row">
                
                <?php if(puedeVer("alarma")) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?php if(puedeEditar("alarma")) { echo site_url("evento/index/tab/nuevo"); } else {echo site_url("evento/index/tab/listado");} ?>">
                            <div class="circle-tile-heading orange">
                                <i class="fa fa-bullhorn fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content orange">
                            <div class="circle-tile-description text-faded">
                                Eventos
                            </div>
                            <a href="<?php if(puedeEditar("alarma")) { echo site_url("evento/index/tab/nuevo"); } else {echo site_url("evento/index/tab/listado");} ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php /*if(puedeVer("emergencia")) { */?><!--
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?/*= site_url("emergencia/listado/estado/en_curso") */?>">
                            <div class="circle-tile-heading red">
                                <i class="fa fa-bullhorn fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">
                                Emergencias
                            </div>
                            <a href="<?/*= site_url("emergencia/listado/estado/en_curso") */?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                --><?php /*} */?>
                
                <?php if(puedeVer("capas")) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?php if(puedeEditar("capas")) { echo site_url("capas/ingreso/tab/nuevo"); } else { echo site_url("capas/ingreso/tab/listado"); } ?>">
                            <div class="circle-tile-heading blue">
                                <i class="fa fa-object-group fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content blue">
                            <div class="circle-tile-description text-faded">
                                Capas
                            </div>
                            <a href="<?php if(puedeEditar("capas")) { echo site_url("capas/ingreso/tab/nuevo"); } else { echo site_url("capas/ingreso/tab/listado"); } ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?php if(puedeEditar("capas")) { echo "#"; } else { echo "#"; } ?>">
                            <div class="circle-tile-heading dark-blue">
                                <i class="fa fa-globe fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded">
                                Visor
                            </div>
                            <a href="<?php if(puedeEditar("capas")) { echo "#"; } else { echo "#"; } ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php if(puedeVer("simulacion")) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?= site_url("/session/inicia_simulacion") ?>">
                            <div class="circle-tile-heading green">
                                <i class="fa fa-flag-checkered fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content green">
                            <div class="circle-tile-description text-faded">
                                Simulación
                            </div>
                            <a href="<?= site_url("/session/inicia_simulacion") ?>" class="circle-tile-footer">Ir a simulación <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php if(puedeVer("documentacion")) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?= site_url("/mantenedor_documentos/index") ?>">
                            <div class="circle-tile-heading dark-gray">
                                <i class="fa fa-book fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content dark-gray">
                            <div class="circle-tile-description text-faded">
                                Documentación
                            </div>
                            <a href="<?= site_url("/mantenedor_documentos/index") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="circle-tile">
                        <a href="<?= site_url("soportes/bandeja_usuario") ?>">
                            <div class="circle-tile-heading gray">
                                <i class="fa fa-question-circle fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content gray">
                            <div class="circle-tile-description text-faded">
                                Mesa de ayuda
                            </div>
                            <a href="<?= site_url("soportes/bandeja_usuario") ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            
            <?php if(puedeVer("emergencia")) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="portlet portlet-default">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4><i class="fa fa-list-ul"></i> Eventos con Emergencia en Curso</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="portlet-body">
                            <div id="contendor-grilla-emergencia" class="table-responsive">
                                <div class="col-lg-12 text-center">
                                    <i class="fa fa-4x fa-spin fa-spinner"></i>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <?php if(puedeVer("alarma")) { ?>
                <div class="row top-spaced">
                    <div class="col-lg-12">
                        <div class="portlet portlet-default">
                            <div class="portlet-heading">
                                <div class="portlet-title">
                                    <h4><i class="fa fa-list-ul"></i> Eventos en Alerta</h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="portlet-body" >
                                <div id="contendor-grilla-alarma" class="table-responsive">
                                    <div class="col-lg-12 text-center">
                                        <i class="fa fa-4x fa-spin fa-spinner"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            <?php } ?>
            <?php if(puedeVer("alarma")) { ?> 
            <div class="row top-spaced">
                <div class="col-lg-12">
                    <div class="portlet portlet-default">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4><i class="fa fa-calendar"></i> Calendario</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="calendar"></div>   
                                </div>
                                <div class="col-lg-6">
                                    <div id="mapa-emergencias" style="height: 525px">
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php if(puedeVer("alarma")) { ?> 
    <div class="row">
        <div class="col-lg-12">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4><i class="fa fa-line-chart"></i> Gráfico de emergencia por mes</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="lineChart" class="panel-collapse collapse in">
                    <div class="portlet-body" style="height: 555px;padding-top: 100px">
                        <div id="morris-chart-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/js/library/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadCSS("assets/js/library/daterangepicker/daterangepicker.css", true) ?>
<?= loadCSS("assets/js/library/fullcalendar/fullcalendar.css", true) ?>
<?= loadCSS("assets/js/library/morris/morris.css", true) ?>

<?= loadJS("assets/js/library/daterangepicker/moment.js", true) ?>
<?= loadJS("assets/js/library/daterangepicker/daterangepicker.js", true) ?>

<?= loadJS("assets/js/library/moment/moment.min.js", true) ?>
<?= loadJS("assets/js/library/fullcalendar/fullcalendar.min.js", true) ?>
<?= loadJS("assets/js/library/fullcalendar/lang-all.js", true) ?>

<?= loadJS("assets/js/library/morris/raphael-2.1.0.min.js", true) ?>
<?= loadJS("assets/js/library/morris/morris.js", true) ?>

<?= loadJS("assets/js/library/bootbox-4.4.0/bootbox.min.js", true) ?>


<?= loadCSS("assets/js/library/bootstrap-fileinput/css/fileinput.min.css") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput.min.js") ?>
<?= loadJS("assets/js/library/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadJS("assets/js/modulo/general/permisos.js") ?>

<?= loadJS("assets/js/modulo/evento/form/mapa/mapa.js"); ?>
<?= loadJS("assets/js/modulo/evento/form/nuevo.js") ?>
<?= loadJS("assets/js/modulo/evento/form/editar.js") ?>
<?= loadJS("assets/js/modulo/evento/form/finalizar.js") ?>

<?= loadJS("assets/js/library/html2canvas/build/html2canvas.js"); ?>
<?= loadJS("assets/js/modulo/evento/reporte/form.js") ?>
<?= loadJS("assets/js/modulo/evento/reporte/mapa/imagen.js") ?>

<?= loadJS("assets/js/modulo/home/mapa.js"); ?>
<?= loadJS("assets/js/modulo/home/dashboard.js", true) ?>