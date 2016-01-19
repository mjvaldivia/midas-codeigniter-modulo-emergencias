<?php echo $js; ?>
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<div class="row row-mapa">
    <div id="mapa"></div>
</div>
<?= loadJS("assets/js/modulo/mapa/front-end.js"); ?>