<?= loadJS("assets/js/library/jquery-2.1.4/jquery.min.js", true) ?>
<!-- GLOBAL STYLES - Include these on every page. -->
<?= loadCSS("assets/js/library/bootstrap-3.3.2-dist/css/bootstrap.css", true) ?>
<?= loadCSS("assets/js/library/font-awesome-4.4.0/css/font-awesome.css", true) ?>

<?= loadCSS("assets/css/style.css", true) ?>

<body style="background-color: #fff">
<div class="col-xs-12">
    <form class="form-inline" role="form" enctype="multipart/form-data" name="form_adjunto" id="form_adjunto" action="<?php echo site_url('soportes/cargarAdjunto');?>" method="post">
        
            <div class="input-group" style="width:80%">
                <input type="text" name="nombre_adjunto" id="nombre_adjunto" class="form-control" readonly  onclick='$("#adjunto").click();' >
                <span class="input-group-addon" onclick='$("#adjunto").click();'><i class="fa fa-file"></i></span>
                    
            </div>
            <input type="file" name="adjunto" id="adjunto" class="form-control" style="display:none" onchange='Soportes.mostrarNombreAdjunto(this.value);' />
            
            <button type="button" class="btn btn-green btn-square " onclick="this.form.submit();">Agregar</button>
            <button type="button" class="btn btn-default btn-square" onclick="parent.Soportes.cargarGrillaAdjuntos();parent.ModalSipresa.close_modal('modal_agregar_adjunto');">Cerrar</button>
  
        
        </div>
    </form>
    <?php if($mensaje):?>
        <?php if($error):?>
        <div class="col-xs-12"><div class="alert alert-danger small"><i class="fa fa-times-circle"></i> <?php echo $mensaje?></div>
        <?php else:?>
        <div class="col-xs-12"><div class="alert alert-success small"><i class="fa fa-check-circle"></i> <?php echo $mensaje?></div>
        <?php endif;?>
    <?php endif;?>
</div>
</div>

<?= loadJS("assets/js/soportes.js") ?>
