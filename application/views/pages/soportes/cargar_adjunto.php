<?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
<!-- GLOBAL STYLES - Include these on every page. -->
<?= loadCSS("assets/lib/bootstrap-3.3.2-dist/css/bootstrap.css", true) ?>
<?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>

<div class="col-xs-12" style="margin-top:20px">
<form class="form-inline" role="form" enctype="multipart/form-data" name="form_adjunto" id="form_adjunto" action="<?php echo site_url('soportes/cargarAdjunto');?>" method="post">
    <div class="form-group">
        <label class="col-xs-12">Seleccione adjunto a agregar</label>
        <input type="file" name="adjunto" id="adjunto" class="form-control"/>

        <button type="button" class="btn btn-primary" onclick="parent.Soportes.cargarGrillaAdjuntos();parent.ModalSipresa.close_modal('modal_agregar_adjunto');">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="this.form.submit();">Agregar</button>
        
    </div>
    
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