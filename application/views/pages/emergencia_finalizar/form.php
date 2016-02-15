<form  id="form-cerrar" name="form_cerrar" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    <div class="row">
        <div class="col-md-12 text-left">
            <div class="form-group clearfix">
                <label for="nombre-cierre" class="control-label">Nombre emergencia:</label>
                <div class="input-group col-sm-12">
                    <span><?php echo $nombre; ?></span>
                </div>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            <div class="form-group clearfix">
                <label for="fecha-cierre" class="control-label">Fecha cierre (*):</label>
                <div class="input-group col-sm-4" id="div-fecha" type="datetime">
                    <input value="<?php echo $fecha; ?>" class="form-control datepicker" placeholder="Fecha / Hora" name="fecha_cierre" id="fecha-cierre" >
                    <div class="input-group-addon" style="cursor: pointer">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            <div class="form-group clearfix">
                <label for="comentarios-cierre" class="control-label">Comentarios (*):</label>
                <div class="input-group col-sm-12">
                    <textarea name="comentarios_cierre" id="comentarios_cierre" class="form-control" rows="10"></textarea>
                </div>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="form-cerrar-error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-md-12">
            <div class="text-right">
                <button type="button" class="btn btn-default" onclick="xModal.close();">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="Emergencia.finalizarEvento(this.form,this);">Finalizar</button>
            </div>
        </div>
    </div>-->
</form>

