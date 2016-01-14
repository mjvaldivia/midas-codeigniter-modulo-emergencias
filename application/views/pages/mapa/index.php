<?= loadCSS("assets/css/modulo/mapa.css"); ?>

<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<div class="row">
    <div id="mapa" style="height: 1000px"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadJS("assets/js/geo-encoder.js"); ?>
<?= loadJS("assets/js/bootbox.min.js") ?>

<?= loadCSS("assets/js/modulo/mapa/extencion/maps.google.buttons.css") ?>
<?= loadJS("assets/js/modulo/mapa/extencion/maps.google.polygon.containsLatLng.js"); ?>
<?= loadJS("assets/js/modulo/mapa/extencion/maps.google.buttons.js"); ?>

<?= loadJS("assets/js/modulo/mapa/informacion/elemento.js"); ?>
<?= loadJS("assets/js/modulo/mapa/circulo/click_listener.js"); ?>
<?= loadJS("assets/js/modulo/mapa/poligono.js"); ?>
<?= loadJS("assets/js/modulo/mapa/poligono/poligono_multi.js"); ?>

<?= loadJS("assets/js/modulo/mapa/marcador.js"); ?>
<?= loadJS("assets/js/modulo/mapa/marcador/lugar_emergencia.js"); ?>


<?= loadJS("assets/js/modulo/mapa/editor.js"); ?>
<?= loadJS("assets/js/modulo/mapa/capa.js"); ?>

<?= loadJS("assets/js/modulo/mapa/visor.js"); ?>


<?= loadJS("assets/js/modulo/mapa/front-end.js"); ?>