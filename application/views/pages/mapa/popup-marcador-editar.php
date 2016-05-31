<form name="editar_marcador" id="editar_marcador">
    <input type="hidden" name="id_marcador" id="id_marcador" value="<?php echo $id; ?>"/>
    <input type="hidden" name="clave_marcador" id="clave_marcador" value="<?php echo $clave; ?>"/>
    
<div class="col-lg-12">
    <div class="row">
         
        <div class="col-lg-12">
            <h4><small><i class="fa fa-map-marker"></i> Icono</small></h4>
        </div>
        
        <div class="col-lg-12">
            
            <input type="hidden" name="icono_name" id="icono_name" value="<?php echo $imagen["name"]; ?>" />
            <input type="hidden" name="icono_size" id="icono_size" value="<?php echo $imagen["size"]; ?>" />
            <input type="hidden" name="icono_type" id="icono_type" value="<?php echo $imagen["type"]; ?>" />
            <input type="hidden" name="icono_file" id="icono_file" value="<?php echo $imagen["file"]; ?>" />
            
            <input id="icono" name="icono" class="form-control"  type="file" data-show-preview="false">
           
        </div>
        <div class="col-lg-12 top-spaced">
            <?php if($bo_editor_texto) { ?>
            <legend> Contenido </legend>
            <textarea id="texto_marcador"><?php echo $html; ?></textarea>
            <?php } else { ?>
                <div class="row">
                    <div class="col-lg-12">
                    <h4>
                        <div class="pull-left">
                            <small><i class="fa fa-list"></i> Propiedades del marcador</small>
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
                            <input type="text" class="form-control" type="text" name="parametro_nombre[]" value="<?php echo $nombre; ?>" />
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
            <?php } ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
</form>