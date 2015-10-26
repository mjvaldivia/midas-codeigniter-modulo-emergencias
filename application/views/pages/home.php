<style>
    #contenido li{list-style:none;-webkit-box-shadow:0 1px 3px 0 #000;-moz-box-shadow:0 1px 3px 0 #000;box-shadow:0 1px 3px 0 #000;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-transition-duration:.2s;-moz-transition-duration:.2s;-o-transition-duration:.2s;-ms-transition-duration:.2s;transition-duration:.2s;}
    #contenido li:hover{color:#000;-webkit-box-shadow:0 2px 7px 0 #000;-moz-box-shadow:0 2px 7px 0 #000;box-shadow:0 2px 7px 0 #000;}
    ul:hover li:not(:hover){opacity:.9;-webkit-box-shadow:0 1px 1px 0 #000;-moz-box-shadow:0 1px 1px 0 #000;box-shadow:0 1px 1px 0 #000;}
</style>
<div id="contenido" class="col-xs-12 col-lg-12">
    <legend>Dashboard</legend>
    <ul class="row">

        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-warning" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href = "<?= site_url("alarma/ingreso") ?>"'>


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-bell fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Alarmas</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>ingresar y listar alarmas</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
        
        
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-danger" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href = "<?= site_url("emergencia/listado") ?>"'>


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-bullhorn fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Emergencia</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>listar y editar emergencias</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
        
        
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-info" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href = "<?= site_url("capas/ingreso") ?>"'>


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-globe fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Administrador de Capas</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>listar y editar capas</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
        
        
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-success" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick=''>


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-flag-checkered fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Simulación </h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>simular situación de emergencia</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
        
        
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-info" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" >


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-book fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Documentación</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>documentos en línea</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
        
        
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">
                <li class="panel panel-success" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" >


                        <div class="row">
                            <div class="col-xs-12 text-center" style="height:65px">

                                <i class="fa fa-question-circle fa-5x icono"></i>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Mesa de ayuda</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-center">
                                <h6>soporte al usuario</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                </li>  
            </div>
        </div>
        
    </ul>


</div>