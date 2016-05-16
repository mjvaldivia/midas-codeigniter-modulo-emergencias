<div class="row">
    <div class="col-xs-6">
        <div class="form-group clearfix">
            <label for="<?php echo $prefijo ?>_tipo" class="control-label">Tipo:</label>
            <select name="<?php echo $prefijo ?>_tipo"  id="<?php echo $prefijo ?>_tipo" class="form-control formulario-coordenadas" data-rel="<?php echo $prefijo ?>">
                <option value="decimal"> Grados decimales </option>
                <option value="gms"> Grados, minutos y segundos </option>
                <option value="utm"> UTM </option>
            </select>
            <span class="help-block hidden"></span>
        </div>
    </div>
</div>

<div class="row">
    <div id="<?php echo $prefijo ?>_contenedor_gms" class="hidden">
        <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-1" style="padding-top:25px">
                1
            </div>
            <div class="col-xs-3">
                <div class="form-group clearfix">
                    <label for="<?php echo $prefijo ?>_gms_grados" class="control-label">Grados(*):</label>
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="<?php echo $prefijo ?>_gms_grados_lat" id="<?php echo $prefijo ?>_gms_grados_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <label for="<?php echo $prefijo ?>_gms_minutos" class="control-label">Minutos(*):</label>
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="<?php echo $prefijo ?>_gms_minutos_lat" id="<?php echo $prefijo ?>_gms_minutos_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <label for="<?php echo $prefijo ?>_gms_segundos" class="control-label">Segundos(*):</label>
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="<?php echo $prefijo ?>_gms_segundos_lat" id="<?php echo $prefijo ?>_gms_segundos_lat" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-1" style="padding-top:10px">
                2
            </div>
            <div class="col-xs-3">
                <div class="form-group clearfix">
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="<?php echo $prefijo ?>_gms_grados_lng" id="<?php echo $prefijo ?>_gms_grados_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="<?php echo $prefijo ?>_gms_minutos_lng" id="<?php echo $prefijo ?>_gms_minutos_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-group clearfix">
                    <input type="text" class="form-control <?php echo $prefijo ?>_gms_input" name="form_coordenadas_gms_segundos_lng" id="<?php echo $prefijo ?>_gms_segundos_lng" value="">
                    <span class="help-block hidden"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div id="<?php echo $prefijo ?>_contenedor_utm" class="hidden">
        <div class="col-xs-4">
            <div class="form-group clearfix">
                <label for="<?php echo $prefijo ?>_utm_zona" class="control-label">Zona(*):</label>
                <select class="form-control" name="<?php echo $prefijo ?>_utm_zona" id="<?php echo $prefijo ?>_utm_zona">
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
                <label for="<?php echo $prefijo ?>_utm_minutos" class="control-label">Este (*):</label>
                <input type="text" placeholder="" class="form-control <?php echo $prefijo ?>_utm_input" name="<?php echo $prefijo ?>_utm_latitud" id="<?php echo $prefijo ?>_utm_latitud" value="">
                <span class="help-block">(5 digitos)</span>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group clearfix">
                <label for="<?php echo $prefijo ?>_utm_longitud" class="control-label">Norte (*):</label>
                <input type="text" placeholder="" class="form-control <?php echo $prefijo ?>_utm_input" name="<?php echo $prefijo ?>_utm_longitud" id="<?php echo $prefijo ?>_utm_longitud" value="">
                <span class="help-block">(6 digitos)</span>
            </div>
        </div>
    </div>
    
    <div id="<?php echo $prefijo ?>_mensaje">
        <div class="col-xs-12">
            <h5><strong>Conversión a grados decimales</strong></h5>
        </div>
    </div>
    
    <div>
        <div class="col-xs-6">
            <div class="form-group clearfix">
                <label for="<?php echo $prefijo ?>_latitud" class="control-label">Latitud(*):</label>
                <input type="text" class="form-control <?php echo $prefijo ?>_mapa_coordenadas" name="<?php echo $prefijo ?>_latitud" id="<?php echo $prefijo ?>_latitud" value="<?php echo $latitud; ?>">
     
                <span class="help-block hidden"></span>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group clearfix">
                <label for="<?php echo $prefijo ?>_longitud" class="control-label">Longitud(*):</label>
                <input type="text" class="form-control <?php echo $prefijo ?>_mapa_coordenadas" name="<?php echo $prefijo ?>_longitud" id="<?php echo $prefijo ?>_longitud" value="<?php echo $longitud; ?>">

                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
</div>