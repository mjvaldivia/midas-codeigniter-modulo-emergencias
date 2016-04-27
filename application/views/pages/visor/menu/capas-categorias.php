<?php if(count($lista)>0){ ?>

<?php foreach($lista as $categoria) { ?>

<?php
    $cantidad = cantidadCapasCategoriaRegion($categoria["ccb_ia_categoria"], $id);
?>
<li class="divider"></li>
<li <?php if($cantidad > 0) { ?> class="dropdown-submenu lala" <?php } ?>>
    <a href="javascript:void(0)" <?php if($cantidad > 0) { ?> class="dropdown-toggle" data-toggle="dropdown" <?php } ?>><?php echo $categoria["ccb_c_categoria"]; ?></a>
    <?php  echo visorMenuCapasRegion($id, $categoria["ccb_ia_categoria"]); ?>
</li>

<?php } ?>

<?php } ?>

