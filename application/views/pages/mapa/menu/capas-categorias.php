<?php if(count($lista)>0){ ?>

<?php foreach($lista as $categoria) { ?>

<?php
    $cantidad = cantidadCapasCategoria($categoria["ccb_ia_categoria"], $id_emergencia);
?>
<li <?php if($cantidad > 0) { ?> class="dropdown-submenu lala" <?php } ?>>
    <a href="#" <?php if($cantidad > 0) { ?> class="dropdown-toggle" data-toggle="dropdown" <?php } ?>><?php echo $categoria["ccb_c_categoria"]; ?></a>
    <?php echo visorMenuCapas($id_emergencia, $categoria["ccb_ia_categoria"]); ?>
</li>
<?php } ?>

<?php } ?>