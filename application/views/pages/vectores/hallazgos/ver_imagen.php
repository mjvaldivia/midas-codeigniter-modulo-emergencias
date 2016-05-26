<div class="col-xs-12" style="overflow: hidden">
    <p>Imagen agregada el <?php echo $fecha; ?></p>
    <div class="row text-center" >
        <img class="img-responsive" src="<?php echo base_url($ruta . '/' . $nombre) ?>"/>
    </div>
    <?php if($boton):?>
    <div class="text-right" style="margin:5px;">
        <button type="button" class="btn btn-primary btn-square" onclick="window.open('<?php echo base_url('vectores_hallazgos/verImagenInspeccion/id/' . $id . '/sha/' . $sha) ?>','_blank')">Ver en otra pestaña</button>
    </div>
    <?php endif;?>
</div>