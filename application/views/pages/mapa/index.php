<?= loadCSS("assets/css/modulo/mapa.css") ?>

<div class="row">
    <div id="mapa" style="height: 1000px"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>
<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/modulo/mapa/visor.js") ?>
<?= loadJS("assets/js/modulo/mapa/mapa.js") ?>