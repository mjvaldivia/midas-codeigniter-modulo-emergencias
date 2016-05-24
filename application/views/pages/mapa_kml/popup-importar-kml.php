<form name="form_importar_kml" id="form_importar_kml">
    
    <div class="row top-spaced mostrar-al-subir">
        <div class="col-lg-12 text-center">
            Subiendo archivo
        </div>
    </div>
    
    <div class="row top-spaced">
        <div class="col-lg-12">
            <div class="form-group clearfix ocultar-al-subir">
                <label for="nombre" class="control-label">Descripción (*):</label>
                <input value="" class="form-control" name="nombre" id="nombre">
                <span class="help-block hidden"></span>
            </div>
            <div class="form-group clearfix">
                <label for="input_kml" class="control-label ocultar-al-subir">Seleccionar archivo kml (*):</label>
                <input id="input_kml" name="input_kml" class="form-control ocultar-al-subir"  type="file" data-show-preview="false">
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="form_error" class="alert alert-danger hidden">
                <strong> Existen problemas con los datos ingresados </strong> <br>
                Revise y corrija los campos iluminados en rojo.
            </div>
        </div>
    </div>
    
</form>

