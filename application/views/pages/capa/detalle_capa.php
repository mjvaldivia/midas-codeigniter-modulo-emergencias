<div id="contenedor-grilla-detalle-capa" class="small">

</div>

<div class="text-center top-spaced">
    <button type="button" class="btn btn-square btn-default" onclick="xModal.close();">Cerrar</button>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            dataType: "html",
            cache: false,
            async: true,
            data: {id_capa:<?php echo $capa?>},
            type: "post",
            url: siteUrl + "capas/ajax_grilla_capas",
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(html){
                $("#contenedor-grilla-detalle-capa").html(html);
            }
        });
    });
</script>