<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Emergencias::MIDAS</title>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>
    <script type='text/javascript' src="<?= base_url("/assets/lib/jquery-2.1.4/jquery.min.js") ?>"></script>
    
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>
    
    <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
    <?= loadCSS("assets/lib/pace/pace.css", true) ?>
    <?= loadJS("assets/lib/pace/pace.js", true) ?>    
    <?= loadCSS("assets/lib/pnotify/pnotify.custom.min.css", true) ?>
    <?= loadJS("assets/lib/joii/joii.min.js", true) ?>
    
    <!-- GLOBAL STYLES - Include these on every page. -->
    <?= loadCSS("assets/lib/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <?= loadCSS("assets/css/bootstrap.vertical-tabs.css", true) ?>
    <?= loadCSS("assets/lib/qtip/jquery.qtip.min.css", true) ?>

    <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>
    <?= loadCSS("assets/lib/spectrum-colorpicker/spectrum.css") ?>

    <!-- THEME STYLES - Include these on every page. -->
    <?= loadCSS("assets/css/style.css", true) ?>
    <?= loadJS("assets/js/Modal_Sipresa.js") ?>
    <?= loadJS("assets/js/xmodal.js") ?>
    
    <script type="text/javascript">
        
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
        $(document).ready(function(){
            $('body').on('click', '.modal-sipresa', function (event) {
                event.preventDefault();


                // $($(this).attr('data-target')).removeData('bs.modal').modal({remote: $(this).attr('href') });

                var a = $(this);
                var id = a.attr('data-target').replace('#', '');
                //$('#'+id).remove();
                // $('.dynamic-modal .modal-content').empty();
                var style = (a.attr('data-style') != '') ? a.attr('data-style') : 'width:70%;';

                $("body").append("<div class='modal fade dynamic-modal' data-backdrop='static' data-keyboard='false' id=" + id + " tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>" +
                        "<div class='modal-dialog modal-lg' style='" + style + "'>" +
                        "</div>" +
                        "</div>");
                ModalSipresa.addSuccess(id, a, $(this).attr('data-href'));
            });
            });
    </script>

    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    
    <div id="wrapper">

        <!-- begin TOP NAVIGATION -->
        <nav class="navbar-top" role="navigation">

            <!-- begin BRAND HEADING -->
            <div class="navbar-header">
                <div class='cargando'><img src="<?= base_url("assets/img/loading.gif") ?>"/><span>Cargando...</span></div>
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                    <i class="fa fa-bars"></i> Menu
                </button>
                <div class="navbar-brand">
                    <a href="<?php echo base_url("/") ?>">
                        <div> <img src="<?php echo base_url("/assets/img/logo_visor.jpg") ?>" /> Emergencias</div>
                       
                    </a>
           
                </div>
            </div>
            <!-- end BRAND HEADING -->

            <div class="nav-top">

                <!-- begin LEFT SIDE WIDGETS -->
                <ul class="nav navbar-left">
                    <li class="tooltip-sidebar-toggle">
                        <a href="#" id="sidebar-toggle" data-toogle-param="abajo" data-toggle="tooltip" data-placement="right" title="Mostrar menu">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <!-- You may add more widgets here using <li> -->
                </ul>
                <!-- end LEFT SIDE WIDGETS -->

                <!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
                <ul class="nav navbar-right">

                    <!-- begin MESSAGES DROPDOWN -->
                    <?= htmlSimulacion(); ?>

                    
                    <!--<li class="dropdown">
                        <a href="#" class="-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-scroll dropdown-alerts">

                        
                            <li class="dropdown-header">
                                <i class="fa fa-envelope"></i> No hay mensajes nuevos
                            </li>

                            
                        </ul>
                    </li>-->
                    <!-- /.dropdown -->
                    <!-- end MESSAGES DROPDOWN -->
                    <!-- begin USER ACTIONS DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i> {session_usuario} <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            
                            <li>
                                <a href="#">
                                    <i class="fa fa-cog"></i> <strong>Roles</strong>
                                </a>
                            </li>
                            
                            <?php echo headerRoles(); ?>
                            
                            <li class="divider"></li>
                            
                            <li>
                                <a href="#">
                                    <i class="fa fa-globe"></i> Regiones
                                </a>
                            </li>
                            
                            <?php echo headerRegiones(); ?>
                            
                            <li class="divider"></li>
                            
                            <?php if (isAdmin()): ?>
                                <li>
                                    <a href="#pCambioRapido" data-toggle="modal" data-target="#pCambioRapido">
                                        <i class="fa fa-exchange"></i> Cambiar de usuario
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                            
                            <li>
                                <a class="logout_open" href="#logout">
                                    <i class="fa fa-sign-out"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-menu -->
                    </li>
                    <!-- /.dropdown -->
                    <!-- end USER ACTIONS DROPDOWN -->

                </ul>
                <!-- /.nav -->
                <!-- end MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->

            </div>
            <!-- /.nav-top -->
        </nav>
        <!-- /.navbar-top -->
        <!-- end TOP NAVIGATION -->

        <!-- begin SIDE NAVIGATION -->
        <nav class="navbar-side <?= menuCollapsed("navbar"); ?>" role="navigation">
            <div class="navbar-collapse sidebar-collapse <?= menuCollapsed("sidebar"); ?>">
                <ul id="side" class="nav navbar-nav side-nav">
                    <li class="side-user hidden-xs">
                        
                        <p class="welcome">
                            <i class="fa fa-key"></i> Has iniciado sesi&oacute;n como
                        </p>
                        <p class="name tooltip-sidebar-logout">
                            {session_usuario} <a style="color: inherit" class="logout_open" href="#logout" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out"></i></a>
                        </p>
                        <div class="clearfix"></div>
                    </li>
                    <!--<li class="nav-search">
                        <form role="form">
                            <input type="search" class="form-control" placeholder="Buscar...">
                            <button class="btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </li>-->
                    <?= menuRender() ?>
                </ul>
                <!-- /.side-nav -->
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <!-- /.navbar-side -->
        <!-- end SIDE NAVIGATION -->

        <!-- begin MAIN PAGE CONTENT -->
        <div id="page-wrapper" class="<?= menuCollapsed("navbar"); ?>">

            <div class="page-content">
                {body}
            </div>   
            <!-- /.page-content -->

        </div>
        <!-- /#page-wrapper -->
        <!-- end MAIN PAGE CONTENT -->

    </div>
    <!-- /#wrapper -->

    <!-- GLOBAL SCRIPTS -->
    <div id="footer-js">
        <?= loadJS("assets/lib/bootstrap-3.3.5/js/bootstrap.js", true) ?>
        <?= loadJS("assets/lib/popupoverlay/jquery.popupoverlay.js", true) ?>
        <?= loadJS("assets/lib/livequery/jquery.livequery.min.js", true) ?>
        <?= loadJS("assets/lib/popupoverlay/defaults.js", true) ?>
        <?= loadJS("assets/lib/popupoverlay/logout.js", true) ?>
        <?= loadJS("assets/js/jquery.jcombo.js", true) ?>
        <?= loadJS("assets/lib/qtip/jquery.qtip.min.js", true) ?>

        <?= loadCSS("assets/lib/chosen_v1.4.2/chosen.min.css") ?>
        <?= loadJS("assets/lib/chosen_v1.4.2/chosen.jquery.min.js") ?>
        <?= loadCSS("assets/lib/select2-4.0.0/css/select2.css", true) ?>
        <?= loadCSS("assets/lib/select2-4.0.0/css/select2-bootstrap.css", true) ?>
        <?= loadJS("assets/lib/select2-4.0.0/js/select2.js", true) ?>

        <?= loadJS("assets/js/moment.min.js") ?>
        <?= loadCSS("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
        <?= loadJS("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>
        <?= loadJS("assets/lib/pnotify/pnotify.custom.min.js", true) ?>
        <?= loadJS("assets/lib/spectrum-colorpicker/spectrum.js") ?>
        <?= loadJS("assets/js/base.js") ?>
        <?= loadJS("assets/js/utils.js") ?>

        <script type="text/javascript">
            $(document).ready(function () {
                Utils.listenerCambioRapido();
                Utils.toggleNavbarMethod();
                Utils.ajaxRequestMonitor();
                $(window).resize(Utils.toggleNavbarMethod);
            });
        </script>
    </div>
    <!-- Logout Notification Box -->
    <div id="logout">
        <div class="logout-message">
            
            <h3>
                <i class="fa fa-sign-out text-green"></i> ¿Realmente desea salir?
            </h3>
            <p>Seleccione "Salir" si <br> desea cerrar la sesión actual.</p>
            <ul class="list-inline">
                <li>
                    <a href="<?= site_url("session/logout") ?>" class="btn btn-green">
                        <strong>Salir</strong>
                    </a>
                </li>
                <li>
                    <button class="logout_close btn btn-green">Cerrar</button>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="modal fade" id="pCambioRapido" role="dialog" aria-labelledby="pCambioRapidoTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="pCambioRapidoTitle" class="modal-title">Seleccione un usuario para el cambio rápido</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Seleccione usuario:</label>
                        </div>
                    </div>
                    
                    <div class="row" id="cargando-cambio-usuario">
                        <div class="col-sm-12 clearfix">
                            <i class="fa fa-spin fa-spinner"></i>
                        </div>
                    </div>
                    
                    <div class="row hidden" id="select-cambio-usuario">
                        <div class="col-sm-12 clearfix">
                            <select id="users" name="users" class="form-control"></select>
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button id="btnCambioRapido" type="button" class="btn btn-success">Aceptar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
