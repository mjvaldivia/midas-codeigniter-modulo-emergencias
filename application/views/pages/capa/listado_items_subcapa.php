<div class="portlet portlet-dark-blue">
    <div class="portlet-heading">
        <div class="portlet-title"><h4>Elementos de la subcapa
        <?php if($agregar_item):?>
                <button type="button" class="btn btn-success btn-square" onclick="xModal.open('<?php echo site_url('capas/nuevoItemSubCapa/subcapa/'.$subcapa);?>','Nuevo Elemento',85);">Agregar Elemento</button>
            <?php endif;?>
            </h4></div>
    </div>
    <div class="portlet-body">
        <div class="col-xs-12">
            <div class="row">
            
                <div id="contenedor-items-subcapa" class="small table-responsive"></div>

                <div id="contenedor-editar-item"></div>
            </div>
        </div>

        <div class="top-spaced text-center">
            <button type="button" class="btn btn-default btn-square" onclick="xModal.close();">Cerrar Ventana</button>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function(){
        Layer.listarItemsSubCapa(<?php echo $subcapa?>);
    });
</script>