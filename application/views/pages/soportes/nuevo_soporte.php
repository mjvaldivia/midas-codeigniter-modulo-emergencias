<div class="col-xs-12">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Nuevo Ticket de Soporte</h4>
            </div>
        </div>
        <div class="portlet-body">
            <div class="col-xs-12">
                <form class="form-horizontal" role="form" id="form_soporte">
                    <div class="form-group">
                        <label class="col-xs-12">Asunto</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control" name="asunto_soporte" id="asunto_soporte" placeholder="Escriba el asunto de su ticket" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12">Mensaje</label>
                        <div class="col-xs-12">
                            <textarea class="form-control" rows="5" name="texto_soporte" id="texto_soporte" placeholder="Escriba el texto/mensaje de su ticket"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php $url = site_url('soportes/agregarAdjunto');?>
                        <label class="col-xs-12">Agregar adjunto <a class="btn btn-blue btn-xs modal-sipresa btn-square" href="<?php echo $url?>" data-toggle="modal" data-target="#modal_agregar_adjunto"><i class="fa fa-plus"></i></a></label>
                        <div class="small col-xs-12" id="contenedor-adjuntos"></div>
                    </div>
                    <div class="text-right">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" value="1" name="email_soporte" id="email_soporte"/> Aviso de respuesta a mi correo
                            </label>
                        </div>
                        <button type="button" class="btn btn-green btn-square" onclick="Soportes.enviarSoporte(this.form,this);">Enviar</button>
                        <button type="button" class="btn btn-default btn-square" onclick="ModalSipresa.close_modal('modal_nuevo_soporte')">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





