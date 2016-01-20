<form name="editar_elemento" id="editar_elemento">
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-4"><strong>ELEMENTO:</strong></div>
            <div class="col-lg-8"><?php echo $tipo; ?></div>
        </div>
        <div class="row top-spaced">
            <div class="col-lg-4"><strong>COLOR:</strong></div>
            <div class="col-lg-8"><input name="color_editar" id="color_editar" placeholder="Color del poligono" type='text' class="colorpicker required" value="<?php echo $color; ?>"/></div>
        </div>
    </div>
    <div class="col-lg-6">
    <?php foreach($propiedades as $nombre => $valor){ ?>
            <div class="row">
                <div class="col-lg-4"><strong><?php echo $nombre; ?>:</strong></div>
                <div class="col-lg-8"><input class="form-control" type="text" name="<?php echo $this->nombre; ?>" value="<?php echo utf8_encode($valor); ?>"></div>
            </div>
    <?php } ?>
    </div>
</form>