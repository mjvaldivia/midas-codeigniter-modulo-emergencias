<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Flex Admin - Responsive Admin Theme</title>

    <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
    <?= loadCSS("assets/lib/pace/pace.css", true) ?>
    <?= loadJS("assets/lib/pace/pace.js", true) ?>

    <?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <?= loadCSS("assets/lib/bootstrap-3.3.2-dist/css/bootstrap.css", true) ?>

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>


    <!-- THEME STYLES - Include these on every page. -->
    <?= loadCSS("assets/css/style.css", true) ?>
    
    <script type="text/javascript">
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
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
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                    <i class="fa fa-bars"></i> Menu
                </button>
                <div class="navbar-brand">
                    <a href="index.html">
                       <!-- <img src="<?php echo base_url("/assets/img/top_logo.png") ?>" data-1x="img/flex-admin-logo@1x.png" data-2x="img/flex-admin-logo@2x.png" class="hisrc img-responsive" alt="">-->
                    </a>
                </div>
            </div>
            <!-- end BRAND HEADING -->

            <div class="nav-top">

                <!-- begin LEFT SIDE WIDGETS -->
                <ul class="nav navbar-left">
                    <li class="tooltip-sidebar-toggle">
                        <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Sidebar Toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <!-- You may add more widgets here using <li> -->
                </ul>
                <!-- end LEFT SIDE WIDGETS -->

                <!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
                <ul class="nav navbar-right">

                    <!-- begin MESSAGES DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="messages-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope"></i>
                            <span class="number">4</span> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-scroll dropdown-messages">

                            <!-- Messages Dropdown Heading -->
                            <li class="dropdown-header">
                                <i class="fa fa-envelope"></i> 4 New Messages
                            </li>

                            <!-- Messages Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
                            <li id="messageScroll">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    
                                                </div>
                                                <div class="col-xs-10">
                                                    <p>
                                                        <strong>Jane Smith</strong>: Hi again! I wanted to let you know that the order...
                                                    </p>
                                                    <p class="small">
                                                        <i class="fa fa-clock-o"></i> 12 minutes ago
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    
                                                </div>
                                                <div class="col-xs-10">
                                                    <p>
                                                        <strong>Roddy Austin</strong>: Thanks for the info, if you need anything from...
                                                    </p>
                                                    <p class="small">
                                                        <i class="fa fa-clock-o"></i> 3:39 PM
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    
                                                </div>
                                                <div class="col-xs-10">
                                                    <p>
                                                        <strong>Stacy Gibson</strong>: Hey, what was the purchase order number for the...
                                                    </p>
                                                    <p class="small">
                                                        <i class="fa fa-clock-o"></i> Yesterday at 10:23 AM
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    
                                                </div>
                                                <div class="col-xs-10">
                                                    <p>
                                                        <strong>Jeffrey Cortez</strong>: Check out this video I found the other day, it's...
                                                    </p>
                                                    <p class="small">
                                                        <i class="fa fa-clock-o"></i> Tuesday at 12:23 PM
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Messages Dropdown Footer -->
                            <li class="dropdown-footer">
                                <a href="mailbox.html">Read All Messages</a>
                            </li>

                        </ul>
                        <!-- /.dropdown-menu -->
                    </li>
                    <!-- /.dropdown -->
                    <!-- end MESSAGES DROPDOWN -->

                    <!-- begin ALERTS DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="alerts-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i> 
                            <span class="number">9</span><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-scroll dropdown-alerts">

                            <!-- Alerts Dropdown Heading -->
                            <li class="dropdown-header">
                                <i class="fa fa-bell"></i> 9 New Alerts
                            </li>

                            <!-- Alerts Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
                            <li id="alertScroll">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon green pull-left">
                                                <i class="fa fa-money"></i>
                                            </div>
                                            Order #2931 Received
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>3 minutes ago</em>
                                                </strong>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon blue pull-left">
                                                <i class="fa fa-comment"></i>
                                            </div>
                                            New Comments
                                            <span class="badge blue pull-right">15</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon orange pull-left">
                                                <i class="fa fa-wrench"></i>
                                            </div>
                                            Crawl Errors Detected
                                            <span class="badge orange pull-right">3</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon yellow pull-left">
                                                <i class="fa fa-question-circle"></i>
                                            </div>
                                            Server #2 Not Responding
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>5:25 PM</em>
                                                </strong>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon red pull-left">
                                                <i class="fa fa-bolt"></i>
                                            </div>
                                            Server #4 Crashed
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>3:34 PM</em>
                                                </strong>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon green pull-left">
                                                <i class="fa fa-plus-circle"></i>
                                            </div>
                                            New Users
                                            <span class="badge green pull-right">5</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon orange pull-left">
                                                <i class="fa fa-download"></i>
                                            </div>
                                            Downloads
                                            <span class="badge orange pull-right">16</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon purple pull-left">
                                                <i class="fa fa-cloud-upload"></i>
                                            </div>
                                            Server #8 Rebooted
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>12 hours ago</em>
                                                </strong>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="alert-icon red pull-left">
                                                <i class="fa fa-bolt"></i>
                                            </div>
                                            Server #8 Crashed
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>12 hours ago</em>
                                                </strong>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Alerts Dropdown Footer -->
                            <li class="dropdown-footer">
                                <a href="#">View All Alerts</a>
                            </li>

                        </ul>
                        <!-- /.dropdown-menu -->
                    </li>
                    <!-- /.dropdown -->
                    <!-- end ALERTS DROPDOWN -->

                    

                    <!-- begin USER ACTIONS DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i> {session_usuario} <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="profile.html">
                                    <i class="fa fa-user"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> Cambio rapido
                                    <span class="badge green pull-right">4</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-bell"></i> My Alerts
                                    <span class="badge orange pull-right">9</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tasks"></i> My Tasks
                                    <span class="badge blue pull-right">10</span>
                                </a>
                            </li>
                            <li>
                                <a href="calendar.html">
                                    <i class="fa fa-calendar"></i> My Calendar
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-gear"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a class="logout_open" href="#logout">
                                    <i class="fa fa-sign-out"></i> Logout
                                    <strong>{session_usuario}</strong>
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
        <nav class="navbar-side" role="navigation">
            <div class="navbar-collapse sidebar-collapse collapse">
                <ul id="side" class="nav navbar-nav side-nav">
                    
                    <!-- begin DASHBOARD LINK -->
                    <li>
                        <a class="active" href="<?= base_url("/") ?>">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <!-- end DASHBOARD LINK -->
                    <!-- begin Alarmas DROPDOWN -->
                    <li class="panel">
                        <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#alarmas">
                            <i class="fa fa-bell"></i> Alarmas <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="collapse nav" id="alarmas">
                            <li>
                                <a href="<?= site_url("alarma/listado") ?>">
                                    <i class="fa fa-angle-double-right"></i> Listado
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url("alarma/ingreso") ?>">
                                    <i class="fa fa-angle-double-right"></i> Ingresar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Alarmas DROPDOWN -->
                    <!-- begin Emergencias DROPDOWN -->
                    <li class="panel">
                        <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#emergencias">
                            <i class="fa fa-bullhorn"></i> Emergencias <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="collapse nav" id="emergencias">
                            <li>
                                <a href="<?= site_url("emergencia/listado") ?>">
                                    <i class="fa fa-angle-double-right"></i> Listado
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url("emergencia/ingreso") ?>">
                                    <i class="fa fa-angle-double-right"></i> Ingresar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Emergencias DROPDOWN -->
                    <!-- begin Emergencias DROPDOWN -->
                    <li class="panel">
                        <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#capas">
                            <i class="fa fa-globe"></i> Administrador de capas <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="collapse nav" id="capas">
                            <li>
                                <a href="<?= site_url("emergencia/listado") ?>">
                                    <i class="fa fa-angle-double-right"></i> Listado
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url("capas/ingreso") ?>">
                                    <i class="fa fa-angle-double-right"></i> Ingresar
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Emergencias DROPDOWN -->
                    <!-- begin Simulacion LINK -->
                    <li>
                        <a href="<?= base_url("/") ?>">
                            <i class="fa fa-flag-checkered"></i> Simulación
                        </a>
                    </li>
                    <!-- end Simulacion LINK -->
                    <!-- begin Documentacion LINK -->
                    <li>
                        <a href="<?= base_url("/") ?>">
                            <i class="fa fa-book"></i> Documentación
                        </a>
                    </li>
                    <!-- end Documentacion LINK -->
                    <!-- begin Emergencias DROPDOWN -->
                    <li class="panel">
                        <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#ayuda">
                            <i class="fa fa-question-circle "></i> Mesa de ayuda <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="collapse nav" id="ayuda">
                            <li>
                                <a href="<?= site_url() ?>">
                                    <i class="fa fa-angle-double-right"></i> Mensajes
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>">
                                    <i class="fa fa-angle-double-right"></i> Soportes pendientes
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>">
                                    <i class="fa fa-angle-double-right"></i> Soportes finalizados
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end Emergencias DROPDOWN -->
                </ul>
                <!-- /.side-nav -->
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <!-- /.navbar-side -->
        <!-- end SIDE NAVIGATION -->

        <!-- begin MAIN PAGE CONTENT -->
        <div id="page-wrapper">

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
    
    <?= loadJS("assets/lib/bootstrap-3.3.2-dist/js/bootstrap.js", true) ?>
    <?= loadJS("assets/lib/popupoverlay/jquery.popupoverlay.js", true) ?>
    <?= loadJS("assets/lib/popupoverlay/defaults.js", true) ?>
    <?= loadJS("assets/lib/popupoverlay/logout.js", true) ?>
    <?= loadJS("assets/js/jquery.jcombo.js", true) ?>
    <?= loadJS("assets/js/base.js") ?>
    <?= loadJS("assets/js/utils.js") ?>
    <?= loadJS("assets/js/loading.js") ?>
        <script type="text/javascript">
            $(document).ready(function () {
                Utils.listenerCambioRapido();
                Utils.toggleNavbarMethod();
                Utils.ajaxRequestMonitor();
                $(window).resize(Utils.toggleNavbarMethod);
            });
        </script>
    <!-- Logout Notification Box -->
    <div id="logout">
        <div class="logout-message">
            
            <h3>
                <i class="fa fa-sign-out text-green"></i> ¿Realmente desea salir?
            </h3>
            <p>Seleccione "Salir" si <br> desea cerrar la sesión actual.</p>
            <ul class="list-inline">
                <li>
                    <a href="login.html" class="btn btn-green">
                        <strong>Salir</strong>
                    </a>
                </li>
                <li>
                    <button class="logout_close btn btn-green">Cancel</button>
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
</body>

</html>
