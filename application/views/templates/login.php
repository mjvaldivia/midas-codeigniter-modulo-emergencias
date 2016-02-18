<!DOCTYPE html>
<html lang="es">
<head>
    <title> MIDAS :: Módulo de emergencias</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Sumanet" />
    <meta name="description" content="Módulo de emergencias" />
    
    <?= loadCSS("assets/js/library/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>
</head>
<body class="login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-banner text-left">
                    <div class="row">
                        <div class="col-xs-4">
                            <img src="<?php echo base_url("/assets/img/top_logo.png"); ?>" style="width: 100%" />
                        </div>
                        <div class="col-xs-8">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong>MIDAS</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    Módulo emergencias
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet portlet-green">
                    <div class="portlet-heading login-heading">
                        <div class="portlet-title">
                            <h4><strong>Ingresa</strong>
                            </h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <form role="form" action="<?php echo base_url("login/procesar"); ?>" method="post">
                            <fieldset>
                                <input name="requesturl" type="hidden" value="/">
                                <div class="form-group">
                                    <input class="form-control" placeholder="usuario" name="username" id="username" type="text" />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="contraseña" name="password" id="password" type="password" />
                                </div>
                                
                                <?php if($error) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $mensaje; ?>
                                </div>
                                <?php } ?>
                                
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
                            </fieldset>
                            <br>
                            <!--<p class="small">
                                <a href="javascript:void(0)" onclick="<?php echo  base_url("login/recuperar"); ?>">¿Olvidaste tu password?</a>
                            </p>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>
    <footer>
        <script type='text/javascript' src="<?= base_url("/assets/js/library/jquery-2.1.4/jquery.min.js") ?>"></script>
        <?= loadJS("assets/js/library/bootstrap-3.3.5/js/bootstrap.js", true) ?>
    </footer>
</html>
    
    
    
    
    
    
    
    
    
    
