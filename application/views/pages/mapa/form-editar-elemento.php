<form name="editar_elemento" id="editar_elemento">
    <div class="col-lg-6">
        <h4><small><i class="fa fa-info-circle"></i> Información de la capa</small></h4>
        <div class="tile dark-blue">
        <div class="row">
            <div class="col-lg-4 text-right"><strong>ELEMENTO:</strong></div>
            <div class="col-lg-8 text-left"><?php echo $tipo; ?></div>
        </div>
        <div class="row top-spaced">
            <div class="col-lg-4 text-right"><strong>COLOR:</strong></div>
            <div class="col-lg-8 text-left"><input name="color_editar" id="color_editar" placeholder="Color del poligono" type='text' class="colorpicker required" value="<?php echo $color; ?>"/></div>
        </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-12">
            <h4>
                <div class="pull-left">
                    <small><i class="fa fa-list"></i> Propiedades de la capa</small>
                </div>
                <div class="pull-right">
                    <button id="add-propiedad" class="btn btn-xs btn-primary"> <i class="fa fa-plus"></i> Agregar propiedad </button>
                </div>
                <div class="clearfix"></div>
            </h4>
            </div>
        </div>
        <div id="div-propiedades" class="tile blue">
        <?php foreach($propiedades as $nombre => $valor){ ?>
            <div class="row">
                <div class="col-lg-4 text-right">
                    <?php if($nombre == "NOMBRE") { ?>
                        <input type="hidden" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
                        <strong><?php echo $nombre; ?></strong>
                    <?php } else { ?>
                        <?php if($tipo == "CIRCULO LUGAR EMERGENCIA" AND $nombre == "TIPO") { ?>
                              <input type="hidden" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
                              <strong><?php echo $nombre; ?></strong>
                        <?php } else { ?>
                            <input type="text" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="col-lg-1 text-left">:</div>
                <div class="col-lg-6 text-left">
                    <?php if($tipo == "CIRCULO LUGAR EMERGENCIA" AND $nombre == "TIPO") { ?>
                    <input class="form-control propiedades" type="hidden" name="parametro_valor[]" value="<?php echo $valor; ?>">
                    <strong><?php echo $valor; ?></strong>
                    <?php } else { ?>
                    <input class="form-control propiedades" type="text" name="parametro_valor[]" value="<?php echo $valor; ?>">
                    <?php } ?>
                </div>
                <div class="col-lg-1 text-left">
                    <?php if($nombre == "NOMBRE"  OR ($tipo == "CIRCULO LUGAR EMERGENCIA" AND $nombre == "TIPO")) { ?>
                    
                    <?php } else { ?>
                    <button class="btn btn-xs btn-danger remove-propiedad"><i class="fa fa-remove"></i></button>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</form>