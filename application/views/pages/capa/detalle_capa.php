<div id="contenedor-grilla-detalle-capa" class="small">

</div>

<div class="text-center top-spaced">
    <button type="button" class="btn btn-square btn-default" onclick="xModal.close();">Cerrar</button>
</div>

<script>
    $(document).ready(function(){
        Layer.cargarDetalleCapa(<?php echo $capa?>);
    });
</script>