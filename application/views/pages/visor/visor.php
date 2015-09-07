<style type="text/css">
    @media (max-width: 480px) {
        #input-buscador-mapa {
            width: 155px
        }
    }
</style>


<input id="input-buscador-mapa" class="map-controls" type="text" placeholder="Buscador de dirección"/>
<div id="capture"></div>
<div id="mapa" class="col-md-12 visor-emergencias">
</div>

<script type="text/javascript" src="<?= base_url("/assets/js/visor.js") ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        VisorMapa.init();
    });
</script>