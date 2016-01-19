<?php echo $js; ?>
<form name="form_reporte_emergencia" id ="form_reporte_emergencia">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    
    <div class="row">
        <div class="col-lg-12">
            <div id="mapa"></div>
        </div>
    </div>
    
</form>
<?= loadJS("assets/lib/html2canvas/build/html2canvas.js"); ?>
<?= loadJS("assets/js/modulo/emergencia/reporte.js"); ?>
