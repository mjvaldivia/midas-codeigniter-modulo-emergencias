<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">Nuevo Ticket Soporte</div>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form">
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
            </form>
        </div>
        <div class="modal-footer">
            <div class="text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="Soportes.enviarSoporte(this.form,this);">Enviar</button>
            </div>
        </div>
    </div>
</div>