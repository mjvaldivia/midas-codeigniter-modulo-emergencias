<form id="form-tipos-emergencia" name="form_tipos_emergencia" enctype="application/x-www-form-urlencoded" action="" method="post">
    
    <div class="row">
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_recursos" class="control-label">¿Dispone de recursos suficientes para controlar la emergencia?</label>

                <textarea  class="form-control" name="form_tipo_recursos" id="form_tipo_recursos"><?php echo $form_tipo_recursos; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_riesgo" class="control-label">¿Está en riesgo la seguridad de nuestro personal?</label>

                <textarea  class="form-control" name="form_tipo_riesgo" id="form_tipo_riesgo"><?php echo $form_tipo_riesgo; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 text-left">
            <div class="row">
                <div class="col-md-6 text-left">
                    <div class="form-group clearfix">
                        <label for="form_tipo_heridos" class="control-label">Número de heridos</label>

                        <input value="<?php echo $form_tipo_heridos; ?>" class="form-control" name="form_tipo_heridos" id="form_tipo_heridos">

                        <span class="help-block hidden"></span>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="form-group clearfix">
                        <label for="form_tipo_fallecidos" class="control-label">Número de fallecidos</label>

                        <input value="<?php echo $form_tipo_fallecidos; ?>" class="form-control" name="form_tipo_fallecidos" id="form_tipo_fallecidos">

                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_superada" class="control-label">¿En qué ha sido superada su capacidad para una respuesta eficiente y efectiva?</label>

                <textarea  class="form-control" name="form_tipo_superada" id="form_tipo_superada"><?php echo $form_tipo_superada; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_descripcion" class="control-label">Descrición del evento</label>

                <textarea  class="form-control" name="form_tipo_descripcion" id="form_tipo_descripcion"><?php echo $form_tipo_descripcion; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_acciones" class="control-label">Acciones</label>

                <textarea  class="form-control" name="form_tipo_acciones" id="form_tipo_acciones"><?php echo $form_tipo_acciones; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 text-left">
            <div class="form-group clearfix">
                <label for="form_tipo_informacion" class="control-label">Información adicional</label>

                <textarea  class="form-control" name="form_tipo_informacion" id="form_tipo_informacion"><?php echo $form_tipo_informacion; ?></textarea>

                <span class="help-block hidden"></span>
            </div>
        </div>
        
        <div class="col-md-6 text-left">
            <!--
            <div class="form-group">
                <label class="control-label">Antecedentes documentales</label>

                <input id="iDocMaterial" name="iDocMaterial[]" class="form-control" type="file" multiple data-show-preview="false"></input>

            </div>
            <div class="form-group ">
                <div class="small"> 
                    <table id="tabla_doc" class="table table-bordered table-striped dataTable table-hover table-condensed">
                        <thead>
                        <tr>
                            <th>Nombre Archivo</th>
                            <th>Autor</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>   
                </div>

            </div>
            -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="<?= $form_name ?>_error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
    
</form>

<?= loadJS("assets/js/modulo/alarma/form-tipo-emergencia/general.js") ?>