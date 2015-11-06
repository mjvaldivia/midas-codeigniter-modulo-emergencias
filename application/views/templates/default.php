<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Emergencias::MIDAS</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>
    <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
    <?= loadCSS("assets/lib/pace/pace.css", true) ?>
    <?= loadJS("assets/lib/pace/pace.js", true) ?>

    <?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <?= loadCSS("assets/lib/bootstrap-3.3.2-dist/css/bootstrap.css", true) ?>
    <?= loadCSS("assets/lib/qtip/jquery.qtip.min.css", true) ?>
    
   <!-- <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    -->
        <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>


    <!-- THEME STYLES - Include these on every page. -->
    <?= loadCSS("assets/css/style.css", true) ?>
    <?= loadJS("assets/js/Modal_Sipresa.js") ?>
    
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
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                    <i class="fa fa-bars"></i> Menu
                </button>
                <div class="navbar-brand">
                    <a href="index.html" style="color: #FFF">
                       <img src="<?php echo base_url("/assets/img/logo_visor.jpg") ?>" /> Emergencias
                       <!-- <img src="<?php echo base_url("/assets/img/top_logo.png") ?>" data-1x="img/flex-admin-logo@1x.png" data-2x="img/flex-admin-logo@2x.png" class="hisrc img-responsive" alt="">-->
                    </a>
                </div>
            </div>
            <!-- end BRAND HEADING -->

            <div class="nav-top">

                <!-- begin LEFT SIDE WIDGETS -->
                <ul class="nav navbar-left">
                    <li class="tooltip-sidebar-toggle">
                        <a href="#" id="sidebar-toggle" data-toogle-param="abajo" data-toggle="tooltip" data-placement="right" title="Ocultar menu">
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
                            <!--<span class="number">4</span> <i class="fa fa-caret-down"></i>-->
                        </a>
                        <ul class="dropdown-menu dropdown-scroll dropdown-messages">

                            <!-- Messages Dropdown Heading -->
                            <li class="dropdown-header">
                                <i class="fa fa-envelope"></i> No hay mensajes nuevos
                            </li>

                            <!-- Messages Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
                           <!-- <li id="messageScroll">
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
                            

                            
                            <li class="dropdown-footer">
                                <a href="mailbox.html">Read All Messages</a>
                            </li>
                            -->

                        </ul>
                        <!-- /.dropdown-menu -->
                    </li>
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
                                    <i class="fa fa-cog"></i> {session_cargo}
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-globe"></i> {session_region}
                                </a>
                            </li>
                            
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
        <nav class="navbar-side" role="navigation">
            <div class="navbar-collapse sidebar-collapse collapse">
                <ul id="side" class="nav navbar-nav side-nav">
                    <?= menuRender() ?>
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
    <?= loadJS("assets/lib/livequery/jquery.livequery.min.js", true) ?>
    <?= loadJS("assets/lib/popupoverlay/defaults.js", true) ?>
    <?= loadJS("assets/lib/popupoverlay/logout.js", true) ?>
    <?= loadJS("assets/js/jquery.jcombo.js", true) ?>
    <?= loadJS("assets/lib/qtip/jquery.qtip.min.js", true) ?>
    <?= loadCSS("assets/lib/select2-4.0.0/css/select2.css", true) ?>
    <?= loadJS("assets/lib/select2-4.0.0/js/select2.js", true) ?>
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
