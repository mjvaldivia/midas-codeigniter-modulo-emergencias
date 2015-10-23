<?= loadJS("assets/js/jquery.flip.js",true) ?>
<script>
$(document).ready(function(){    
$(".panel" ).hover(
	  function() {
		$(this).find(".card").flip(true);   
	  }, function() {
		$(this).find(".card").flip(false);   
	  }
	);   
   
	$(".card").flip({
	  trigger: 'manual',
	  axis: 'y',
	  reverse: true
	}); 
    });      
</script>
<div id="contenido" class="col-xs-12 col-lg-12">
    <legend>Dashboard</legend>
    <div class="row">
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-warning" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("alarma/ingreso") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-bell fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Alarmas</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>Ingresar y listar Alarmas</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("alarma/ingreso") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-danger" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("emergencia/listado") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-bullhorn fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Emergencias</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>listar y editar Emergencias</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("emergencia/listado") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-info" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("capas/ingreso") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-globe fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Administrador de Capas</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>listar y editar capas</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("capas/ingreso") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-success" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("#") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-flag-checkered fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Simulación</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>Simular situación de emergencia</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("#") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-info" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("#") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-book fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Documentación</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>&nbsp;</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("#") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>
        <div class="col-lg-3 margin-remove">
            <div class="col-xs-12 ">


                <div class="panel panel-info" style="border-radius:5px">


                    <div style="cursor:pointer" class="panel-heading" onclick='window.location.href="<?= site_url("#") ?>"'>


                        <div class="row">
                            <div class="col-xs-4" style="height:65px">
                                <div class="flip" style="perspective: 114px; position: relative; margin: 0px; width: 57px; height: 60px;"><div class="card" style="transform-style: preserve-3d; transition: all 0.5s ease-out; margin: 0px; transform: rotateX(0deg);">
                                        <i class="fa fa-envelope fa-4x icono"></i>
                                    </div></div>
                            </div>

                            <div class="col-xs-8 text-center">
                                <h4>Mesa de Ayuda</h4>
                            </div>
                        </div>
                        <div class="row top-spaced">
                            <div class="col-xs-12 text-left">
                                <h6>Soporte al usuario</h6>
                                <input type="text" class="hide" value="">
                            </div>
                        </div>				
                    </div>
                    <a href="<?= site_url("#") ?>" data-original-title="" title="" target="_self">
                        <div class="panel-footer">
                            <span class="pull-left">
                                Ir

                            </span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>

                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>		
        </div>

        
        


    </div>



</div>