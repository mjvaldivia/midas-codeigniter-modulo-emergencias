<form name="editar_elemento" id="editar_elemento">
    
    <input type="hidden" name="elemento_tipo" id="elemento_tipo" value="<?php echo $tipo; ?>" />
    <input type="hidden" name="elemento_identificador" id="elemento_identificador" value="<?php echo $identificador; ?>" />
    <input type="hidden" name="elemento_clave" id="elemento_clave" value="<?php echo $clave; ?>" />
    
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-12">
                <h4>
                    <div class="pull-left">
                        <small><i class="fa fa-info-circle"></i> Información de la capa</small>
                    </div>
                    <div class="pull-right">
                        <button id="exportar-elemento-kmz" class="btn btn-xs btn-primary"> <i class="fa fa-download"></i> Exportar a KMZ </button>
                    </div>
                    <div class="clearfix"></div>
                </h4>
            </div>
        </div>
        <div class="tile dark-blue">
            <div class="row">
                <div class="col-lg-3 text-right">
                    <strong>ELEMENTO:</strong>
                </div>
                <div class="col-lg-9 text-left">
                    <?php echo $tipo; ?>
                </div>
            </div>
            <div class="row top-spaced">
                <div class="col-lg-3 text-right">
                    <strong>COLOR:</strong>
                </div>
                <div class="col-lg-9 text-left">
                    <input name="color_editar" id="color_editar" placeholder="Color del poligono" type='text' class="colorpicker required" value="<?php echo $color; ?>"/>
                </div>
            </div>
            <?php // if(permisoEvento("editar")) { ?>
            <!--<div class="row top-spaced">
                <div class="col-lg-3 text-right">
                    <strong>MOVER:</strong>
                </div>
                <div class="col-lg-3 text-left">
                    <select name="editar_mover" id="editar_mover" class="form-control">
                        <option value="No" selected>No</option>
                        <option value="1">Al frente</option>
                        <option value="1">Al fondo</option>
                    </select>
                </div>
            </div>-->
            <?php // } ?>
            <?php if($editar_forma && permisoEvento("editar")) { ?>
            <div class="row top-spaced">
                <div class="col-lg-3 text-right">
                    <strong>EDITAR FORMA:</strong>
                </div>
                <div class="col-lg-3 text-left">
                    <select name="editar_forma" id="editar_forma" class="form-control">
                        <option value="No">No</option>
                        <option value="Si">Si</option>
                    </select>
                </div>
            </div>
            <?php } ?>
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
        <div id="div-propiedades" class="tile gray">
        <?php foreach($propiedades as $nombre => $valor){ ?>
            <div class="row">
                <div class="col-lg-3 text-right">
                    <?php if($nombre == "NOMBRE") { ?>
                        <input type="hidden" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
                        <strong><?php echo $nombre; ?></strong>
                    <?php } else { ?>
                        <input type="text" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
                    <?php } ?>
                </div>
                <div class="col-lg-1 text-center">:</div>
                <div class="col-lg-7 text-left">
                    <input class="form-control propiedades" type="text" name="parametro_valor[]" value="<?php echo $valor; ?>">
                </div>
                <div class="col-lg-1 text-left">
                    <?php if(!($nombre == "NOMBRE")) { ?>
                        <button class="btn btn-xs btn-danger remove-propiedad"><i class="fa fa-remove"></i></button>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</form>