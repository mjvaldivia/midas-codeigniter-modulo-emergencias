<p>Los items relacionados con estas comunas no han sido guardados por no coincidencia del nombre de las comunas entre el geojson y la base de datos</p>

<ul>
    <?php foreach($comunas as $comuna):?>
    <li><?php echo $comuna?>
    <?php endforeach;?>
</ul>

<div class="col-xs-12 text-center">
    <button class="btn btn-info btn-square" type="button" onclick="xModal.open('<?php echo base_url('capas/verComunas')?>','Listado de Comunas','lg');">Ver Listado de Comunas</button>
    <button type="button" class="btn btn-danger btn-square" onclick="Layer.eliminarInformacionComunas(<?php echo $capa?>,this);">Eliminar información</button>
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>