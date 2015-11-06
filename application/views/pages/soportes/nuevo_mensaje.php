
<div class="col-xs-12">
<div class="well">
<h3 class="">Nuevo Mensaje para ticket <?php echo $soporte->soporte_codigo?></h3>
<form class="form-horizontal" role="form" id="form_soporte">
    <input type="hidden" name="id_soporte" id="id_soporte" value="<?php echo $soporte->soporte_id?>" />
    <input type="hidden" name="usuario_soporte" id="usuario_soporte" value="<?php echo $soporte->soporte_usuario_fk?>" />
    <div class="form-group">
        <label class="col-xs-12">Mensaje</label>
        <div class="col-xs-12">
            <textarea class="form-control" rows="5" name="texto_mensaje" id="texto_mensaje"></textarea>
        </div>
    </div>
    <div class="form-group">
        <?php $url = site_url('soportes/agregarAdjunto');?>
        <label class="col-xs-12">Agregar adjunto <a class="btn btn-primary btn-xs modal-sipresa" href="<?php echo $url?>" data-toggle="modal" data-target="#modal_agregar_adjunto"><i class="fa fa-plus"></i></a>
        <div class="small" id="contenedor-adjuntos"></div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-default" onclick="ModalSipresa.close_modal('modal_nuevo_mensaje')">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Soportes.enviarMensaje(this.form,this);">Enviar</button>
    </div>
</form>
</div>
</div>