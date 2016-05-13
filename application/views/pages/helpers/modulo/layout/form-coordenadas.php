<div class="row">
    <div class="col-xs-6">
        <div class="form-group clearfix">
            <label for="nombre" class="control-label">Tipo:</label>
            <select name="form_coordenadas_tipo"  id="form_coordenadas_tipo" class="form-control">
                <option value="decimal"> Grados decimales </option>
                <option value="gms"> Grados, minutos y segundos </option>
                <option value="utm"> UTM </option>
            </select>
            <span class="help-block hidden"></span>
        </div>
    </div>
</div>

<div class="row">
    <div id="form_coordenadas_gms" class="hidden">
        <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <label for="form_coordenadas_gms_grados" class="control-label">Grados(*):</label>
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_grados_lat" id="form_coordenadas_gms_grados_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <label for="form_coordenadas_gms_minutos" class="control-label">Minutos(*):</label>
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_minutos_lat" id="form_coordenadas_gms_minutos_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <label for="form_coordenadas_gms_segundos" class="control-label">Segundos(*):</label>
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_segundos_lat" id="form_coordenadas_gms_segundos_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_grados_lng" id="form_coordenadas_gms_grados_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_minutos_lng" id="form_coordenadas_gms_minutos_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <input type="text" class="form-control form_coordenadas_gms_input" name="form_coordenadas_gms_segundos_lng" id="form_coordenadas_gms_segundos_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div id="form_coordenadas_utm" class="hidden">
        <div class="col-xs-4">
            <div class="form-group clearfix">
                <label for="form_coordenadas_utm_zona" class="control-label">Zona(*):</label>
                <select class="form-control" name="form_coordenadas_utm_zona" id="form_coordenadas_utm_zona">
                    <option value="19H"> 19H </option>
                    <option value="18H"> 18H </option>
                    <option value="15H"> 15H </option>
                    <option value="12H"> 12H </option>
                </select>
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group clearfix">
                <label for="form_coordenadas_utm_minutos" class="control-label">Latitud(*):</label>
                <input type="text" class="form-control form_coordenadas_utm_input" name="form_coordenadas_utm_latitud" id="form_coordenadas_utm_latitud" value="">
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group clearfix">
                <label for="form_coordenadas_utm_longitud" class="control-label">Longitud(*):</label>
                <input type="text" class="form-control form_coordenadas_utm_input" name="form_coordenadas_utm_longitud" id="form_coordenadas_utm_longitud" value="">
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div>
        <div class="col-xs-6">
            <div class="form-group clearfix">
           
                    <label for="nombre" class="control-label">Latitud(*):</label>
                    <input type="text" class="form-control mapa-coordenadas" name="latitud" id="latitud" value="<?php echo $latitud; ?>">
     
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group clearfix">
    
                <label for="nombre" class="control-label">Longitud(*):</label>
                <input type="text" class="form-control mapa-coordenadas" name="longitud" id="longitud" value="<?php echo $longitud; ?>">

                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
</div>