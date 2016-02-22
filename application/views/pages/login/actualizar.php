<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Usuario
                <small><i class="fa fa-arrow-right"></i> Actualización de contraseña</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Usuario </li>
                <li class="active"><i class="fa fa-bell"></i> Contraseña </li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="portlet portlet-default">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-warning">
                            No ha actualizado su contraseña inicial.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form id="form" name="form" enctype="application/x-www-form-urlencoded" action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    <div class="form-group clearfix">
                                        <label for="password" class="control-label required">Nueva contraseña (*)</label>
                                        <input type="password" name="password_nuevo" id="password_nuevo" value="" class="form-control"/>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 text-left">
                                    <div class="form-group clearfix">
                                        <label for="password_repetido" class="control-label required">Repita la nueva contraseña (*)</label>
                                        <input type="password" name="password_repetido" id="password_repetido" value="" class="form-control"/>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="form-error" class="alert alert-danger hidden">
                                        <strong>Existen problemas en los datos</strong> <br> Verifique los datos ingresados y vuelva a intentarlo.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" id="guardar" class="btn btn-success btn-sm">
                                        <i class="fa fa-save"></i> Cambiar contraseña
                                    </button>
                                    <button type="button" id="cancelar" onclick="location.href='<?php echo base_url("login/index"); ?>'" class="btn btn-white btn-sm">
                                        <i class="fa fa-remove"></i> Omitir 
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= loadJS("assets/js/login-actualizar-password.js", true) ?>