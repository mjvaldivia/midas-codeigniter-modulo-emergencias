
<div class="col-xs-12">
<div class="well">
<h3 class="">Nuevo ticket soporte</h3>
<form class="form-horizontal" role="form" id="form_soporte">
    <div class="form-group">
        <label class="col-xs-12">Asunto</label>
        <div class="col-xs-12">
            <input type="text" class="form-control" name="asunto_soporte" id="asunto_soporte" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-12">Mensaje</label>
        <div class="col-xs-12">
            <textarea class="form-control" rows="5" name="texto_soporte" id="texto_soporte"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox col-xs-12">
            <label>
                <input type="checkbox" value="1" name="email_soporte" id="email_soporte"/> Aviso de respuesta a mi correo
            </label>
        </div>
    </div>
    <div class="alert alert-danger" style="display:none"></div>
    <div class="text-right">
        <button type="button" class="btn btn-default" onclick="ModalSipresa.close_modal('modal_nuevo_soporte')">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Soportes.enviarSoporte(this.form,this);">Enviar</button>
    </div>
</form>
</div>
</div>