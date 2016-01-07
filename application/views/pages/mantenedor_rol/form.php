<form id="form-rol" name="form_rol" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    
    <div class="row">

        <div class="col-md-12 text-left">
            <div class="form-group clearfix">
                <label for="rut" class="control-label">Nombre (*):</label>
                <div class="input-group col-sm-12">
                    <input value="<?php echo $nombre; ?>" class="form-control" placeholder="" name="nombre" id="nombre">
                </div>
                <span class="help-block hidden"></span>
            </div>
        </div>
               
  
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="form-rol-error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
</form>

