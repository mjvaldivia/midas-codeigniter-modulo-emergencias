<?php echo $js; ?>
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

<div id="busqueda" class="input-group">
    <span class="input-group-addon"><i class="fa fa-search"></i></span>
    <input id="pac-input" class="form-control" type="text" placeholder="Buscar dirección">
</div>




<div class="row row-mapa">
    <div id="mapa">
        <div class="col-lg-12 text-center" style="padding-top: 200px">
        <i class="fa fa-4x fa-spin fa-spinner"></i>
        </div>
    </div>
</div>
<?= loadJS("assets/js/modulo/mapa/front-end.js"); ?>