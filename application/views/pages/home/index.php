<?php echo $js; ?>

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
                
                <?php if(permisoEvento("ver")) { ?>
                <div class="col-lg-3 col-md-6 col-sm-6 tile-menu">
                    <div class="circle-tile">
                        <a href="<?php if(permisoEvento("editar")) { echo site_url("evento/index/tab/nuevo"); } else {echo site_url("evento/index/tab/listado");} ?>">
                            <div class="circle-tile-heading orange">
                                <i class="fa fa-bullhorn fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content orange">
                            <div class="circle-tile-description text-faded">
                                Eventos
                            </div>
                            <a href="<?php if(permisoEvento("editar")) { echo site_url("evento/index/tab/nuevo"); } else {echo site_url("evento/index/tab/listado");} ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                
                <?php if(puedeVer("capas")) { ?>
                
                <div class="col-lg-3 col-md-6 col-sm-6 tile-menu">
                    <div class="circle-tile">
                        <a href="<?php echo site_url("visor"); ?>">
                            <div class="circle-tile-heading dark-blue">
                                <i class="fa fa-globe fa-fw fa-3x"></i>
                            </div>
                        </a>
                        <div class="circle-tile-content dark-blue">
                            <div class="circle-tile-description text-faded">
                                Visor
                            </div>
                            <a href="<?php echo site_url("visor"); ?>" class="circle-tile-footer">Mas información <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 tile-menu">
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
                
                <?php } ?>
                
                <?php if(puedeVer("simulacion")) { ?>
                <div class="col-lg-2 col-md-4 col-sm-6 tile-menu">
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
                <div class="col-lg-2 col-md-4 col-sm-6 tile-menu">
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
                
                <!--<div class="col-lg-2 col-md-4 col-sm-6">
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
                </div>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            
            <?php if(permisoEvento("ver")) { ?>
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
            
            <?php if(permisoEvento("ver")) { ?>
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
            <!--<div class="row top-spaced">
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
            </div>-->
            <?php } ?>
        </div>
    </div>

    <?php if(puedeVer("alarma")) { ?> 
    <!--<div class="row">
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
    </div>-->
    <?php } ?>
</div>

<?= loadJS("assets/js/library/html2canvas/build/html2canvas.js"); ?>
<?= loadJS("assets/js/modulo/evento/reporte/form.js") ?>
<?= loadJS("assets/js/modulo/evento/reporte/mapa/imagen.js") ?>

<?= loadJS("assets/js/modulo/home/mapa.js"); ?>
<?= loadJS("assets/js/modulo/home/dashboard.js", true) ?>