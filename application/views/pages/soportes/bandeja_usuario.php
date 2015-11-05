<div class="row">
    
    <div class="col-xs-12">
        <h3 class="page-header">
            Mensajes de Soporte
            <button class="btn btn-primary pull-right" type="button" onclick="Soportes.nuevoSoporte();">Ingresar nuevo ticket</button>
        </h3>
    </div>

    <div class="table-responsive col-xs-12">
        <table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($soportes as $item):?>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <?php endforeach;?>
            </tbody>    
        </table>
    </div>

</div>


<div class="modal fade" id="modal_nuevo_soporte" style="display:none;">
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
                    <div class="form-group">
                        <label class="col-xs-12">Agregar adjuntos <button type="button" class="btn btn-primary btn-sm" onclick="Soportes.agregarAdjunto();"><i class="fa fa-plus"></i></button></label>
                        <div class="col-xs-12" id="listado_adjuntos">
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
</div>




<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadJS("assets/js/soportes.js") ?>

<script type="text/javascript">
    $(document).ready(function () {
        Soportes.init();
        
    });
</script>