<form name="editar_elemento" id="editar_elemento">
    
    <div class="row">
        <div class="col-lg-4">TIPO:</div>
        <div class="col-lg-8"><?php echo $tipo; ?></div>
    </div>
    
    <?php foreach($propiedades as $nombre => $valor){ ?>
    
    <div class="row top-spaced">
        <div class="col-lg-4"><?php echo $nombre; ?>:</div>
        <div class="col-lg-8"><input class="form-control" type="text" name="<?php echo $this->nombre; ?>" value="<?php echo utf8_encode($valor); ?>"></div>
    </div>
    
    <?php } ?>
    
    <div class="row top-spaced">
        <div class="col-lg-4"> Color </div>
        <div class="col-lg-8"> <input name="color_editar" id="color_editar" placeholder="Color del poligono" type='text' class="colorpicker required" value="<?php echo $color; ?>"/> </div>
    </div>
    
</form>

