<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Emergencias</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>

    <?php //jquery ?>
    <?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
    <?= loadJS("assets/js/jquery.jcombo.js", true) ?>

    <?php // bootstrap ?>
    <?= loadCSS("assets/lib/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <?= loadJS("assets/lib/bootstrap-3.3.5/js/bootstrap.js", true) ?>

    <?php //font-awesome ?>
    <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>

    <?= loadCSS("assets/css/emergencias.css") ?>

    <script type="text/javascript">
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
    </script>
</head>
<body>
<div class='cargando'><img src="<?= base_url("assets/img/loading.gif") ?>"/><span>Cargando...</span></div>
<div id="container" class="container-fluid">
    <div id="header" class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <img src="<?php echo base_url("/assets/img/top_logo.png") ?>" width="140px"/>
            </div>
            <div class="col-md-8">
                <div class="page-header">
                    <h1>Emergencias</h1>
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-user"></i>{session_usuario}
                    </button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" style="text-transform: uppercase">
                        <li>
                            <a href="#">
                                <i class="fa fa-cog"></i>{session_cargo}
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#">
                                <i class="fa fa-globe"></i>{session_region}
                            </a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="#pCambioRapido" data-toggle="modal" data-target="#pCambioRapido">
                                    <i class="fa fa-exchange"></i>Cambiar de usuario
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px">
            <nav id="mainNavBar" class="navbar navbar-default navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url("/") ?>">Inicio</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-inverse">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Alarma <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-inverse">
                                <li>
                                    <a href="<?= site_url("alarma/ingreso") ?>">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        Ingreso alarma
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url("alarma/listado") ?>">
                                        <i class="fa fa-list"></i>
                                        Listado alarmas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Capas <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-inverse">
                                <li>
                                    <a href="<?= site_url("capas/ingreso") ?>">
                                        <i class="fa fa-plus"></i>
                                        Ingreso Capa
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url("capas") ?>">
                                        <i class="fa fa-list"></i>
                                        Listado Capas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Emergencia <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-inverse">
                                <li>
                                    <a href="<?= site_url("emergencia/listado") ?>">
                                        <i class="fa fa-list"></i>
                                        Listado Emergencias
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Modelación</a></li>
                        <li><a href="#">Documentación</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mesa de ayuda <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-inverse">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-envelope"></i>
                                        Mensajes
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-question-circle"></i>
                                        Soportes pendientes
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-check"></i>
                                        Soportes finalizados
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </div>
    </div>
    <div id="main" class="row">
        <div class="col-md-12">
            {body}
        </div>
        <div class="modal fade" id="pCambioRapido" role="dialog" aria-labelledby="pCambioRapidoTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="pCambioRapidoTitle" class="modal-title">Seleccione un usuario para el cambio rápido</h4>
                    </div>
                    <div class="modal-body">
                        <label>Seleccione usuario:</label>
                        <select id="users" name="users" class="form-control  select2"></select>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCambioRapido" type="button" class="btn btn-success">Aceptar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="footer">
            <p>SEREMI de Salud Región Valparaíso - Dirección: Melgarejo 669, Piso 6, Valparaíso, Chile - Teléfono: (56-32) 2571417 - 2571419</p>
        </div>
    </div>
</div>

<?= loadCSS("assets/lib/select2-4.0.0/css/select2.css", true) ?>
<?= loadJS("assets/lib/select2-4.0.0/js/select2.js", true) ?>

<?= loadJS("assets/js/utils.js") ?>
<?= loadJS("assets/js/loading.js") ?>
<script type="text/javascript">
    $(document).ready(function() {
        Utils.listenerCambioRapido();
        Utils.toggleNavbarMethod();
        Utils.ajaxRequestMonitor();
        $(window).resize(Utils.toggleNavbarMethod);
    });
</script>
</body>
</html>